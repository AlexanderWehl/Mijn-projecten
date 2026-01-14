<?php
session_start();
require 'includes/db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$_POST['email']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
    } else {
        $error = "Onjuiste gegevens.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body class="bg-light container py-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h2>Login</h2>
            <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <form method="POST">
                <input type="email" name="email" class="form-control mb-2" placeholder="E-mail" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Wachtwoord" required>
                <button type="submit" class="btn btn-success w-100">Inloggen</button>
            </form>
            <p class="mt-3">Nog geen account? <a href="register.php">Registreer hier</a></p>
        </div>
    </div>
</body>
</html>