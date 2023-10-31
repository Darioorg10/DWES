<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría BD</title>
    <style>
        table, th, td{
            border: 1px solid black;
        }
        table{
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }
        th{
            background-color: #CCC;
        }
    </style>
</head>
<body>
    <h1>Teoría base de datos</h1>
    <?php
        try { // Nos conectamos con la BD controlando excepciones
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_teoria"); // Ponemos al servidor donde accedemos, el nombre, la contraseña y la base de datos
            mysqli_set_charset($conexion, "utf8"); // Establecemos el charset utf8
        } catch (Exception $e) {
            die("<p>No ha sido posible establecer una conexión con la base de datos: ".$e->getMessage()."</p></body></html>");
        }
        
        $consulta = "select * from t_alumnos";
        
        try { // Hacemos una consulta
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion); // Cerramos la conexión 0si no se puede hacer la consulta
            die("<p>No ha sido posible realizar la consulta: ".$e->getMessage()."</p></body></html>");
        }

        $n_tuplas = mysqli_num_rows($resultado); // Te da el número de tuplas(filas) que saca de la consulta
        echo "<p>El número de tuplas obtenidas ha sido: $n_tuplas</p>";

        $tupla = mysqli_fetch_assoc($resultado); // Me mete un array asociativo por columnas
        print_r($tupla);
        echo "<p>El primer alumno obtenido tiene el nombre: ".$tupla["nombre"]."</p>"; // Si hicieramos otro print del $tupla["nombre"] aparecería el siguiente

        $tupla = mysqli_fetch_row($resultado);
        echo "<p>El segundo alumno obtenido tiene el nombre: ".$tupla[1]."</p>";

        $tupla = mysqli_fetch_array($resultado); // Este no le ha hecho falta ni una vez, te hace tanto lo del asociativo como el escalar (de las columnas)
        echo "<p>El tercer alumno obtenido tiene el nombre: ".$tupla[1]."</p>";
        echo "<p>El tercer alumno obtenido tiene el nombre: ".$tupla["nombre"]."</p>";

        // Volvemos al principio
        mysqli_data_seek($resultado, 0); // Vamos a la fila que le pasamos por parámetro
        echo "----------------------------------------------------------------------";

        $tupla = mysqli_fetch_object($resultado);
        echo "<p>El primer alumno obtenido tiene el nombre: ".$tupla->nombre."</p>";        

        // Vamos a hacer una tabla como muestre los datos
        mysqli_data_seek($resultado, 0); // Volvemos al principio
        echo "<table>";
        echo "<tr><th>Código</th><th>Nombre</th><th>Teléfono</th><th>Cód.Postal</th></tr>"; // Ponemos filas con 4 columnas
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>".$tupla["cod_alu"]."</td>";
            echo "<td>".$tupla["nombre"]."</td>";
            echo "<td>".$tupla["telefono"]."</td>";
            echo "<td>".$tupla["cp"]."</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Después de trabajar con los resultados, hay que liberarlos (solo cuando se hace un select)
        mysqli_free_result($resultado);

        mysqli_close($conexion); // Cerramos la conexión
    ?>
</body>
</html>