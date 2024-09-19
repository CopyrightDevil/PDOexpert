<?php
require_once "product.php";
require_once "../includes/db.php";

$db = new DB();
$product = new Product($db);

// Haal het product-ID op uit de querystring
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $product->deleteProduct($id);
        echo "Product succesvol verwijderd!";
        echo "<br><a href='product-view.php'>Terug naar overzicht</a>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Geen product-id opgegeven.";
}
