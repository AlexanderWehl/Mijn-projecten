<?php
session_start();
require 'includes/db_connect.php';

// Check of gebruiker is ingelogd
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// JOIN Query: Haal events op en koppel de gebruikersnaam
$stmt = $pdo->prepare("
    SELECT events.*, users.name 
    FROM events 
    JOIN users ON events.user_id = users.id 
    WHERE events.user_id = ? 
    ORDER BY event_date ASC
");
$stmt->execute([$user_id]);
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Artist Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Mijn Planning, <?= htmlspecialchars($_SESSION['user_name']); ?></h1>
            <a href="logout.php" class="btn btn-outline-danger">Uitloggen</a>
        </div>

        <a href="add_event.php" class="btn btn-primary mb-3">+ Nieuw Event</a>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Tijd</th>
                            <th>Event</th>
                            <th>Omschrijving</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= $event['event_date']; ?></td>
                            <td><?= $event['event_time']; ?></td>
                            <td><strong><?= htmlspecialchars($event['title']); ?></strong></td>
                            <td><?= htmlspecialchars($event['description']); ?></td>
                            <td>
                                <a href="edit.php?id=<?= $event['id']; ?>" class="btn btn-sm btn-warning">Bewerk</a>
                                <button onclick="confirmDelete(<?= $event['id']; ?>)" class="btn btn-sm btn-danger">Wis</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>