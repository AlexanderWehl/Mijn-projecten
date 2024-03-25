<?php

define('EENHEDEN', [5000, 2000, 1000, 500, 200, 100, 50, 20, 10, 5]);  

function checkArgumenten($argcount) 
{ 
    if ($argcount == 1) { 
            throw new Exception("geen wisselgeld gegeven");
    }
}

function checkNegatief($geldgeef) 
{
    if ($geldgeef <= 0) {
        throw new Exception("geen positief bedrag");
    }
}

function checkOngeldigeInvoer($geldgeef) 
{
    if (!is_numeric($geldgeef)) {
        throw new Exception("ongeldig (moet een getal zijn)");
    }
}

function calcWisselgeld($monie) 
{
    $wisselmonie = round(floatval($monie) * 20) * 5; 
    return $wisselmonie;
}

function showWisselgeld($geldgeef) 
{
    foreach (EENHEDEN as $eenheid) { 
        if ($geldgeef >= $eenheid) { 
            $count = floor($geldgeef / $eenheid); 
            if ($eenheid >= 100) { 
                echo "$count x " . $eenheid / 100 . " euro\n"; 
            } else { 
                echo "$count x " . $eenheid . " cent\n"; 
            }
            $geldgeef = $geldgeef % $eenheid; 
        }
    }
}



checkArgumenten($argc);

$geldgeef = calcWisselgeld($argv[1]);     
try {
    checkNegatief($geldgeef);
    checkOngeldigeInvoer($geldgeef);
} catch (Exception $e) {
    echo "Fout: " . $e->getMessage();
    exit;
}

showWisselgeld($geldgeef);

?>
