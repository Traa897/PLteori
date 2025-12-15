<?php
// controllers/FilmController.php - FIXED dengan Validator

require_once 'config/database.php';
require_once 'models/BaseModel.php';
require_once 'models/Film.php';
require_once 'models/Genre.php';
require_once 'models/Validator.php';

class FilmController {
    private $db;
    private $film;
    private $genre;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->film = new Film($this->db);
        $this->genre = new Genre($this->db);
    }

    public function index() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $genre_filter = isset($_GET['genre']) ? $_GET['genre'] : '';
        $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
        
        $isAdmin = isset($_SESSION['admin_id']);

        if($status_filter != '') {
            switch($status_filter) {
                case 'akan_tayang':
                    $stmt = $this->film->readAkanTayang();
                    break;
                case 'sedang_tayang':
                    $stmt = $this->film->readSedangTayang();
                    break;
                default:
                    $stmt = $isAdmin ? $this->film->readAllIncludingNoSchedule() : $this->film->readAll();
            }
        } elseif($search != '') {
            $stmt = $isAdmin ? $this->film->searchAllFilms($search) : $this->film->search($search);
        } elseif($genre_filter != '') {
            $stmt = $isAdmin ? $this->film->readByGenreAll($genre_filter) : $this->film->readByGenre($genre_filter);
        } else {
            $stmt = $isAdmin ? $this->film->readAllIncludingNoSchedule() : $this->film->readAll();
        }

        $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Deduplicate
        $uniqueFilms = [];
        $seenIds = [];
        
        foreach($films as $film) {
            $filmId = (int)$film['id_film'];
            if(!in_array($filmId, $seenIds, true)) {
                $seenIds[] = $filmId;
                $uniqueFilms[] = $film;
            }
        }
        
        $films = $uniqueFilms;
        
        foreach($films as $key => &$film) {
            $status = $this->film->getFilmStatus($film['id_film']);
            $film['status'] = $status;
            
            if($status_filter != '' && $status == null) {
                unset($films[$key]);
            }
        }
        unset($film);
        
        $films = array_values($films);
        
        $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
        
        $countAkanTayang = $this->film->countByStatus('akan_tayang');
        $countSedangTayang = $this->film->countByStatus('sedang_tayang');
        
        require_once 'views/film/index.php';
    }

    public function show() {
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            
            if($this->film->readOne()) {
                $filmData = [
                    'id_film' => $this->film->id_film,
                    'judul_film' => $this->film->judul_film,
                    'tahun_rilis' => $this->film->tahun_rilis,
                    'durasi_menit' => $this->film->durasi_menit,
                    'sipnosis' => $this->film->sipnosis,
                    'rating' => $this->film->rating,
                    'poster_url' => $this->film->poster_url,
                    'id_genre' => $this->film->id_genre,
                    'nama_genre' => $this->film->nama_genre ?? 'Unknown'
                ];
                
                require_once 'views/film/show.php';
            } else {
                header("Location: index.php?module=film&error=Film tidak ditemukan");
                exit();
            }
        } else {
            header("Location: index.php?module=film&error=Film tidak ditemukan");
            exit();
        }
    }

    public function create() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['admin_id'])) {
            $_SESSION['flash'] = 'Anda harus login sebagai admin untuk mengakses halaman ini!';
            header("Location: index.php?module=film");
            exit();
        }
        
        $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/film/create.php';
    }

    public function store() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['admin_id'])) {
            $_SESSION['flash'] = 'Anda harus login sebagai admin!';
            header("Location: index.php?module=film");
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi dengan OOP Validator
            $validator = new FilmValidator($_POST);
            
            if (!$validator->validate()) {
                $_SESSION['flash'] = $validator->getFirstError();
                $_SESSION['old_data'] = $_POST;
                header("Location: index.php?module=admin&action=createFilm");
                exit();
            }
            
            // Check duplicate
            $queryCheck = "SELECT COUNT(*) as count FROM Film WHERE judul_film = :judul_film";
            $stmtCheck = $this->db->prepare($queryCheck);
            $stmtCheck->bindParam(':judul_film', $_POST['judul_film']);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);
            
            if($resultCheck['count'] > 0) {
                $_SESSION['flash'] = 'Film dengan judul tersebut sudah ada!';
                header("Location: index.php?module=admin&action=createFilm");
                exit();
            }
            
            $this->film->judul_film = $_POST['judul_film'];
            $this->film->tahun_rilis = $_POST['tahun_rilis'];
            $this->film->durasi_menit = $_POST['durasi_menit'];
            $this->film->sipnosis = $_POST['sipnosis'];
            $this->film->rating = $_POST['rating'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->id_genre = $_POST['id_genre'];

            if($this->film->create()) {
                $_SESSION['flash'] = 'Film berhasil ditambahkan!';
                header("Location: index.php?module=admin&action=dashboard");
                exit();
            } else {
                $_SESSION['flash'] = 'Gagal menambahkan film!';
                header("Location: index.php?module=film&action=create");
                exit();
            }
        }
    }

    public function edit() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['admin_id'])) {
            $_SESSION['flash'] = 'Anda harus login sebagai admin!';
            header("Location: index.php?module=film");
            exit();
        }
        
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            if($this->film->readOne()) {
                $genres = $this->genre->readAll()->fetchAll(PDO::FETCH_ASSOC);
                require_once 'views/film/edit.php';
            } else {
                $_SESSION['flash'] = 'Film tidak ditemukan!';
                header("Location: index.php?module=film");
                exit();
            }
        }
    }

    public function update() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['admin_id'])) {
            $_SESSION['flash'] = 'Anda harus login sebagai admin!';
            header("Location: index.php?module=film");
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi
            $validator = new FilmValidator($_POST);
            
            if (!$validator->validate()) {
                $_SESSION['flash'] = $validator->getFirstError();
                header("Location: index.php?module=film&action=edit&id=" . $_POST['id_film']);
                exit();
            }
            
            $this->film->id_film = $_POST['id_film'];
            $this->film->judul_film = $_POST['judul_film'];
            $this->film->tahun_rilis = $_POST['tahun_rilis'];
            $this->film->durasi_menit = $_POST['durasi_menit'];
            $this->film->sipnosis = $_POST['sipnosis'];
            $this->film->rating = $_POST['rating'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->id_genre = $_POST['id_genre'];

            if($this->film->update()) {
                $_SESSION['flash'] = 'Film berhasil diupdate!';
                header("Location: index.php?module=admin&action=dashboard");
                exit();
            } else {
                $_SESSION['flash'] = 'Gagal mengupdate film!';
                header("Location: index.php?module=film&action=edit&id=" . $this->film->id_film);
                exit();
            }
        }
    }

    public function delete() {
        if(session_status() == PHP_SESSION_NONE) session_start();
        
        if(!isset($_SESSION['admin_id'])) {
            $_SESSION['flash'] = 'Anda harus login sebagai admin!';
            header("Location: index.php?module=film");
            exit();
        }
        
        if(isset($_GET['id'])) {
            $this->film->id_film = $_GET['id'];
            if($this->film->delete()) {
                $_SESSION['flash'] = 'Film berhasil dihapus!';
            } else {
                $_SESSION['flash'] = 'Gagal menghapus film!';
            }
            
            header("Location: index.php?module=admin&action=dashboard");
            exit();
        }
    }
}
?>