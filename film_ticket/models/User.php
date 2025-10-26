<?php
// models/User.php
class User {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Register user baru
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                  (username, email, password, full_name, role) 
                  VALUES 
                  (:username, :email, :password, :full_name, :role)";
        
        $stmt = $this->conn->prepare($query);

        // Hash password
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Bind
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':role', $this->role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Login
    public function login() {
        $query = "SELECT id, username, email, password, full_name, role 
                  FROM " . $this->table . " 
                  WHERE username = :username OR email = :username 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            
            // Verify password
            if(password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->full_name = $row['full_name'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // Check if username exists
    public function usernameExists() {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Check if email exists
    public function emailExists() {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>