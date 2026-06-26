<?php

require_once __DIR__ . '/../config/db.php';


class EmprestimoModel
{
    /**
     * Registra um novo empréstimo e marca o exemplar como indisponível.
     */
    public static function insert(PDO $pdo, int $exemplarId, string $alunoMatricula): int
    {
        $pdo->beginTransaction();
        try {
            // Verifica se o exemplar está disponível
            $stmt = $pdo->prepare(
                "SELECT disponivel FROM exemplares WHERE id = :id FOR UPDATE"
            );
            $stmt->execute([':id' => $exemplarId]);
            $exemplar = $stmt->fetch();

            if (!$exemplar || !$exemplar['disponivel']) {
                throw new RuntimeException("Exemplar indisponível para empréstimo.");
            }

            // Cria o empréstimo
            $stmt = $pdo->prepare(
                "INSERT INTO emprestimos (exemplar_id, aluno_matricula, data_emprestimo)
                 VALUES (:exemplar_id, :aluno_matricula, CURDATE())"
            );
            $stmt->execute([
                ':exemplar_id'     => $exemplarId,
                ':aluno_matricula' => $alunoMatricula,
            ]);
            $novoId = (int) $pdo->lastInsertId();

            // Marca o exemplar como indisponível
            $pdo->prepare("UPDATE exemplares SET disponivel = 0 WHERE id = :id")
                ->execute([':id' => $exemplarId]);

            $pdo->commit();
            return $novoId;

        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Retorna todos os empréstimos com dados do aluno e do exemplar.
     */
    public static function getAll(PDO $pdo): array
    {
        $sql = "SELECT
                    em.id,
                    em.data_emprestimo,
                    em.data_devolucao,
                    al.matricula,
                    al.nome_completo   AS aluno_nome,
                    ex.codigo          AS exemplar_codigo,
                    li.titulo          AS livro_titulo
                FROM emprestimos em
                JOIN alunos    al ON al.matricula = em.aluno_matricula
                JOIN exemplares ex ON ex.id        = em.exemplar_id
                JOIN livros    li ON li.id         = ex.livro_id
                ORDER BY em.data_emprestimo DESC";

        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Retorna apenas os empréstimos em aberto (sem devolução).
     */
    public static function getEmAberto(PDO $pdo): array
    {
        $sql = "SELECT
                    em.id,
                    em.data_emprestimo,
                    al.nome_completo   AS aluno_nome,
                    ex.codigo          AS exemplar_codigo,
                    li.titulo          AS livro_titulo
                FROM emprestimos em
                JOIN alunos     al ON al.matricula = em.aluno_matricula
                JOIN exemplares ex ON ex.id        = em.exemplar_id
                JOIN livros     li ON li.id        = ex.livro_id
                WHERE em.data_devolucao IS NULL
                ORDER BY em.data_emprestimo ASC";

        return $pdo->query($sql)->fetchAll();
    }

    /**
     * Busca um empréstimo pelo ID.
     */
    public static function getById(PDO $pdo, int $id): array|false
    {
        $stmt = $pdo->prepare("SELECT * FROM emprestimos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Registra a devolução de um exemplar.
     */
    public static function registrarDevolucao(PDO $pdo, int $emprestimoId): bool
    {
        $pdo->beginTransaction();
        try {
            // Busca o empréstimo e verifica se ainda está em aberto
            $stmt = $pdo->prepare(
                "SELECT exemplar_id, data_devolucao FROM emprestimos WHERE id = :id FOR UPDATE"
            );
            $stmt->execute([':id' => $emprestimoId]);
            $emprestimo = $stmt->fetch();

            if (!$emprestimo) {
                throw new RuntimeException("Empréstimo não encontrado.");
            }
            if ($emprestimo['data_devolucao'] !== null) {
                throw new RuntimeException("Este empréstimo já foi devolvido.");
            }

            // Registra a data de devolução
            $pdo->prepare(
                "UPDATE emprestimos SET data_devolucao = CURDATE() WHERE id = :id"
            )->execute([':id' => $emprestimoId]);

            // Libera o exemplar
            $pdo->prepare(
                "UPDATE exemplares SET disponivel = 1 WHERE id = :id"
            )->execute([':id' => $emprestimo['exemplar_id']]);

            $pdo->commit();
            return true;

        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Remove um empréstimo pelo ID.
     * Use com cautela — prefira manter o histórico e usar registrarDevolucao().
     */
    public static function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM emprestimos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
