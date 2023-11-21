<?php

define("HOST", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_videoclub");

function error_page($title, $body){
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <title>".$title."</title>
    </head>
    <body>".$body."</body>
    </html>";
}

?>