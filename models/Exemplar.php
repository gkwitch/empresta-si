<?php

require_once __DIR__ . '/../config/db.php';


class ExemplarModel
{
    /**
     * Cadastra um exemplar (cópia física) vinculado a um livro.
     */
    public static function insert(PDO $pdo, int $livroId, string $codigo): int
    {
        $stmt = $pdo->prepare(
            "INSERT INTO exemplares (livro_id, codigo, disponivel)
             VALUES (:livro_id, :codigo, 1)"
        );
        $stmt->execute([':livro_id' => $livroId, ':codigo' => $codigo]);
        return (int) $pdo->lastInsertId();
    }

    /**
     * Retorna todos os exemplares com o título do livro vinculado.
     */
    public static function getAll(PDO $pdo): array
    {
        $sql = "SELECT e.*, l.titulo AS livro_titulo
                FROM exemplares e
                JOIN livros l ON l.id = e.livro_id
                ORDER BY l.titulo, e.codigo";
        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Retorna todos os exemplares disponíveis de um livro específico.
     */
    public static function getDisponiveis(PDO $pdo, int $livroId): array
    {
        $stmt = $pdo->prepare(
            "SELECT * FROM exemplares
             WHERE livro_id = :livro_id AND disponivel = 1
             ORDER BY codigo"
        );
        $stmt->execute([':livro_id' => $livroId]);
        return $stmt->fetchAll();
    }

    /**
     * Busca um exemplar pelo ID.
     */
    public static function getById(PDO $pdo, int $id): array|false
    {
        $stmt = $pdo->prepare("SELECT * FROM exemplares WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Atualiza o código e a disponibilidade de um exemplar.
     */
    public static function update(PDO $pdo, int $id, string $codigo, bool $disponivel): bool
    {
        $stmt = $pdo->prepare(
            "UPDATE exemplares SET codigo = :codigo, disponivel = :disponivel WHERE id = :id"
        );
        $stmt->execute([
            ':codigo'     => $codigo,
            ':disponivel' => (int) $disponivel,
            ':id'         => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Remove um exemplar pelo ID.
     * Falhará se houver empréstimos vinculados (ON DELETE RESTRICT).
     */
    public static function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM exemplares WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
