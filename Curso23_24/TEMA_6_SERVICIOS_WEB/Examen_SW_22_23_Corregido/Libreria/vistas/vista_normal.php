<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen SW_22-23</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }
        
        #libros{
            display: flex;
            justify-content: space-between;
            flex-flow: row wrap;
            width: 90%;
            margin: 0 auto;
        }

        #libros div{
            flex: 0 33%;
            text-align: center;
        }

        img{
            width: 100%;
            height: auto;
        }

        .error{
            color: red;
        }    
    </style>
</head>
<body>
    <h1>Librería - Vista Normal</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->lector; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php 
        require "vista_libros.php";
    ?>    
</body>
</html>