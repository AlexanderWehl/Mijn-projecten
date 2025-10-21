<?php
require_once 'config.php';
requireLogin();

// Haal events op van ingelogde gebruiker
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM events WHERE user_id = ? ORDER BY datum ASC, tijd ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EventPlanner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="container">
            <h1>EventPlanner</h1>
            <div class="nav-links">
                <span>Welkom, <?php echo htmlspecialchars($_SESSION['user_naam']); ?>!</span>
                <a href="add_event.php" class="btn btn-primary">Nieuw Event</a>
                <a href="logout.php" class="btn btn-secondary">Uitloggen</a>
            </div>
        </div>
    </div>
    
    <div class="container main-content">
        <h2>Mijn Events</h2>
        
        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info">
                Je hebt nog geen events gepland. <a href="add_event.php">Voeg je eerste event toe!</a>
            </div>
        <?php else: ?>
            <div class="events-grid">
                <?php while ($event = $result->fetch_assoc()): ?>
                    <div class="event-card">
                        <h3><?php echo htmlspecialchars($event['titel']); ?></h3>
                        <p class="event-description"><?php echo nl2br(htmlspecialchars($event['omschrijving'])); ?></p>
                        <p class="event-date">
                            📅 <?php echo date('d-m-Y', strtotime($event['datum'])); ?> om <?php echo date('H:i', strtotime($event['tijd'])); ?>
                        </p>
                        <div class="event-actions">
                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-small btn-secondary">Bewerken</a>
                            <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Weet je zeker dat je dit event wilt verwijderen?')">Verwijderen</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
