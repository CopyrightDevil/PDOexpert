<?php
require_once "product.php";
require_once "../includes/db.php";


$db = new DB();
$product = new Product($db);


$id = $_GET['id'] ?? null;


if (!$id) {
    echo "Geen product-id opgegeven.";
    exit;
}


$productData = $product->getProductById($id);
if (!$productData) {
    echo "Product niet gevonden.";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];

    
    $foto = $productData['foto'];  
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['foto']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                $foto = $_FILES['foto']['name']; // Update met nieuwe afbeelding
            } else {
                echo "Sorry, er was een fout bij het uploaden van de afbeelding.";
            }
        } else {
            echo "Het bestand is geen afbeelding.";
        }
    }

    try {
        $product->updateProduct($id, $naam, $prijs, $foto);
        echo "Product succesvol bijgewerkt!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Bewerken</title>
</head>
<body>
    <h1>Product Bewerken</h1>
    <a href="product-view.php">Producten bekijken</a>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($productData['id']); ?>">
        <label>Naam:</label>
        <input type="text" name="naam" value="<?php echo htmlspecialchars($productData['naam']); ?>" required><br>
        <label>Prijs:</label>
        <input type="number" name="prijs" value="<?php echo htmlspecialchars($productData['prijs']); ?>" required><br>
        <label>Huidige Afbeelding:</label><br>
        <img src="uploads/<?php echo htmlspecialchars($productData['foto']); ?>" alt="Product Afbeelding" width="100"><br>
        <label>Nieuwe Afbeelding (optioneel):</label>
        <input type="file" name="foto"><br>
        <input type="submit" value="Opslaan">
    </form>
</body>
</html>
