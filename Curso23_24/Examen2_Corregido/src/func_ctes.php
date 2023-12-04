<?php

    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_horarios_exam");

    function error_page($title, $body){
        return "<!DOCTYPE html>
                <html lang='es'>
                <head>                    
                    <title>$title</title>
                </head>
                <body>
                    $body
                </body>
                </html>";
    }

?>