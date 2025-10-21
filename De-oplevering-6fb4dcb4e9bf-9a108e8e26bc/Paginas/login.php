<?php
require_once 'config.php';

// Als al ingelogd, redirect naar dashboard
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $wachtwoord = $_POST['wachtwoord'];
    
    if (empty($email) || empty($wachtwoord)) {
        $error = "Vul alle velden in";
    } else {
        $stmt = $conn->prepare("SELECT id, naam, wachtwoord FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($wachtwoord, $user['wachtwoord'])) {
                // Login succesvol
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_naam'] = $user['naam'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Onjuist email of wachtwoord";
            }
        } else {
            $error = "Onjuist email of wachtwoord";
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
    <title>Inloggen - EventPlanner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h1>EventPlanner</h1>
            <h2>Inloggen</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Wachtwoord:</label>
                    <input type="password" name="wachtwoord" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Inloggen</button>
            </form>
            
            <p class="text-center">
                Nog geen account? <a href="register.php">Registreren</a>
            </p>
        </div>
    </div>
</body>
</html>
