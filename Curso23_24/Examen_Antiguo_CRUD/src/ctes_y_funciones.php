<?php

    define("NOMBRE_HOST", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_exam_colegio");

    function error_page($title, $body){
        $error = "<!DOCTYPE html>
        <html>
        <head>$title</head>
        <body>$body</body>
        </html>";
    }

?>