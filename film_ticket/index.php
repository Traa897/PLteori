<?php
session_start();

// Jika sudah login, redirect ke dashboard
if(isset($_SESSION['user_id'])) {
    if($_SESSION['role'] === 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: user/index.php");
    }
    exit();
}

// Jika belum login, redirect ke login
header("Location: login.php");
exit();
?>