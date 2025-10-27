<?php
class Genre {
    private $conn;
    private $table_name = "genres";

    public $id;
    public $name;
    public $slug;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ambil semua genre
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Ambil genre berdasarkan ID
    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->name = $row['name'];
            $this->slug = $row['slug'];
            return true;
        }
        return false;
    }
}
?>