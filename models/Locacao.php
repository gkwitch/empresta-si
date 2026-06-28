<?php

class Locacao {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }


    public function listarAtivas() {
        $sql = "SELECT Loc.*, A.nome as nome_aluno, A.matricula as matricula_aluno, L.exemplar as nome_exemplar, L.titulo as titulo_livro
                FROM Locacao Loc
                JOIN Aluno A ON Loc.id_aluno = A.id
                JOIN Livro L ON Loc.id_livro = L.id
                WHERE Loc.data_devolucao IS NULL
                ORDER BY Loc.data_emprestimo DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarHistorico() {
        $sql = "SELECT Loc.*, A.nome as nome_aluno, A.matricula as matricula_aluno, L.exemplar as nome_exemplar, L.titulo as titulo_livro
                FROM Locacao Loc
                JOIN Aluno A ON Loc.id_aluno = A.id
                JOIN Livro L ON Loc.id_livro = L.id
                ORDER BY Loc.data_emprestimo DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function registrarEmprestimo($id_aluno, $id_livro) {
        try {
            $this->db->beginTransaction();

            $sqlCheck = "SELECT alugado FROM Livro WHERE id = :id_livro FOR UPDATE";
            $stmtCheck = $this->db->prepare($sqlCheck);
            $stmtCheck->execute([':id_livro' => $id_livro]);
            $livro = $stmtCheck->fetch();

            if (!$livro || $livro['alugado'] == 1) {
                $this->db->rollBack();
                return false; 
            }

            $sqlInsert = "INSERT INTO Locacao (id_aluno, id_livro, data_emprestimo, data_devolucao) 
                          VALUES (:id_aluno, :id_livro, NOW(), NULL)";
            $stmtInsert = $this->db->prepare($sqlInsert);
            $stmtInsert->execute([
                ':id_aluno' => $id_aluno,
                ':id_livro' => $id_livro
            ]);

            $sqlUpdate = "UPDATE Livro SET alugado = 1 WHERE id = :id_livro";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->execute([':id_livro' => $id_livro]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function registrarDevolucao($id_locacao) {
        try {
            $this->db->beginTransaction();

            $sqlLoc = "SELECT id_livro FROM Locacao WHERE id_locacao = :id_locacao AND data_devolucao IS NULL FOR UPDATE";
            $stmtLoc = $this->db->prepare($sqlLoc);
            $stmtLoc->execute([':id_locacao' => $id_locacao]);
            $loc = $stmtLoc->fetch();

            if (!$loc) {
                $this->db->rollBack();
                return false; 
            }

            $id_livro = $loc['id_livro'];

            $sqlUpdateLoc = "UPDATE Locacao SET data_devolucao = CURRENT_DATE() WHERE id_locacao = :id_locacao";
            $stmtUpdateLoc = $this->db->prepare($sqlUpdateLoc);
            $stmtUpdateLoc->execute([':id_locacao' => $id_locacao]);

            $sqlUpdateLivro = "UPDATE Livro SET alugado = 0 WHERE id = :id_livro";
            $stmtUpdateLivro = $this->db->prepare($sqlUpdateLivro);
            $stmtUpdateLivro->execute([':id_livro' => $id_livro]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function pesquisarPorAluno($termo) {
        $sql = "SELECT Loc.*, A.nome as nome_aluno, A.matricula as matricula_aluno, A.email as email_aluno, L.exemplar as nome_exemplar, L.titulo as titulo_livro
                FROM Locacao Loc
                JOIN Aluno A ON Loc.id_aluno = A.id
                JOIN Livro L ON Loc.id_livro = L.id
                WHERE (A.nome LIKE :termo1 OR A.matricula LIKE :termo2) AND Loc.data_devolucao IS NULL
                ORDER BY Loc.data_emprestimo DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':termo1' => '%' . $termo . '%',
            ':termo2' => '%' . $termo . '%'
        ]);
        return $stmt->fetchAll();
    }
}
