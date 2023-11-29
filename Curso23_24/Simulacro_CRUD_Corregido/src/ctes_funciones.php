<?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_horarios_exam");
    define("DIAS", ["Lunes","Martes","Miércoles","Jueves","Viernes"]);
    define("HORAS", ["8:15 - 9:15", "9:15 - 10:15", "10:15 - 11:15", "11:15 - 11:45", "11:45 - 12:45",  "12:45 - 13:45",  "13:45 - 14:45"]);

    function error_page($title, $body) {
        return (
            '<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>'.$title.'</title>
            </head>
            <body>
                '.$body.'
            </body>
            </html>'
        );
    }
?>