<?php
// models/Movie.php
class Movie {
    private $conn;
    private $table_name = "movies";

    public $id;
    public $title;
    public $director;
    public $genre;
    public $duration;
    public $release_date;
    public $status;
    public $synopsis;
    public $poster_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Tambah data film baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET title=:title, director=:director, genre=:genre, 
                      duration=:duration, release_date=:release_date, 
                      status=:status, synopsis=:synopsis, poster_url=:poster_url";

        $stmt = $this->conn->prepare($query);

        // Sanitize input
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->synopsis = htmlspecialchars(strip_tags($this->synopsis));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));

        // Bind values
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":director", $this->director);
        $stmt->bindParam(":genre", $this->genre);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":release_date", $this->release_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":synopsis", $this->synopsis);
        $stmt->bindParam(":poster_url", $this->poster_url);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // READ - Ambil semua data film
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY release_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ BY STATUS - Ambil film berdasarkan status
    public function readByStatus($status) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE status = :status 
                  ORDER BY release_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        return $stmt;
    }

    // READ ONE - Ambil satu data film berdasarkan ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->title = $row['title'];
            $this->director = $row['director'];
            $this->genre = $row['genre'];
            $this->duration = $row['duration'];
            $this->release_date = $row['release_date'];
            $this->status = $row['status'];
            $this->synopsis = $row['synopsis'];
            $this->poster_url = $row['poster_url'];
            return true;
        }
        return false;
    }

    // UPDATE - Update data film
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title=:title, director=:director, genre=:genre, 
                      duration=:duration, release_date=:release_date, 
                      status=:status, synopsis=:synopsis, poster_url=:poster_url 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->synopsis = htmlspecialchars(strip_tags($this->synopsis));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':director', $this->director);
        $stmt->bindParam(':genre', $this->genre);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':release_date', $this->release_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':synopsis', $this->synopsis);
        $stmt->bindParam(':poster_url', $this->poster_url);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // SEARCH - Cari film berdasarkan judul
    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE title LIKE :keyword OR director LIKE :keyword OR genre LIKE :keyword 
                  ORDER BY release_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?>