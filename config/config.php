<?php
// Habilita exibição de erros para depuração em ambiente de desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurações gerais
define('BASE_URL', 'http://localhost/empresta-si/public/');

// Configurações do Banco de Dados
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'empresta_si');
define('DB_CHARSET', 'utf8mb4');

// Autoload simples de classes para carregar Models e Controllers automaticamente
spl_autoload_register(function ($className) {
    // Diretórios de busca das classes
    $directories = [
        __DIR__ . '/../models/',
        __DIR__ . '/../controllers/',
        __DIR__ . '/' // para carregar Database se necessário
    ];

    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
