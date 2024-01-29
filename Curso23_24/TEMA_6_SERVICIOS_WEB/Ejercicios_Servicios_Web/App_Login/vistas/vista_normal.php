<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista normal</title>
    <style>
        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .enlinea{
            display: inline;
        }
    </style>
</head>
<body>
    <h1>Vista normal</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong> - 
        <form class="enlinea" action="index.php" method="post">
            <button class="enlace" type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
</body>
</html>