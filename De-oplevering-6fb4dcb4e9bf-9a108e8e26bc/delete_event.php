<?php
require_once 'config.php';
requireLogin();

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Verwijder alleen als event van deze person is
$stmt = $conn->prepare("DELETE FROM events WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$stmt->close();

header("Location: dashboard.php");
exit();
?>
