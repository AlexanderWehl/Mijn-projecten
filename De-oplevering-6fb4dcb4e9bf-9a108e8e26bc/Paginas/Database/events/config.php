<?php
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); 
define('DB_NAME', 'eventplanner');

// Maak database connectie
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connectie mislukt: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// Helper functie
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Helper functie
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}
?>
