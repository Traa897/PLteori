<?php
// controllers/AuthController.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->user = new User($this->db);
    }

    // Show login form
    public function showLogin() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Show register form
    public function showRegister() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // Process login
    public function login() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->password = $_POST['password'];

            if($this->user->login()) {
                // Set session
                session_start();
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['full_name'] = $this->user->full_name;
                $_SESSION['role'] = $this->user->role;

                // Redirect based on role
                if($this->user->role === 'admin') {
                    header("Location: admin/index.php");
                } else {
                    header("Location: user/index.php");
                }
                exit();
            } else {
                header("Location: login.php?error=Username atau password salah");
                exit();
            }
        }
    }

    // Process register
    public function register() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->user->username = $_POST['username'];
            $this->user->email = $_POST['email'];
            $this->user->password = $_POST['password'];
            $this->user->full_name = $_POST['full_name'];
            $this->user->role = 'user'; // Default role

            // Validate
            if($this->user->usernameExists()) {
                header("Location: register.php?error=Username sudah digunakan");
                exit();
            }

            if($this->user->emailExists()) {
                header("Location: register.php?error=Email sudah terdaftar");
                exit();
            }

            if($_POST['password'] !== $_POST['confirm_password']) {
                header("Location: register.php?error=Password tidak cocok");
                exit();
            }

            if($this->user->register()) {
                header("Location: login.php?message=Registrasi berhasil! Silakan login");
                exit();
            } else {
                header("Location: register.php?error=Registrasi gagal");
                exit();
            }
        }
    }

    // Logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: login.php?message=Anda telah logout");
        exit();
    }
}
?>