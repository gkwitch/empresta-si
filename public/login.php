<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$controller = new AuthController();
$acao = $_GET['acao'] ?? 'login';


if ($acao === 'logout') {
    $controller->logout();
} else {
    $controller->login();
}
