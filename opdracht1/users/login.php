<?php
require_once "../includes/db.php";
require_once "User.php";
session_start(); // Zorg ervoor dat de sessie bovenaan gestart wordt

$db = new DB();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Login poging
    if ($user->login($username, $password)) {
        // Stel sessievariabelen in
        $_SESSION['logged_in'] = true;
        $_SESSION['rol'] = $user->getRole($username); // Haal de rol op van de user (beheerder/klant)

        // Redirect naar product-view of dashboard
        header("Location: ../products/product-view.php");
        exit;
    } else {
        echo "Onjuiste gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
</head>
<body>
    <h1>Inloggen</h1>
    <form method="POST">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" required><br>
        <label>Wachtwoord:</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Inloggen">
    </form>
</body>
</html>
