<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naam = trim($_POST['naam']);
    $email = trim($_POST['email']);
    $wachtwoord = $_POST['wachtwoord'];
    $wachtwoord_check = $_POST['wachtwoord_check'];
    
    // Validatie
    if (empty($naam) || empty($email) || empty($wachtwoord)) {
        $error = "Alle velden zijn verplicht";
    } elseif ($wachtwoord !== $wachtwoord_check) {
        $error = "Wachtwoorden komen niet overeen";
    } elseif (strlen($wachtwoord) < 6) {
        $error = "Wachtwoord moet minimaal 6 karakters zijn";
    } else {
        // Check of email al bestaat
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Dit email adres is al geregistreerd";
        } else {
            // Hash wachtwoord en sla op
            $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO users (naam, email, wachtwoord) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $naam, $email, $hashed_password);
            
            if ($stmt->execute()) {
                $success = "Account succesvol aangemaakt! Je kunt nu inloggen.";
            } else {
                $error = "Er ging iets mis. Probeer het opnieuw.";
            }
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
    <title>Registreren - EventPlanner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>EventPlanner</h1>
            <h2>Account aanmaken</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Naam:</label>
                    <input type="text" name="naam" required value="<?php echo isset($_POST['naam']) ? htmlspecialchars($_POST['naam']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label>Wachtwoord:</label>
                    <input type="password" name="wachtwoord" required>
                </div>
                
                <div class="form-group">
                    <label>Herhaal wachtwoord:</label>
                    <input type="password" name="wachtwoord_check" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Registreren</button>
            </form>
            
            <p class="text-center">
                Al een account? <a href="login.php">Inloggen</a>
            </p>
        </div>
    </div>
</body>
</html>
