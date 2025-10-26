<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Film.php';

class FilmController {
    private $db;
    private $film;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->film = new Film($this->db);
    }

    // Display all films
    public function index() {
        $result = $this->film->read();
        $films = $result->fetchAll();
        require_once __DIR__ . '/../views/films/index.php';
    }

    // Show create form
    public function create() {
        require_once __DIR__ . '/../views/films/create.php';
    }

    // Store new film
    public function store() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->film->title = $_POST['title'];
            $this->film->genre = $_POST['genre'];
            $this->film->duration = $_POST['duration'];
            $this->film->release_date = $_POST['release_date'];
            $this->film->price = $_POST['price'];
            $this->film->director = $_POST['director'];
            $this->film->description = $_POST['description'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->status = $_POST['status'];

            if($this->film->create()) {
                header("Location: index.php?message=Film berhasil ditambahkan");
                exit();
            } else {
                header("Location: index.php?error=Gagal menambahkan film");
                exit();
            }
        }
    }

    // Show edit form
    public function edit($id) {
        $this->film->id = $id;
        $film = $this->film->readOne();
        require_once __DIR__ . '/../views/films/edit.php';
    }

    // Update film
    public function update() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->film->id = $_POST['id'];
            $this->film->title = $_POST['title'];
            $this->film->genre = $_POST['genre'];
            $this->film->duration = $_POST['duration'];
            $this->film->release_date = $_POST['release_date'];
            $this->film->price = $_POST['price'];
            $this->film->director = $_POST['director'];
            $this->film->description = $_POST['description'];
            $this->film->poster_url = $_POST['poster_url'];
            $this->film->status = $_POST['status'];

            if($this->film->update()) {
                header("Location: index.php?message=Film berhasil diupdate");
                exit();
            } else {
                header("Location: index.php?error=Gagal mengupdate film");
                exit();
            }
        }
    }

    // Delete film
    public function delete($id) {
        $this->film->id = $id;
        if($this->film->delete()) {
            header("Location: index.php?message=Film berhasil dihapus");
            exit();
        } else {
            header("Location: index.php?error=Gagal menghapus film");
            exit();
        }
    }

    // Show single film
    public function show($id) {
        $this->film->id = $id;
        $film = $this->film->readOne();
        require_once __DIR__ . '/../views/films/show.php';
    }
}
?>