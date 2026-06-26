<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Emprestimo.php';


class EmprestimoController
{
    public static function registrarEmprestimo(int $exemplarId, string $alunoMatricula): int
    {
        $pdo = getConnection();
        return EmprestimoModel::insert($pdo, $exemplarId, $alunoMatricula);
    }

    public static function listar(): array
    {
        $pdo = getConnection();
        return EmprestimoModel::getAll($pdo);
    }

    public static function listarEmAberto(): array
    {
        $pdo = getConnection();
        return EmprestimoModel::getEmAberto($pdo);
    }

    public static function buscarPorId(int $id): array|false
    {
        $pdo = getConnection();
        return EmprestimoModel::getById($pdo, $id);
    }

    public static function devolver(int $emprestimoId): bool
    {
        $pdo = getConnection();
        return EmprestimoModel::registrarDevolucao($pdo, $emprestimoId);
    }

    public static function remover(int $id): bool
    {
        $pdo = getConnection();
        return EmprestimoModel::delete($pdo, $id);
    }
}
