<?php

require_once __DIR__ . '/../config/db.php';


class GestorModel
{
    /**
     * Cadastra um novo gestor.
     * A senha é armazenada como hash automático — nunca passe o hash manualmente.
     */
    public static function insert(PDO $pdo, string $nome, string $username, string $senha): int
    {
        $sql = "INSERT INTO gestores (nome, username, senha)
                VALUES (:nome, :username, :senha)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome'     => $nome,
            ':username' => $username,
            ':senha'    => password_hash($senha, PASSWORD_BCRYPT),
        ]);

        return (int) $pdo->lastInsertId();
    }

    /**
     * Retorna todos os gestores (sem expor a senha).
     */
    public static function getAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT id, nome, username FROM gestores ORDER BY nome");
        return $stmt->fetchAll();
    }

    /**
     * Busca um gestor pelo ID (sem expor a senha).
     */
    public static function getById(PDO $pdo, int $id): array|false
    {
        $stmt = $pdo->prepare("SELECT id, nome, username FROM gestores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Atualiza nome e/ou username de um gestor.
     * Para trocar a senha, use updateSenha() separadamente.
     */
    public static function update(PDO $pdo, int $id, string $nome, string $username): bool
    {
        $stmt = $pdo->prepare(
            "UPDATE gestores SET nome = :nome, username = :username WHERE id = :id"
        );
        $stmt->execute([':nome' => $nome, ':username' => $username, ':id' => $id]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Troca a senha de um gestor (re-gera o hash).
     */
    public static function updateSenha(PDO $pdo, int $id, string $novaSenha): bool
    {
        $stmt = $pdo->prepare("UPDATE gestores SET senha = :senha WHERE id = :id");
        $stmt->execute([
            ':senha' => password_hash($novaSenha, PASSWORD_BCRYPT),
            ':id'    => $id,
        ]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Autentica um gestor pelo username e senha.
     * Retorna os dados do gestor ou false se inválido.
     */
    public static function autenticar(PDO $pdo, string $username, string $senha): array|false
    {
        $stmt = $pdo->prepare("SELECT * FROM gestores WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $gestor = $stmt->fetch();

        if ($gestor && password_verify($senha, $gestor['senha'])) {
            unset($gestor['senha']); // nunca retorne o hash
            return $gestor;
        }
        return false;
    }

    /**
     * Remove um gestor pelo ID.
     */
    public static function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM gestores WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
