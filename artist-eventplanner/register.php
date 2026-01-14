<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Check of we de data wel ontvangen
    $name = $_POST['name'] ?? 'Geen naam';
    $email = $_POST['email'] ?? 'Geen email';
    $pass_raw = $_POST['password'] ?? '';

    if (empty($email) || empty($pass_raw)) {
        echo "Vul alle velden in!";
    } else {
        $password = password_hash($pass_raw, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $result = $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $password
            ]);

            if ($result) {
                echo "Succes! Gebruiker is toegevoegd. <a href='login.php'>Ga naar login</a>";
                exit;
            }
        } catch (PDOException $e) {
            // 3. Hier zie je de fout als de database weigert
            echo "Database Fout: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<body>
    <h2>Test Registratie</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Naam" required><br>
        <input type="email" name="email" placeholder="E-mail" required><br>
        <input type="password" name="password" placeholder="Wachtwoord" required><br>
        <button type="submit">Registreer nu</button>
    </form>
</body>
</html>