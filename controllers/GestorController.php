<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Gestor.php';


class GestorController
{
    public static function cadastrar(string $nome, string $username, string $senha): int
    {
        $pdo = getConnection();

        if (trim($nome) === '' || trim($username) === '' || trim($senha) === '') {
            throw new InvalidArgumentException("Nome, usuário e senha são obrigatórios.");
        }
        if (strlen($senha) < 6) {
            throw new InvalidArgumentException("A senha deve ter pelo menos 6 caracteres.");
        }

        return GestorModel::insert($pdo, $nome, $username, $senha);
    }

    public static function listar(): array
    {
        $pdo = getConnection();
        return GestorModel::getAll($pdo);
    }

    public static function buscarPorId(int $id): array|false
    {
        $pdo = getConnection();
        return GestorModel::getById($pdo, $id);
    }

    public static function atualizar(int $id, string $nome, string $username): bool
    {
        $pdo = getConnection();
        return GestorModel::update($pdo, $id, $nome, $username);
    }

    public static function trocarSenha(int $id, string $novaSenha): bool
    {
        if (strlen($novaSenha) < 6) {
            throw new InvalidArgumentException("A senha deve ter pelo menos 6 caracteres.");
        }
        $pdo = getConnection();
        return GestorModel::updateSenha($pdo, $id, $novaSenha);
    }

    public static function login(string $username, string $senha): array|false
    {
        $pdo = getConnection();
        return GestorModel::autenticar($pdo, $username, $senha);
    }

    public static function remover(int $id): bool
    {
        $pdo = getConnection();
        return GestorModel::delete($pdo, $id);
    }
}
