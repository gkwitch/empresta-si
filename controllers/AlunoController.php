<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Aluno.php';


class AlunoController
{
    public static function cadastrar(
        string $matricula,
        string $nomeCompleto,
        string $email = '',
        string $discord = '',
        string $celular = ''
    ): void {
        if (trim($matricula) === '' || trim($nomeCompleto) === '') {
            throw new InvalidArgumentException("Matrícula e nome completo são obrigatórios.");
        }

        $pdo = getConnection();
        AlunoModel::insert($pdo, $matricula, $nomeCompleto, $email, $discord, $celular);
    }

    public static function listar(): array
    {
        $pdo = getConnection();
        return AlunoModel::getAll($pdo);
    }

    public static function buscarPorMatricula(string $matricula): array|false
    {
        $pdo = getConnection();
        return AlunoModel::getByMatricula($pdo, $matricula);
    }

    public static function atualizar(
        string $matricula,
        string $nomeCompleto,
        string $email = '',
        string $discord = '',
        string $celular = ''
    ): bool {
        $pdo = getConnection();
        return AlunoModel::update($pdo, $matricula, $nomeCompleto, $email, $discord, $celular);
    }

    public static function remover(string $matricula): bool
    {
        $pdo = getConnection();
        return AlunoModel::delete($pdo, $matricula);
    }
}
