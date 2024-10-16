<?php
require_once "../includes/db.php";
require_once "User.php";
session_start();

$db = new DB();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $user->register($username, $password, $role);
    echo "Registratie succesvol!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
</head>
<body>
    <h1>Registreren</h1>
    <form method="POST">
        <label>Gebruikersnaam:</label>
        <input type="text" name="username" required><br>
        <label>Wachtwoord:</label>
        <input type="password" name="password" required><br>
        <label>Rol:</label>
        <select name="role">
            <option value="klant">Klant</option>
            <option value="beheerder">Beheerder</option>
        </select><br>
        <input type="submit" value="Registreren">

        <p><a href="login.php">Log hier in!</a></p>
    </form>
</body>
</html>
