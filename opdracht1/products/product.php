<?php
require_once "../includes/db.php";

class Product {
    private $db;
    
    public function __construct(DB $db) {
        $this->db = $db;
    }
    
    public function insertProduct($naam, $prijs, $foto) {
        return $this->db->execute("INSERT INTO product (naam, prijs, foto) VALUES (?, ?, ?)", [$naam, $prijs, $foto]);
    }
    
    

    
    public function getAllProducts() {
        return $this->db->execute("SELECT id, naam, prijs, foto FROM product")->fetchAll(PDO::FETCH_ASSOC);
    }
    

    
    public function getProductById($id) {
        return $this->db->execute("SELECT * FROM product WHERE id = ?", [$id])->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProduct($id, $naam, $prijs, $foto) {
        return $this->db->execute("UPDATE product SET naam = ?, prijs = ?, foto = ? WHERE id = ?", [$naam, $prijs, $foto, $id]);
    }
    
    public function deleteProduct($id) {
        return $this->db->execute("DELETE FROM product WHERE id = ?", [$id]);
    }
}

