<?php
// controllers/MovieController.php
require_once 'config/database.php';
require_once 'models/Movie.php';

class MovieController {
    private $db;
    private $movie;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->movie = new Movie($this->db);
    }

    // Tampilkan semua film
    public function index() {
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if($search != '') {
            $stmt = $this->movie->search($search);
        } else if($filter != 'all') {
            $stmt = $this->movie->readByStatus($filter);
        } else {
            $stmt = $this->movie->readAll();
        }

        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require_once 'views/movie/index.php';
    }

    // Tampilkan form tambah film
    public function create() {
        require_once 'views/movie/create.php';
    }

    // Proses tambah film
    public function store() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->movie->title = $_POST['title'];
            $this->movie->director = $_POST['director'];
            $this->movie->genre = $_POST['genre'];
            $this->movie->duration = $_POST['duration'];
            $this->movie->release_date = $_POST['release_date'];
            $this->movie->status = $_POST['status'];
            $this->movie->synopsis = $_POST['synopsis'];
            $this->movie->poster_url = $_POST['poster_url'];

            if($this->movie->create()) {
                header("Location: index.php?message=Film berhasil ditambahkan");
                exit();
            } else {
                header("Location: index.php?action=create&error=Gagal menambahkan film");
                exit();
            }
        }
    }

    // Tampilkan form edit film
    public function edit() {
        if(isset($_GET['id'])) {
            $this->movie->id = $_GET['id'];
            if($this->movie->readOne()) {
                require_once 'views/movie/edit.php';
            } else {
                header("Location: index.php?error=Film tidak ditemukan");
                exit();
            }
        }
    }

    // Proses update film
    public function update() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->movie->id = $_POST['id'];
            $this->movie->title = $_POST['title'];
            $this->movie->director = $_POST['director'];
            $this->movie->genre = $_POST['genre'];
            $this->movie->duration = $_POST['duration'];
            $this->movie->release_date = $_POST['release_date'];
            $this->movie->status = $_POST['status'];
            $this->movie->synopsis = $_POST['synopsis'];
            $this->movie->poster_url = $_POST['poster_url'];

            if($this->movie->update()) {
                header("Location: index.php?message=Film berhasil diupdate");
                exit();
            } else {
                header("Location: index.php?action=edit&id=" . $this->movie->id . "&error=Gagal mengupdate film");
                exit();
            }
        }
    }

    // Proses hapus film
    public function delete() {
        if(isset($_GET['id'])) {
            $this->movie->id = $_GET['id'];
            if($this->movie->delete()) {
                header("Location: index.php?message=Film berhasil dihapus");
                exit();
            } else {
                header("Location: index.php?error=Gagal menghapus film");
                exit();
            }
        }
    }

    // Tampilkan detail film
    public function show() {
        if(isset($_GET['id'])) {
            $this->movie->id = $_GET['id'];
            if($this->movie->readOne()) {
                require_once 'views/movie/show.php';
            } else {
                header("Location: index.php?error=Film tidak ditemukan");
                exit();
            }
        }
    }
}
?>+