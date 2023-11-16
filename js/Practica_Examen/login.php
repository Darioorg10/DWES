<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    $usuario = $_GET["usuario"];
    $pwd = $_GET["pwd"];

    $respuesta = "";
    if ($usuario == "admin" && $pwd == "1234") {
        $respuesta = "USUARIO VÁLIDO";
    } else {
        $respuesta = "USUARIO NO VÁLIDO";
    }

    echo $respuesta;
?>