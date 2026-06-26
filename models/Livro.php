<?php

require_once __DIR__ . '/../config/db.php';


class LivroModel
{
    /**
     * Cadastra um novo livro (metadados da obra).
     */
    public static function insert(
        PDO $pdo,
        string $titulo,
        string $autores = '',
        string $editora = '',
        string $edicao = '',
        int $anoPublicacao = 0
    ): int {
        $sql = "INSERT INTO livros (titulo, autores, editora, edicao, ano_publicacao)
                VALUES (:titulo, :autores, :editora, :edicao, :ano_publicacao)";

        $pdo->prepare($sql)->execute([
            ':titulo'         => $titulo,
            ':autores'        => $autores        ?: null,
            ':editora'        => $editora        ?: null,
            ':edicao'         => $edicao         ?: null,
            ':ano_publicacao' => $anoPublicacao  ?: null,
        ]);

        return (int) $pdo->lastInsertId();
    }

    /**
     * Retorna todos os livros ordenados pelo título.
     */
    public static function getAll(PDO $pdo): array
    {
        return $pdo->query("SELECT * FROM livros ORDER BY titulo")->fetchAll();
    }

    /**
     * Busca um livro pelo ID.
     */
    public static function getById(PDO $pdo, int $id): array|false
    {
        $stmt = $pdo->prepare("SELECT * FROM livros WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Busca livros pelo título (busca parcial).
     */
    public static function search(PDO $pdo, string $termo): array
    {
        $stmt = $pdo->prepare(
            "SELECT * FROM livros WHERE titulo LIKE :termo ORDER BY titulo"
        );
        $stmt->execute([':termo' => '%' . $termo . '%']);
        return $stmt->fetchAll();
    }

    /**
     * Atualiza os dados de um livro.
     */
    public static function update(
        PDO $pdo,
        int $id,
        string $titulo,
        string $autores = '',
        string $editora = '',
        string $edicao = '',
        int $anoPublicacao = 0
    ): bool {
        $stmt = $pdo->prepare(
            "UPDATE livros
             SET titulo         = :titulo,
                 autores        = :autores,
                 editora        = :editora,
                 edicao         = :edicao,
                 ano_publicacao = :ano_publicacao
             WHERE id = :id"
        );
        $stmt->execute([
            ':titulo'         => $titulo,
            ':autores'        => $autores       ?: null,
            ':editora'        => $editora       ?: null,
            ':edicao'         => $edicao        ?: null,
            ':ano_publicacao' => $anoPublicacao ?: null,
            ':id'             => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Remove um livro pelo ID.
     * Falhará se houver exemplares vinculados (ON DELETE RESTRICT).
     */
    public static function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM livros WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
