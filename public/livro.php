<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$acao = $_GET['acao'] ?? 'listar';


if ($acao !== 'buscar') {
    require_once __DIR__ . '/../includes/auth_check.php';
}

$controller = new LivroController();


switch ($acao) {
    case 'listar':
        $controller->listar();
        break;
    case 'criar':
        $controller->criar();
        break;
    case 'editar':
        $controller->editar();
        break;
    case 'excluir':
        $controller->excluir();
        break;
    case 'buscar':
        $controller->buscar();
        break;
    default:
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['gestor_logged']) && $_SESSION['gestor_logged'] === true) {
            header('Location: livro.php?acao=listar');
        } else {
            header('Location: livro.php?acao=buscar');
        }
        exit;
}
