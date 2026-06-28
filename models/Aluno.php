<?php

class Aluno {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function listarTodos() {
        $sql = "SELECT * FROM Aluno ORDER BY nome ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM Aluno WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function buscarPorMatricula($matricula) {
        $sql = "SELECT * FROM Aluno WHERE matricula = :matricula";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':matricula' => $matricula]);
        return $stmt->fetch();
    }


    public function buscarPorUsuario($usuario) {
        $sql = "SELECT * FROM Aluno WHERE usuario = :usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        return $stmt->fetch();
    }


    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM Aluno WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function salvar($dados) {
        $sql = "INSERT INTO Aluno (nome, usuario, senha, matricula, usuario_discord, email, celular, gestor) 
                VALUES (:nome, :usuario, :senha, :matricula, :usuario_discord, :email, :celular, :gestor)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':usuario' => $dados['usuario'],
            ':senha' => $dados['senha'], 
            ':matricula' => $dados['matricula'],
            ':usuario_discord' => $dados['usuario_discord'] ?: null,
            ':email' => $dados['email'],
            ':celular' => $dados['celular'] ?: null,
            ':gestor' => $dados['gestor']
        ]);
    }


    public function atualizar($id, $dados) {
        if (!empty($dados['senha'])) {
            $sql = "UPDATE Aluno SET 
                    nome = :nome, 
                    usuario = :usuario, 
                    senha = :senha, 
                    usuario_discord = :usuario_discord, 
                    email = :email, 
                    celular = :celular, 
                    gestor = :gestor 
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':nome' => $dados['nome'],
                ':usuario' => $dados['usuario'],
                ':senha' => $dados['senha'],
                ':usuario_discord' => $dados['usuario_discord'] ?: null,
                ':email' => $dados['email'],
                ':celular' => $dados['celular'] ?: null,
                ':gestor' => $dados['gestor']
            ];
        } else {
            $sql = "UPDATE Aluno SET 
                    nome = :nome, 
                    usuario = :usuario, 
                    usuario_discord = :usuario_discord, 
                    email = :email, 
                    celular = :celular, 
                    gestor = :gestor 
                    WHERE id = :id";
            $params = [
                ':id' => $id,
                ':nome' => $dados['nome'],
                ':usuario' => $dados['usuario'],
                ':usuario_discord' => $dados['usuario_discord'] ?: null,
                ':email' => $dados['email'],
                ':celular' => $dados['celular'] ?: null,
                ':gestor' => $dados['gestor']
            ];
        }

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function excluir($id) {
        $sql = "DELETE FROM Aluno WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function temLocacaoAtiva($id) {
        $sql = "SELECT COUNT(*) as total FROM Locacao WHERE id_aluno = :id_aluno AND data_devolucao IS NULL";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id_aluno' => $id]);
        $row = $stmt->fetch();
        return $row['total'] > 0;
    }
}
