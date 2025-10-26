<?php
class Film {
    private $conn;
    private $table = "films";

    public $id;
    public $title;
    public $genre;
    public $duration;
    public $release_date;
    public $price;
    public $director;
    public $description;
    public $poster_url;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ - Get all films
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY release_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ - Get single film
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (title, genre, duration, release_date, price, director, description, poster_url, status) 
                  VALUES 
                  (:title, :genre, :duration, :release_date, :price, :director, :description, :poster_url, :status)";
        
        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':genre', $this->genre);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':release_date', $this->release_date);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':director', $this->director);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':poster_url', $this->poster_url);
        $stmt->bindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE
    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET title = :title, 
                      genre = :genre, 
                      duration = :duration, 
                      release_date = :release_date, 
                      price = :price, 
                      director = :director, 
                      description = :description, 
                      poster_url = :poster_url, 
                      status = :status 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->genre = htmlspecialchars(strip_tags($this->genre));
        $this->duration = htmlspecialchars(strip_tags($this->duration));
        $this->release_date = htmlspecialchars(strip_tags($this->release_date));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->director = htmlspecialchars(strip_tags($this->director));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->poster_url = htmlspecialchars(strip_tags($this->poster_url));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':genre', $this->genre);
        $stmt->bindParam(':duration', $this->duration);
        $stmt->bindParam(':release_date', $this->release_date);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':director', $this->director);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':poster_url', $this->poster_url);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>