<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ve se o gestor está devidamente logado
if (!isset($_SESSION['gestor_logged']) || $_SESSION['gestor_logged'] !== true) {
    $loginUrl = defined('BASE_URL') ? BASE_URL . 'login.php' : 'login.php';
    header('Location: ' . $loginUrl);
    exit;
}
