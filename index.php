<?php
include_once "app/vars.php";
include_once "app/functions.php";
global $tablero, $ataques;

if(isset($_POST['tablero']) && isset($_POST['ataques'])){
    $tablero = unserialize($_POST['tablero']);
    $ataques = unserialize($_POST['ataques']);
}else{
    setBarcos();
}

$res = "";
if (isset($_POST['fila']) && isset($_POST['columna'])) {
    switch (strtoupper($_POST['fila'])) {
        case "A":
            $fila = 0;
        break;
        case "B":
            $fila = 1;
        break;
        case "C":
            $fila = 2;
        break;
        case "D":
            $fila = 3;
        break;
        case "E":
            $fila = 4;
        break;
        case "F":
            $fila = 5;
        break;
        case "G":
            $fila = 6;
        break;
        case "H":
            $fila = 7;
        break;
        case "I":
            $fila = 8;
        break;
        case "J":
            $fila = 9;
        break;
    }
    $columna = (int)$_POST['columna']-1;
    if ($ataques[$fila][$columna]==0) {
        $ataques[$fila][$columna]=1;
        if ($tablero[$fila][$columna] == 1) {
            $res = "Le has dado a un barco";
            $tablero[$fila][$columna] = 2;
        } else {
            $res = "Agua";
        }
    } else {
        $res='Ya has atacado aqui';
    }

}

$victoria = isVictoria($tablero);

$bodyOutput = getBodyOutput($ataques, $tablero, $victoria);
$bodyOutput .= '<h2>'.$res.'</h2>';

include_once "templates/templateIndex.php";
?>