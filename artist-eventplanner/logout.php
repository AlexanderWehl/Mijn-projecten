<?php
session_start();
// Vernietig alle sessie variabelen
session_unset();
// Vernietig de sessie zelf
session_destroy();

// Terug naar de login pagina
header("Location: login.php");
exit;