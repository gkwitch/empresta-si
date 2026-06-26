<?php

// Conexão com o banco de dados 

function getConnection(): PDO
{
    $dsn = 'mysql:host=localhost;dbname=biblioteca.db;charset=utf8mb4';
    return new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} 