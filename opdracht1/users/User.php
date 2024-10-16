<?php
require_once "../includes/db.php";

class User {
    private $db;

    public function __construct(DB $db) {
        $this->db = $db;
    }

    // Methode voor het registreren van een nieuwe gebruiker
    public function register($username, $password, $role) {
        // Wachtwoord hashen
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Voer de query uit om de gebruiker toe te voegen aan de database
        $this->db->execute("INSERT INTO users (username, password, role) VALUES (?, ?, ?)", [$username, $hashedPassword, $role]);
    }

    // Methode voor het inloggen van een gebruiker
    public function login($username, $password) {
        // Haal de gebruiker op uit de database
        $user = $this->db->execute("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Sla de gebruikersgegevens op in de sessie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Rol opslaan in de sessie
            $_SESSION['logged_in'] = true;

            return true;
        } else {
            return false;
        }
    }

    // Methode om de rol van de gebruiker op te halen
    public function getRole($username) {
        $stmt = $this->db->execute("SELECT role FROM users WHERE username = ?", [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user['role'] ?? 'klant'; // Retourneert de rol of 'klant' als geen rol is gevonden
    }

    // Methode om te controleren of de gebruiker is ingelogd
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Methode voor het uitloggen
    public function logout() {
        session_unset();
        session_destroy();
    }
}
