<?php

class DB {
    private $db;

    public function __construct($db = "winkel", $user = "root", $password = "", $host = "localhost") {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function execute($sql, $placeholders = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($placeholders);
        return $stmt;
    }
}
