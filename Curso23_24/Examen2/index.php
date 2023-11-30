<?php
    
    function error_page($title,$body)
    {
        $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html.='<title>'.$title.'</title></head>';
        $html.='<body>'.$body.'</body></html>';
        return $html;
    }

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Examen2 PHP</title>
    </head>
    <style>
        .error{
            color:red;
        }

        .enlace{
            border: none;
            background-color: white;
            color: blue;
            text-decoration: underline;
        }

        table, td, th{
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <body>
        <h1>Examen2 PHP</h1>
        <h2>Horario de los Profesores</h2>
    
    </body>
</html>