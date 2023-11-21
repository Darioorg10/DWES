<?php 
    require "src/ctes_funciones.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Videoclub</title>
    <style>
        table{
            border-collapse: collapse;
        }

        table, th, td{
            border: 1px solid black;
        }

        th{
            background-color: #CCC;
        }

        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }        
    </style>
</head>
<body>
    <h1>Video Club</h1>
    <h2>Películas</h2>
    <h3>Listado de películas</h3>
    <?php
        // Nos conectamos con la base de datos
        try {
            $conexion = mysqli_connect(HOST, USUARIO_BD, CLAVE_BD, NOMBRE_BD);                
        } catch (Exception $e) {
            die(error_page("Videoclub", "<p>No se ha podido realizar la conexión con la base de datos: ".$e->getMessage()." </p>"));
        }

        // Hacemos la consulta para mostrar la tabla
        try {
            $consulta = "select * from peliculas";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die(error_page("Videoclub", "<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
            }            

        $tupla = mysqli_fetch_assoc($resultado);
        ?>
        <table>
            <tr>
                <th>id</th>
                <th>Título</th>
                <th>Carátula</th>
                <th><button type="submit" class="enlace" name="btnInsertar">Películas+</button></th>
            </tr>
        <?php
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <?php
            // Liberamos el resultado luego de haber hecho un select
            mysqli_free_result($resultado);
        ?>
    </table>
</body>
</html>