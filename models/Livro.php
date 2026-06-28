<?php

class Livro {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Livro ORDER BY titulo ASC, exemplar ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDisponiveis() {
        $sql = "SELECT * FROM Livro WHERE alugado = 0 ORDER BY titulo ASC, exemplar ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM Livro WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function salvar($dados, $quantidade) {
        $sql = "INSERT INTO Livro (titulo, autores, editora, edicao, ano_publicacao, exemplar, alugado) 
                VALUES (:titulo, :autores, :editora, :edicao, :ano_publicacao, :exemplar, 0)";
        
        $stmt = $this->db->prepare($sql);
        
        for ($i = 1; $i <= $quantidade; $i++) {
            $nomeExemplar = $dados['titulo'] . " – Exemplar " . $i;
            $stmt->execute([
                ':titulo' => $dados['titulo'],
                ':autores' => $dados['autores'],
                ':editora' => $dados['editora'],
                ':edicao' => $dados['edicao'],
                ':ano_publicacao' => $dados['ano_publicacao'],
                ':exemplar' => $nomeExemplar
            ]);
        }
        return true;
    }

    public function atualizar($id, $dados) {
        $sql = "UPDATE Livro SET 
                titulo = :titulo, 
                autores = :autores, 
                editora = :editora, 
                edicao = :edicao, 
                ano_publicacao = :ano_publicacao, 
                exemplar = :exemplar, 
                alugado = :alugado 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':titulo' => $dados['titulo'],
            ':autores' => $dados['autores'],
            ':editora' => $dados['editora'],
            ':edicao' => $dados['edicao'],
            ':ano_publicacao' => $dados['ano_publicacao'],
            ':exemplar' => $dados['exemplar'],
            ':alugado' => $dados['alugado']
        ]);
    }

    public function excluir($id) {
        $sql = "DELETE FROM Livro WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function pesquisarPorTitulo($titulo) {
        $sql = "SELECT L.*, Loc.data_emprestimo, A.nome as nome_aluno, A.matricula as matricula_aluno
                FROM Livro L
                LEFT JOIN Locacao Loc ON L.id = Loc.id_livro AND Loc.data_devolucao IS NULL
                LEFT JOIN Aluno A ON Loc.id_aluno = A.id
                WHERE L.titulo LIKE :titulo
                ORDER BY L.titulo ASC, L.exemplar ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':titulo' => '%' . $titulo . '%']);
        return $stmt->fetchAll();
    }
}
