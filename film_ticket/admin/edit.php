<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: index.php?error=ID film tidak ditemukan");
    exit();
}

require_once __DIR__ . '/../controllers/FilmController.php';

$controller = new FilmController();
$controller->edit($_GET['id']);
?>