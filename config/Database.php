<?php
class Database {
    // DOCKER NÃO MEXE NESSA CARALHA
    private $host = "db"; 
    private $user = "root";
    private $pass = "root"; 
    
    // XAMPP NÃO MEXE NESSA CARALHA TAMBÉM
    // private $host = "localhost";
    // private $user = "root";
    // private $pass = ""; 

    private $dbname = "empresta_si";
    private $conexao;

    public function getConnection() {
        $this->conexao = null;
        try {
            $this->conexao = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=utf8mb4", $this->user, $this->pass);
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro na conexão: " . $e->getMessage();
        }
        return $this->conexao;
    }
}
?>