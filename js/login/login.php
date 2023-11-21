<?php
$param1 = $_REQUEST["usuario"];
$param2 = $_REQUEST["pwd"];
$resultado = "";
     
    if ($param1 !== "admin" || $param2 !== "1234") {
        $resultado = "USUARIO NO VÁLIDO";            
    } else {
        $resultado = "USUARIO VÁLIDO";
    }
        echo $resultado;               
?>