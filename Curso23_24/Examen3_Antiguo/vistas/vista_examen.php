<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primer Login</title>
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

        table {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        table,
        tr,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            background-color: #CCC;
        }

        img {
            height: 100px;
        }
    </style>
</head>
<body>
    <h1>Primer Login - Vista Normal</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_logueado["usuario"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <h3>Listado de películas</h3>
    <?php

    try {
        $consulta = "select * from peliculas";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("No se ha podido realizar la consulta: " . $e->getMessage() . "</p>");
    }

    echo "<table>";
    echo "<tr><th>id</th><th>Título</th><th>Carátula</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td>".$tupla["idPelicula"]."</td>";
        echo "<td>".$tupla["titulo"]."</td>";
        echo "<td><img src='Img/".$tupla["caratula"]."' alt='Carátula' title='Carátula'></td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);

    ?>
</body>

</html>