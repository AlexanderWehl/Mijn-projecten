<?php

session_start();

function omhoogvisiteteller() 
{
    $count = 1;
    if (isset($_SESSION['tellen'])) {
        $count = $_SESSION['tellen'];
        $count++;
    }
    $_SESSION['tellen'] = $count;
    return $count;
}

$visitetellen = omhoogvisiteteller();

?>

<!DOCTYPE html>
<head>
    <title>ik tel</title>
</head>
<body>
    <p>
        pagina is al <?= $visitetellen ?> x bezocht
    </p>
</body>
</html>