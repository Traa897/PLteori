<?php
require_once __DIR__ . '/controllers/FilmController.php';

if(!isset($_GET['id'])) {
    header("Location: index.php?error=ID film tidak ditemukan");
    exit();
}

$controller = new FilmController();
$controller->delete($_GET['id']);
?>