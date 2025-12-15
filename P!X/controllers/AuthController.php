<?php
// controllers/AuthController.php - FIXED VERSION
require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Admin.php';

class AuthController {
    private $db;
    private $user;
    private $admin;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
        $this->admin = new Admin($this->db);
        
        if(session_status() == PHP_SESSION_NONE) session_start();
    }

    // Show Login Form
    public function index() {
        require_once 'views/auth/login.php';
    }

    // Process Login
    public function login() {
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?module=auth&action=index');
            exit();
        }

        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $query = "SELECT * FROM Admin WHERE username = :username LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $adminCheck = $stmt->fetch(PDO::FETCH_ASSOC);

        $role = $adminCheck ? 'admin' : 'user';

        if($role === 'admin') {
            // ADMIN LOGIN
            $query = "SELECT * FROM Admin WHERE username = :username LIMIT 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($admin) {
                $passwordValid = false;
                
                if($admin['password'] === $password) {
                    $passwordValid = true;
                }
                elseif(password_verify($password, $admin['password'])) {
                    $passwordValid = true;
                }
                
                if($passwordValid) {
                    $_SESSION['admin_id'] = $admin['id_admin'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_name'] = $admin['nama_lengkap'];
                    $_SESSION['admin_role'] = $admin['role'];
                    $_SESSION['flash'] = 'Selamat datang, Admin ' . $admin['nama_lengkap'] . '!';
                    
                    header('Location: index.php?module=admin&action=dashboard');
                    exit();
                }
            }
            
            $error = 'Username atau password admin salah';
            require_once 'views/auth/login.php';
            
        } else {
            // USER LOGIN
            $user = $this->user->verifyLogin($username, $password);
            if($user) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['user_name'] = $user['nama_lengkap'];
                $_SESSION['flash'] = 'Selamat datang, ' . $user['nama_lengkap'] . '!';
                
                header('Location: index.php?module=user&action=dashboard');
                exit();
            } else {
                $error = 'Username atau password salah, atau akun nonaktif';
                require_once 'views/auth/login.php';
            }
        }
    }

    // Show Register Form
    public function register() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = isset($_POST['username']) ? trim($_POST['username']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '';
            $no_telpon = isset($_POST['no_telpon']) ? trim($_POST['no_telpon']) : '';

            if($username === '' || $email === '' || $password === '' || $nama_lengkap === '') {
                $error = 'Semua field wajib diisi';
                require_once 'views/auth/register.php';
                return;
            }

            if($this->user->usernameExists($username)) {
                $error = 'Username sudah digunakan';
                require_once 'views/auth/register.php';
                return;
            }

            if($this->user->emailExists($email)) {
                $error = 'Email sudah digunakan';
                require_once 'views/auth/register.php';
                return;
            }

            $this->user->username = $username;
            $this->user->email = $email;
            $this->user->password = $password;
            $this->user->nama_lengkap = $nama_lengkap;
            $this->user->no_telpon = $no_telpon;
            $this->user->tanggal_lahir = isset($_POST['tanggal_lahir']) ? $_POST['tanggal_lahir'] : null;
            $this->user->alamat = isset($_POST['alamat']) ? $_POST['alamat'] : null;

            if($this->user->create()) {
                $_SESSION['flash'] = 'Akun berhasil dibuat! Silakan login.';
                header('Location: index.php?module=auth&action=index');
                exit();
            } else {
                $error = 'Gagal membuat akun. Coba lagi.';
                require_once 'views/auth/register.php';
            }
        } else {
            require_once 'views/auth/register.php';
        }
    }

    // FIXED: Logout - Redirect ke halaman public film
    public function logout() {
        // Start session jika belum
        if(session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Simpan pesan sebelum destroy session
        $isAdmin = isset($_SESSION['admin_id']);
        
        // Clear all session variables
        foreach (array_keys($_SESSION) as $key) {
            unset($_SESSION[$key]);
        }
        
        // Destroy session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy session
        session_destroy();
        
        // Start new session for flash message
        session_start();
        $_SESSION['flash'] = 'Anda telah logout';
        
        // Redirect ke halaman public film
        header('Location: index.php?module=film');
        exit();
    }
    
    // ADDED: Ganti Password untuk Admin
    public function gantiPasswordAdmin() {
        if(!isset($_SESSION['admin_id'])) {
            header('Location: index.php?module=auth&action=index');
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password_lama = $_POST['password_lama'] ?? '';
            $password_baru = $_POST['password_baru'] ?? '';
            $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
            
            // Validasi
            if($password_baru !== $konfirmasi_password) {
                $error = 'Password baru tidak cocok';
                require_once 'views/admin/ganti_password.php';
                return;
            }
            
            if(strlen($password_baru) < 6) {
                $error = 'Password minimal 6 karakter';
                require_once 'views/admin/ganti_password.php';
                return;
            }
            
            // Verifikasi password lama
            $query = "SELECT password FROM Admin WHERE id_admin = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $_SESSION['admin_id']);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $passwordValid = false;
            if($admin['password'] === $password_lama || password_verify($password_lama, $admin['password'])) {
                $passwordValid = true;
            }
            
            if(!$passwordValid) {
                $error = 'Password lama salah';
                require_once 'views/admin/ganti_password.php';
                return;
            }
            
            // Update password
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            $query = "UPDATE Admin SET password = :password WHERE id_admin = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':id', $_SESSION['admin_id']);
            
            if($stmt->execute()) {
                $_SESSION['flash'] = 'Password berhasil diubah!';
                header('Location: index.php?module=admin&action=dashboard');
                exit();
            } else {
                $error = 'Gagal mengubah password';
                require_once 'views/admin/ganti_password.php';
            }
        } else {
            require_once 'views/admin/ganti_password.php';
        }
    }
    
    // ADDED: Ganti Password untuk User
    public function gantiPasswordUser() {
        if(!isset($_SESSION['user_id'])) {
            header('Location: index.php?module=auth&action=index');
            exit();
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password_lama = $_POST['password_lama'] ?? '';
            $password_baru = $_POST['password_baru'] ?? '';
            $konfirmasi_password = $_POST['konfirmasi_password'] ?? '';
            
            // Validasi
            if($password_baru !== $konfirmasi_password) {
                $error = 'Password baru tidak cocok';
                require_once 'views/user/ganti_password.php';
                return;
            }
            
            if(strlen($password_baru) < 6) {
                $error = 'Password minimal 6 karakter';
                require_once 'views/user/ganti_password.php';
                return;
            }
            
            // Verifikasi password lama
            $query = "SELECT password FROM User WHERE id_user = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(!password_verify($password_lama, $user['password'])) {
                $error = 'Password lama salah';
                require_once 'views/user/ganti_password.php';
                return;
            }
            
            // Update password
            $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
            $query = "UPDATE User SET password = :password WHERE id_user = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            
            if($stmt->execute()) {
                $_SESSION['flash'] = 'Password berhasil diubah!';
                header('Location: index.php?module=user&action=dashboard');
                exit();
            } else {
                $error = 'Gagal mengubah password';
                require_once 'views/user/ganti_password.php';
            }
        } else {
            require_once 'views/user/ganti_password.php';
        }
    }
}
?>