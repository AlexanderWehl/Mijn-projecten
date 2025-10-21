<?php
require_once 'config.php';
requireLogin();

$error = '';
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Haal event op en check of het van deze user is
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit();
}

$event = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = trim($_POST['titel']);
    $omschrijving = trim($_POST['omschrijving']);
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    
    if (empty($titel) || empty($datum) || empty($tijd)) {
        $error = "Titel, datum en tijd zijn verplicht";
    } else {
        $stmt = $conn->prepare("UPDATE events SET titel = ?, omschrijving = ?, datum = ?, tijd = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ssssii", $titel, $omschrijving, $datum, $tijd, $event_id, $user_id);
        
        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Er ging iets mis. Probeer het opnieuw.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Bewerken - EventPlanner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="navbar">
        <div class="container">
            <h1>EventPlanner</h1>
            <div class="nav-links">
                <a href="dashboard.php" class="btn btn-secondary">Terug naar Dashboard</a>
                <a href="logout.php" class="btn btn-secondary">Uitloggen</a>
            </div>
        </div>
    </div>
    
    <div class="container main-content">
        <div class="form-box">
            <h2>Event Bewerken</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Titel:</label>
                    <input type="text" name="titel" required value="<?php echo htmlspecialchars($event['titel']); ?>">
                </div>
                
                <div class="form-group">
                    <label>Omschrijving:</label>
                    <textarea name="omschrijving" rows="4"><?php echo htmlspecialchars($event['omschrijving']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Datum:</label>
                    <input type="date" name="datum" required value="<?php echo $event['datum']; ?>">
                </div>
                
                <div class="form-group">
                    <label>Tijd:</label>
                    <input type="time" name="tijd" required value="<?php echo $event['tijd']; ?>">
                </div>
                
                <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
            </form>
        </div>
    </div>
</body>
</html>
