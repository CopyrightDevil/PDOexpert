<?php
require_once "../includes/db.php";

class User {
    private $db;

    public function __construct(DB $db) {
        $this->db = $db;
    }

    public function register($username, $password, $role) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->execute("INSERT INTO users (username, password, role) VALUES (?, ?, ?)", [$username, $hashedPassword, $role]);
    }

    public function login($username, $password) {
        
        $user = $this->db->execute("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 
            $_SESSION['logged_in'] = true;

            return true;
        } else {
            return false;
        }
    }

    
    public function getRole($username) {
        $stmt = $this->db->execute("SELECT role FROM users WHERE username = ?", [$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user['role'] ?? 'klant'; 
    }

   
    public function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    
    public function logout() {
        session_unset();
        session_destroy();
    }
}
