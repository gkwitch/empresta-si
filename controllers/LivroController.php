<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Livro.php';


class LivroController
{
    public static function cadastrar(
        string $titulo,
        string $autores = '',
        string $editora = '',
        string $edicao = '',
        int $anoPublicacao = 0
    ): int {
        if (trim($titulo) === '') {
            throw new InvalidArgumentException("O título é obrigatório.");
        }

        $pdo = getConnection();
        return LivroModel::insert($pdo, $titulo, $autores, $editora, $edicao, $anoPublicacao);
    }

    public static function listar(): array
    {
        $pdo = getConnection();
        return LivroModel::getAll($pdo);
    }

    public static function buscarPorId(int $id): array|false
    {
        $pdo = getConnection();
        return LivroModel::getById($pdo, $id);
    }

    public static function buscarPorTitulo(string $termo): array
    {
        $pdo = getConnection();
        return LivroModel::search($pdo, $termo);
    }

    public static function atualizar(
        int $id,
        string $titulo,
        string $autores = '',
        string $editora = '',
        string $edicao = '',
        int $anoPublicacao = 0
    ): bool {
        $pdo = getConnection();
        return LivroModel::update($pdo, $id, $titulo, $autores, $editora, $edicao, $anoPublicacao);
    }

    public static function remover(int $id): bool
    {
        $pdo = getConnection();
        return LivroModel::delete($pdo, $id);
    }
}
