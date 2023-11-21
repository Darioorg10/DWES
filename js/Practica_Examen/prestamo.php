<?php 
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    $capital = $_GET["capital"];
    $interes = $_GET["interes"];
    $plazo = $_GET["plazo"];

    $interes_mensual = $interes/12/100;

    $resultado = ($capital+$capital*$interes_mensual)/$plazo;

    echo $resultado;

?>