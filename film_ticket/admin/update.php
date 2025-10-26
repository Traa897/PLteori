<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once __DIR__ . '/../controllers/FilmController.php';

$controller = new FilmController();
$controller->update();
?>