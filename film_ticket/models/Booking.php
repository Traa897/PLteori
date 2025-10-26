<?php
// models/Booking.php
class Booking {
    private $conn;
    private $table = "bookings";

    public $id;
    public $user_id;
    public $film_id;
    public $show_date;
    public $show_time;
    public $quantity;
    public $total_price;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create booking
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (user_id, film_id, show_date, show_time, quantity, total_price, status) 
                  VALUES 
                  (:user_id, :film_id, :show_date, :show_time, :quantity, :total_price, :status)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':film_id', $this->film_id);
        $stmt->bindParam(':show_date', $this->show_date);
        $stmt->bindParam(':show_time', $this->show_time);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':total_price', $this->total_price);
        $stmt->bindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get user bookings
    public function getUserBookings($user_id) {
        $query = "SELECT b.*, f.title, f.poster_url, f.genre, f.duration 
                  FROM " . $this->table . " b
                  LEFT JOIN films f ON b.film_id = f.id
                  WHERE b.user_id = :user_id
                  ORDER BY b.booking_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt;
    }

    // Get all bookings (admin)
    public function getAllBookings() {
        $query = "SELECT b.*, f.title, u.username, u.full_name 
                  FROM " . $this->table . " b
                  LEFT JOIN films f ON b.film_id = f.id
                  LEFT JOIN users u ON b.user_id = u.id
                  ORDER BY b.booking_date DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Update booking status
    public function updateStatus() {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Cancel booking
    public function cancel() {
        $this->status = 'cancelled';
        return $this->updateStatus();
    }
}
?>