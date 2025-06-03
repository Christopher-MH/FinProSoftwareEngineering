<?php
class db_connect {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db_Name = 'trash_trade';
    private $pdo;

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_Name}";

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            return null;
        }

        return $this->pdo;
    }

    public function close() {
        $this->pdo = null;
    }
}