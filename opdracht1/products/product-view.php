<?php
require_once "product.php";
require_once "../includes/db.php";

$db = new DB();
$product = new Product($db);

try {
    
    $products = $product->getAllProducts();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Overzicht</title>
</head>
<body>
    <a href="product-insert.php">Product toevoegen</a>
    <h1>Productenlijst</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Afbeelding</th> 
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                        <td><?php echo htmlspecialchars($product['naam']); ?></td>
                        <td><?php echo htmlspecialchars($product['prijs']); ?></td>
                        <td>
                            <?php if (!empty($product['foto'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" alt="Product Afbeelding" style="width:100px;">
                            <?php else: ?>
                                Geen afbeelding
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="product-edit.php?id=<?php echo htmlspecialchars($product['id']); ?>">Bewerken</a>
                            <a href="product-delete.php?id=<?php echo htmlspecialchars($product['id']); ?>" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">Verwijderen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Geen producten gevonden.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
