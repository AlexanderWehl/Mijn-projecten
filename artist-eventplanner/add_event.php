<?php
session_start();
require 'includes/db_connect.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("INSERT INTO events (user_id, title, description, event_date, event_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $_POST['title'], $_POST['description'], $_POST['date'], $_POST['time']]);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Event Toevoegen</title>
</head>
<body class="container py-5">
    <h2>Nieuw Event</h2>
    <form method="POST" class="col-md-6">
        <input type="text" name="title" placeholder="Titel (bijv. Show Melkweg)" class="form-control mb-2" required>
        <textarea name="description" placeholder="Beschrijving" class="form-control mb-2"></textarea>
        <input type="date" name="date" class="form-control mb-2" required>
        <input type="time" name="time" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="index.php" class="btn btn-secondary">Annuleren</a>
    </form>
</body>
</html>
