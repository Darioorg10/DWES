<?php 
    $capital = $_REQUEST["capital"];
    $interes = $_REQUEST["interes"];
    $plazo = $_REQUEST["plazo"];

    $interes_mensual = $interes/100/12;
    $resultado = ($capital + $capital * $interes_mensual) / $plazo;

    echo $resultado;
?>