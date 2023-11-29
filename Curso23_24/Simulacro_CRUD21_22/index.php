<?php 
    // Creamos la sesión (la destruimos antes de cada die)
    session_name("Simulacro_CRUD_21_22");
    session_start();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulacro examen php</title>
    <style>
    
        table{
            margin: 0 auto;
            width: 80%;
        }

        td, th{
            border: 1px solid black;
            border-collapse: collapse;
            padding: 1rem;
            text-align: center;
        }

        th{
            background-color: #CCC;
        }

        div{            
            text-align: center;
        }

        .error{
            color:red;
        }

        .mensaje{
            color:blue;
            font-size: 20px;
        }

        .enlace{
            background-color: white;
            border: none;
            color: blue;
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <h1>Simulacro examen PHP</h1>
    <h2>Horario de los profesores</h2>
    <!-- Creamos el formulario que tendrá el select -->
    <form action="index.php" method="post">
    <p>Horario del profesor: 
            <?php 
                // Nos tenemos que conectar a la base de datos y sacar el 
                // nombre de los usuarios para ponerlo en cada option

                // Hacemos la conexión con la base de datos
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
                    mysqli_set_charset($conexion, "utf8"); // Establecemos el charset a utf8                    
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No ha podido realizarse la conexión a la base de datos: ".$e->getMessage()." </p></body></html>"); // Cerramos el body y el html, el error_page lo hacemos solo antes del html
                }

                // Hacemos el select para sacar el nombre
                try {
                    $consulta = "select nombre from usuarios";
                    $resultado = mysqli_query($conexion, $consulta);
                    $_SESSION["mensaje"] = "Has hecho el select con éxito";
                } catch (Exception $e) {
                    session_destroy();
                    die("<p>No ha podido realizarse el select a la base de datos: ".$e->getMessage()." </p></body></html>");
                }                

            ?>

        <select name="horarioSel" id="horarioSel">
            <?php 
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='".$tupla["nombre"]."'>".$tupla["nombre"]."</option>";                                    
                }                
            ?>
        </select>
        <button type="submit" name="btnVerHorario">Ver horario</button>
    </form>        
    </p>

    <?php 
        if (isset($_POST["btnVerHorario"])) {
            echo "<div>";
            echo "<h3>Horario del profesor: ".$_POST["horarioSel"]."</h3>"; // En este caso pasamos el nombre con el post del select, porque al estar el botón fuera del while no podemos meterle el valor
            echo "</div>";

            // Mostramos la tabla
            echo "<table>";
            // Ponemos los días
            echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
            // Ponemos las horas
            echo "<tr><th>8:15-9:15</th></tr>";
            echo "<tr><th>9:15-10:15</th></tr>";
            echo "<tr><th>10:15-11:15</th></tr>";
            echo "<tr><th>11:15-11:45</th><td colspan='5'>RECREO</td></tr>";
            echo "<tr><th>11:45-12:45</th></tr>";
            echo "<tr><th>12:45-13:45</th></tr>";
            echo "<tr><th>13:45-14:45</th></tr>";
            // Tenemos que mostrar el nombre del grupo

            echo "</table>";

            // Mostramos el mensaje de la sesión y lo destruimos
            if (isset($_SESSION["mensaje"])) {
                echo "<p class='mensaje'>".$_SESSION["mensaje"]."</p>";
                session_destroy();
            }

        }
    ?>
</body>
</html>