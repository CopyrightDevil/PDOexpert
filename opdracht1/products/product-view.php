<?php
session_start();
require_once "product.php";
require_once "../includes/db.php";

$db = new DB();
$product = new Product($db);

$products = $product->getAllProducts();
$rol = $_SESSION['rol'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Producten bekijken</title>
</head>
<body>
    <h1>Productenlijst</h1>
    <br><?php if ($rol == 'beheerder'): ?>
        <a href="product-insert.php">Product toevoegen</a>
    <?php endif; ?><br>
    <br><a href="logout.php">Uitloggen</a><br>
<br><br>
    <table border="1">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Prijs</th>
                <th>Afbeelding</th>
                <?php if ($rol == 'beheerder'): ?>
                    <th>Acties</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['naam']); ?></td>
                    <td><?php echo htmlspecialchars($product['prijs']); ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($product['foto']); ?>" width="100"></td>
                    <?php if ($rol == 'beheerder'): ?>
                        <td>
                            <a href="product-edit.php?id=<?php echo $product['id']; ?>">Bewerken</a>
                            <a href="product-delete.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">Verwijderen</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

