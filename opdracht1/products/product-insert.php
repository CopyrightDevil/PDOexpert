<?php
require_once "product.php";
require_once "../includes/db.php";

$db = new DB();
$product = new Product($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = $_POST['naam'];
    $prijs = $_POST['prijs'];

    
    if (!empty($_FILES['foto']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['foto']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        
        $check = getimagesize($_FILES['foto']['tmp_name']);
        if ($check !== false) {
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
                
                try {
                    $product->insertProduct($naam, $prijs, $_FILES['foto']['name']);
                    header("Location: product-insert.php?status=success");
                    exit;
                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            } else {
                echo "Sorry, er was een fout bij het uploaden van de afbeelding.";
            }
        } else {
            echo "Het bestand is geen afbeelding.";
        }
    } else {
        echo "Geen afbeelding geüpload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Invoeren</title>
    <script>
        
        function showSuccessPopup() {
            alert('Product succesvol ingevoerd!');
        }

        
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                showSuccessPopup();
            }
        }
    </script>
</head>
<body>
<a href="product-view.php">Producten bekijken</a>

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="naam" placeholder="Naam" required><br>
        <input type="number" name="prijs" placeholder="Prijs" required><br>
        <input type="file" name="foto" required><br>
        <input type="submit" value="Opslaan">
    </form>
</body>
</html>
