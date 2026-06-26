<?php

require_once __DIR__ . '/../config/db.php';


class AlunoModel
{
    /**
     * Cadastra um novo aluno.
     */
    public static function insert(
        PDO $pdo,
        string $matricula,
        string $nomeCompleto,
        string $email = '',
        string $discord = '',
        string $celular = ''
    ): void {
        $sql = "INSERT INTO alunos (matricula, nome_completo, email, discord, celular)
                VALUES (:matricula, :nome_completo, :email, :discord, :celular)";

        $pdo->prepare($sql)->execute([
            ':matricula'     => $matricula,
            ':nome_completo' => $nomeCompleto,
            ':email'         => $email   ?: null,
            ':discord'       => $discord ?: null,
            ':celular'       => $celular ?: null,
        ]);
    }

    /**
     * Retorna todos os alunos ordenados pelo nome.
     */
    public static function getAll(PDO $pdo): array
    {
        return $pdo->query("SELECT * FROM alunos ORDER BY nome_completo")->fetchAll();
    }

    /**
     * Busca um aluno pela matrícula.
     */
    public static function getByMatricula(PDO $pdo, string $matricula): array|false
    {
        $stmt = $pdo->prepare("SELECT * FROM alunos WHERE matricula = :matricula");
        $stmt->execute([':matricula' => $matricula]);
        return $stmt->fetch();
    }

    /**
     * Atualiza os dados de um aluno.
     */
    public static function update(
        PDO $pdo,
        string $matricula,
        string $nomeCompleto,
        string $email = '',
        string $discord = '',
        string $celular = ''
    ): bool {
        $stmt = $pdo->prepare(
            "UPDATE alunos
             SET nome_completo = :nome_completo,
                 email         = :email,
                 discord       = :discord,
                 celular       = :celular
             WHERE matricula = :matricula"
        );
        $stmt->execute([
            ':nome_completo' => $nomeCompleto,
            ':email'         => $email   ?: null,
            ':discord'       => $discord ?: null,
            ':celular'       => $celular ?: null,
            ':matricula'     => $matricula,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Remove um aluno pela matrícula.
     * Falhará se o aluno tiver empréstimos registrados (ON DELETE RESTRICT).
     */
    public static function delete(PDO $pdo, string $matricula): bool
    {
        $stmt = $pdo->prepare("DELETE FROM alunos WHERE matricula = :matricula");
        $stmt->execute([':matricula' => $matricula]);
        return $stmt->rowCount() > 0;
    }
}
