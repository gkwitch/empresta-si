<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Database.php';

$controller = new LocacaoController();
$controller->indexPublico();
