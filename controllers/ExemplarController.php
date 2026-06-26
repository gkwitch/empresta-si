<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Exemplar.php';


class ExemplarController
{
    public static function cadastrar(int $livroId, string $codigo): int
    {
        if (trim($codigo) === '') {
            throw new InvalidArgumentException("O código do exemplar é obrigatório.");
        }

        $pdo = getConnection();
        return ExemplarModel::insert($pdo, $livroId, $codigo);
    }

    public static function listar(): array
    {
        $pdo = getConnection();
        return ExemplarModel::getAll($pdo);
    }

    public static function listarDisponiveis(int $livroId): array
    {
        $pdo = getConnection();
        return ExemplarModel::getDisponiveis($pdo, $livroId);
    }

    public static function buscarPorId(int $id): array|false
    {
        $pdo = getConnection();
        return ExemplarModel::getById($pdo, $id);
    }

    public static function atualizar(int $id, string $codigo, bool $disponivel): bool
    {
        $pdo = getConnection();
        return ExemplarModel::update($pdo, $id, $codigo, $disponivel);
    }

    public static function remover(int $id): bool
    {
        $pdo = getConnection();
        return ExemplarModel::delete($pdo, $id);
    }
}
