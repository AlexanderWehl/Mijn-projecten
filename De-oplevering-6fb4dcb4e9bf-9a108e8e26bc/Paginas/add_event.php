<?php
require_once 'config.php';
requireLogin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titel = trim($_POST['titel']);
    $omschrijving = trim($_POST['omschrijving']);
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $user_id = $_SESSION['user_id'];
    
    if (empty($titel) || empty($datum) || empty($tijd)) {
        $error = "Titel, datum en tijd zijn verplicht";
    } else {
        $stmt = $conn->prepare("INSERT INTO events (user_id, titel, omschrijving, datum, tijd) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $titel, $omschrijving, $datum, $tijd);
        
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
    <title>Event Toevoegen - EventPlanner</title>
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
            <h2>Nieuw Event Toevoegen</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Titel:</label>
                    <input type="text" name="titel" required value="<?php echo isset($_POST['titel']) ? htmlspecialchars($_POST['titel']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Omschrijving:</label>
                    <textarea name="omschrijving" rows="4"><?php echo isset($_POST['omschrijving']) ? htmlspecialchars($_POST['omschrijving']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Datum:</label>
                    <input type="date" name="datum" required value="<?php echo isset($_POST['datum']) ? $_POST['datum'] : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Tijd:</label>
                    <input type="time" name="tijd" required value="<?php echo isset($_POST['tijd']) ? $_POST['tijd'] : ''; ?>">
                </div>
                
                <button type="submit" class="btn btn-primary">Event Toevoegen</button>
                <a href="dashboard.php" class="btn btn-secondary">Annuleren</a>
            </form>
        </div>
    </div>
</body>
</html>
