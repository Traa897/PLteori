<?php
class Movie {
    private $conn;
    private $table_name = "movies";

    public $id;
    public $title;
    public $director;
    public $genre_id;
    public $duration;
    public $release_date;
    public $status;
    public $rating;
    public $synopsis;
    public $poster_url;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Tambah film baru
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET title=:title, director=:director, genre_id=:genre_id, 
                      duration=:duration, release_date=:release_date, 
                      status=:status, rating=:rating, synopsis=:synopsis, 
                      poster_url=:poster_url";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->genre_id = htmlspecialchars(strip_tags($this->genre_id));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->synopsis = htmlspecialchars(strip_tags($this->synopsis));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));

        // Bind
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":director", $this->director);
        $stmt->bindParam(":genre_id", $this->genre_id);
        $stmt->bindParam(":duration", $this->duration);
        $stmt->bindParam(":release_date", $this->release_date);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":synopsis", $this->synopsis);
        $stmt->bindParam(":poster_url", $this->poster_url);

        return $stmt->execute();
    }

    // READ ALL - Dengan JOIN ke tabel genres
    public function readAll() {
        $query = "SELECT m.*, g.name as genre_name 
                  FROM " . $this->table_name . " m
                  LEFT JOIN genres g ON m.genre_id = g.id
                  ORDER BY m.release_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ BY STATUS
    public function readByStatus($status) {
        $query = "SELECT m.*, g.name as genre_name 
                  FROM " . $this->table_name . " m
                  LEFT JOIN genres g ON m.genre_id = g.id
                  WHERE m.status = :status 
                  ORDER BY m.release_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->execute();
        return $stmt;
    }

    // READ ONE
    public function readOne() {
        $query = "SELECT m.*, g.name as genre_name 
                  FROM " . $this->table_name . " m
                  LEFT JOIN genres g ON m.genre_id = g.id
                  WHERE m.id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->title = $row['title'];
            $this->director = $row['director'];
            $this->genre_id = $row['genre_id'];
            $this->duration = $row['duration'];
            $this->release_date = $row['release_date'];
            $this->status = $row['status'];
            $this->rating = $row['rating'];
            $this->synopsis = $row['synopsis'];
            $this->poster_url = $row['poster_url'];
            return true;
        }
        return false;
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table_name . " 
                  SET title=:title, director=:director, genre_id=:genre_id, 
                      duration=:duration, release_date=:release_date, 
                      status=:status, rating=:rating, synopsis=:synopsis, 
                      poster_url=:poster_url 
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->genre_id = htmlspecialchars(strip_tags($this->genre_id));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->synopsis = htmlspecialchars(strip_tags($this->synopsis));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':director', $this->director);
        $stmt->bindParam(':genre_id', $this->genre_id);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':release_date', $this->release_date);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':synopsis', $this->synopsis);
        $stmt->bindParam(':poster_url', $this->poster_url);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        return $stmt->execute();
    }

    // READ BY GENRE
    public function readByGenre($genre_id) {
        $query = "SELECT m.*, g.name as genre_name 
                    FROM " . $this->table_name . " m
                    LEFT JOIN genres g ON m.genre_id = g.id
                    WHERE m.genre_id = :genre_id 
                    ORDER BY m.release_date DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();
        return $stmt;
    }

    // SEARCH
    public function search($keyword) {
        $query = "SELECT m.*, g.name as genre_name 
                  FROM " . $this->table_name . " m
                  LEFT JOIN genres g ON m.genre_id = g.id
                  WHERE m.title LIKE :keyword OR m.director LIKE :keyword 
                  ORDER BY m.release_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        return $stmt;
    }
}
?>