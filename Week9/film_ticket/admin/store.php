<?php
require_once __DIR__ . '/controllers/FilmController.php';

$controller = new FilmController();
$controller->store();
?>