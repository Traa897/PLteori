<?php
// models/Validator.php - OOP dengan Inheritance, Abstraction, Encapsulation, Polymorphism

// Abstract Base Validator
abstract class BaseValidator {
    protected $errors = [];
    protected $data = [];
    
    public function __construct($data = []) {
        $this->data = $data;
    }
    
    // Abstract method - harus diimplementasi child
    abstract public function validate();
    
    // Encapsulation - protected method
    protected function addError($field, $message) {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }
        $this->errors[$field][] = $message;
    }
    
    // Encapsulation - getter
    public function getErrors() {
        return $this->errors;
    }
    
    public function hasErrors() {
        return !empty($this->errors);
    }
    
    public function getFirstError($field = null) {
        if ($field) {
            return $this->errors[$field][0] ?? null;
        }
        
        foreach ($this->errors as $fieldErrors) {
            return $fieldErrors[0] ?? null;
        }
        
        return null;
    }
    
    // Protected validation methods
    protected function validateRequired($field, $message = null) {
        if (!isset($this->data[$field]) || trim($this->data[$field]) === '') {
            $this->addError($field, $message ?? "Field {$field} wajib diisi");
        }
    }
    
    protected function validateEmail($field, $message = null) {
        if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, $message ?? "Email tidak valid");
        }
    }
    
    protected function validateMin($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) < $length) {
            $this->addError($field, $message ?? "Field {$field} minimal {$length} karakter");
        }
    }
    
    protected function validateMax($field, $length, $message = null) {
        if (isset($this->data[$field]) && strlen($this->data[$field]) > $length) {
            $this->addError($field, $message ?? "Field {$field} maksimal {$length} karakter");
        }
    }
    
    protected function validateNumeric($field, $message = null) {
        if (isset($this->data[$field]) && !is_numeric($this->data[$field])) {
            $this->addError($field, $message ?? "Field {$field} harus berupa angka");
        }
    }
    
    protected function validateRange($field, $min, $max, $message = null) {
        if (isset($this->data[$field])) {
            $value = (float)$this->data[$field];
            if ($value < $min || $value > $max) {
                $this->addError($field, $message ?? "Field {$field} harus antara {$min} dan {$max}");
            }
        }
    }
    
    protected function validateUrl($field, $message = null) {
        if (isset($this->data[$field]) && trim($this->data[$field]) !== '' && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
            $this->addError($field, $message ?? "URL tidak valid");
        }
    }
}

// Polymorphism - FilmValidator extends BaseValidator
class FilmValidator extends BaseValidator {
    public function validate() {
        $this->validateRequired('judul_film', 'Judul film wajib diisi');
        $this->validateMax('judul_film', 200, 'Judul film maksimal 200 karakter');
        
        $this->validateRequired('tahun_rilis', 'Tahun rilis wajib diisi');
        $this->validateNumeric('tahun_rilis', 'Tahun rilis harus berupa angka');
        $this->validateRange('tahun_rilis', 1900, 2100, 'Tahun rilis harus antara 1900-2100');
        
        $this->validateRequired('durasi_menit', 'Durasi wajib diisi');
        $this->validateNumeric('durasi_menit', 'Durasi harus berupa angka');
        $this->validateRange('durasi_menit', 1, 500, 'Durasi harus antara 1-500 menit');
        
        $this->validateRequired('sipnosis', 'Sinopsis wajib diisi');
        
        $this->validateRequired('rating', 'Rating wajib diisi');
        $this->validateNumeric('rating', 'Rating harus berupa angka');
        $this->validateRange('rating', 0, 10, 'Rating harus antara 0-10');
        
        if (isset($this->data['poster_url']) && trim($this->data['poster_url']) !== '') {
            $this->validateUrl('poster_url', 'URL poster tidak valid');
        }
        
        $this->validateRequired('id_genre', 'Genre wajib dipilih');
        
        return !$this->hasErrors();
    }
}

// Polymorphism - JadwalValidator extends BaseValidator
class JadwalValidator extends BaseValidator {
    private $db;
    
    public function __construct($data, $db) {
        parent::__construct($data);
        $this->db = $db;
    }
    
