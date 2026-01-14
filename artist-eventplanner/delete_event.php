<?php
session_start();
require 'includes/db_connect.php';

// Check of de gebruiker is ingelogd en of er een ID is meegegeven
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Verwijder alleen als het event ook echt bij deze gebruiker hoort (extra veiligheid)
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ? AND user_id = ?");
    $stmt->execute([$event_id, $user_id]);
}

// Stuur de gebruiker direct terug naar het dashboard
header("Location: index.php");
exit;