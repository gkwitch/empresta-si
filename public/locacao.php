<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';


require_once __DIR__ . '/../includes/auth_check.php';

$controller = new LocacaoController();
$acao = $_GET['acao'] ?? 'listar';


switch ($acao) {
    case 'listar':
        $controller->listar();
        break;
    case 'emprestar':
        $controller->emprestar();
        break;
    case 'devolver':
        $controller->devolver();
        break;
    default:
        header('Location: locacao.php?acao=listar');
        exit;
}