    public function validate() {
        $this->validateRequired('id_film', 'Film wajib dipilih');
        $this->validateRequired('id_bioskop', 'Bioskop wajib dipilih');
        $this->validateRequired('tanggal_tayang', 'Tanggal tayang wajib diisi');
        $this->validateRequired('jam_mulai', 'Jam mulai wajib diisi');
        $this->validateRequired('jam_selesai', 'Jam selesai wajib diisi');
        $this->validateRequired('harga_tiket', 'Harga tiket wajib diisi');
        
        if (!$this->hasErrors()) {
            $this->validatePresaleConflict();
        }
        
        return !$this->hasErrors();
    }
    
    private function validatePresaleConflict() {
        $id_film = $this->data['id_film'];
        $tanggal_tayang = $this->data['tanggal_tayang'];
        
        // Cek pre-sale
        $query = "SELECT COUNT(*) as count FROM Jadwal_Tayang 
                  WHERE id_film = :id_film 
                  AND DATEDIFF(tanggal_tayang, CURDATE()) > 7";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_film', $id_film);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            $today = date('Y-m-d');
            $selisihHari = floor((strtotime($tanggal_tayang) - strtotime($today)) / 86400);
            
            if ($selisihHari <= 7) {
                $this->addError('tanggal_tayang', 'Film ini sudah memiliki jadwal pre-sale (>7 hari). Tidak bisa menambah jadwal dalam 7 hari ke depan!');
            }
        }
    }
}

// Polymorphism - UserValidator extends BaseValidator
class UserValidator extends BaseValidator {
    private $db;
    private $excludeId;
    
    public function __construct($data, $db, $excludeId = null) {
        parent::__construct($data);
        $this->db = $db;
        $this->excludeId = $excludeId;
    }
    
    public function validate() {
        $this->validateRequired('username', 'Username wajib diisi');
        $this->validateMin('username', 3, 'Username minimal 3 karakter');
        $this->validateMax('username', 50, 'Username maksimal 50 karakter');
        
        $this->validateRequired('email', 'Email wajib diisi');
        $this->validateEmail('email', 'Format email tidak valid');
        
        if (isset($this->data['password']) && $this->data['password'] !== '') {
            $this->validateMin('password', 6, 'Password minimal 6 karakter');
        }
        
        $this->validateRequired('nama_lengkap', 'Nama lengkap wajib diisi');
        
        if (!$this->hasErrors()) {
            $this->validateUniqueUsername();
            $this->validateUniqueEmail();
        }
        
        return !$this->hasErrors();
    }
    
    private function validateUniqueUsername() {
        $query = "SELECT COUNT(*) as count FROM User WHERE username = :username";
        if ($this->excludeId) {
            $query .= " AND id_user != :id";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $this->data['username']);
        if ($this->excludeId) {
            $stmt->bindParam(':id', $this->excludeId);
        }
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            $this->addError('username', 'Username sudah digunakan');
        }
    }
    
    private function validateUniqueEmail() {
        $query = "SELECT COUNT(*) as count FROM User WHERE email = :email";
        if ($this->excludeId) {
            $query .= " AND id_user != :id";
        }
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $this->data['email']);
        if ($this->excludeId) {
            $stmt->bindParam(':id', $this->excludeId);
        }
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            $this->addError('email', 'Email sudah digunakan');
        }
    }
}

// Polymorphism - BioskopValidator extends BaseValidator
class BioskopValidator extends BaseValidator {
    public function validate() {
        $this->validateRequired('nama_bioskop', 'Nama bioskop wajib diisi');
        $this->validateRequired('kota', 'Kota wajib dipilih');
        $this->validateRequired('alamat_bioskop', 'Alamat wajib diisi');
        $this->validateRequired('jumlah_studio', 'Jumlah studio wajib diisi');
        $this->validateNumeric('jumlah_studio', 'Jumlah studio harus berupa angka');
        $this->validateRange('jumlah_studio', 1, 20, 'Jumlah studio harus antara 1-20');
        
        return !$this->hasErrors();
    }
}
?>