<?php
require "src/ctes_funciones.php";
session_name("examen");
session_start();

// Botón añadir
if (isset($_POST["btnAñadir"])) {
    // Conexión
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Error","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    // Inserción
    try {
        $consulta = "insert into horario_lectivo (usuario, dia, hora, grupo) values ('" . $_POST["profesores"] . "', '" . $_POST["dia"] . "', '" . $_POST["hora"] . "', '" . $_POST["grupos"] . "')";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Error","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    $_SESSION["mensaje"] = "Grupo insertado con éxito.";
    $_SESSION["profesores"] = $_POST["profesores"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    header("Location:index.php");
    exit();
}


// Botón quitar
if (isset($_POST["btnQuitar"])) {
    // Conexión
    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        die(error_page("Error","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    // Delete
    try {
        $consulta = "delete from horario_lectivo where usuario='" . $_POST["profesores"] . "' and dia='" . $_POST["dia"] . "' and hora='" . $_POST["hora"] . "' and grupo='" . $_POST["btnQuitar"] . "'";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die(error_page("Error","<p>Ha habido un error: " . $e->getMessage() . "</p>"));
    }

    $_SESSION["mensaje"] = "Grupo borrado con éxito.";
    $_SESSION["profesores"] = $_POST["profesores"];
    $_SESSION["dia"] = $_POST["dia"];
    $_SESSION["hora"] = $_POST["hora"];
    header("Location:index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen</title>
    <style>
        table,
        th,
        tr,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        table {
            width: 50%;
            margin: 1rem;
        }

        table#central {
            width: 80%;
            margin: 0 auto;
        }

        th {
            background-color: #CCC;
        }

        .enlace {
            color: blue;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
    // Mostramos los profesores disponibles para ver su horario

    // Conexión
    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
        }
    }

    // Select de profesores
    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
    }

    // Si tenemos profesores en la BD
    if (mysqli_num_rows($resultado) > 0) {
    ?>
        <form action="index.php" method="post">
            <p>
                <label for="profesores">Horario del Profesor: </label>
                <select name="profesores" id="profesores">
                    <?php
                    while ($tupla = mysqli_fetch_assoc($resultado)) {
                        // Guardamos codigo y nombre del seleccionado
                        if ((isset($_POST["profesores"]) && $_POST["profesores"] == $tupla["id_usuario"]) || (isset($_SESSION["profesores"]) && $_SESSION["profesores"] == $tupla["id_usuario"])) {
                            echo "<option selected value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                            $cod_prof = $tupla["id_usuario"];
                            $nombre = $tupla["nombre"];
                        } else {
                            echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
                        }
                    }

                    ?>
                </select>
                <button type="submit" name="btnVerHorario" value="<?php if (isset($cod_prof)) echo $cod_prof ?>">Ver Horario</button>
            </p>
        </form>
    <?php
    } else {
        // Si no hay profesores
        echo "<p>No hay profesores en la BD.</p>";
    }


    // Si le damos a algún botón
    if (isset($_POST["btnVerHorario"]) || isset($_POST["btnEditar"]) || isset($_SESSION["profesores"])) {
        
        // Título con nombre
        if (isset($_POST["btnVerHorario"]) || isset($_SESSION["profesores"])) {
            echo "<h3 style='text-align: center'>Horario del Profesor: " . $nombre . "</h3>";
        } else {
            echo "<h3 style='text-align: center'>Horario del Profesor: " . $_POST["nombre"] . "</h3>";
        }

        // Valor de profesores
        if (isset($_SESSION["profesores"])) {
            $profesores = $_SESSION["profesores"];
        } else {
            $profesores = $_POST["profesores"];
        }

        // Conexión (ya estamos conectado al listar los profes en el select)
        // Consulta de las clases del profe seleccionado
        try {
            $consulta = "select usuario, dia, hora, grupos.nombre from horario_lectivo,grupos where horario_lectivo.grupo=grupos.id_grupo && usuario='" . $profesores . "' order by hora asc, dia asc";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
        }

        // Guardamos los resultados en el array $horarios por si hay varias clases a la misma hora
        while ($tupla = mysqli_fetch_assoc($resultado)) {
            if (isset($horario[$tupla["hora"]][$tupla["dia"]])) // Si hay más de una clase concateno
                $horario[$tupla["hora"]][$tupla["dia"]] .= " / " . $tupla["nombre"];
            else // Si no hay clases, la añadimos
                $horario[$tupla["hora"]][$tupla["dia"]] = $tupla["nombre"];
        }

        // Creamos la tabla del horario
        // Fila de los días de la semana
        echo "<table id='central'>
            <tr><th></th>";
        for ($i = 0; $i < count(DIAS); $i++) {
            echo "<th>" . DIAS[$i] . "</th>";
        }
        echo "</tr>";
        // Por cada hora vamos a poner la hora, si existe alguna clase y el botón editar
        // Excepto el recreo
        for ($i = 0; $i < count(HORAS); $i++) {
            echo "<tr><th>" . HORAS[$i] . "</th>";
            if ($i != 3) { // Si no es el recreo
                for ($j = 0; $j < count(DIAS); $j++) {
                    echo "<td><form action='index.php' method='post'>";
                    // Si ese profesor tiene esa clase tal dia tal hora ponlo
                    if (isset($horario[$i][$j])) {
                        echo "<p>" . $horario[$i][$j] . "</p>";
                    }
                    echo "<input type='hidden' name='hora' value='" . $i . "'>";
                    echo "<input type='hidden' name='dia' value='" . $j . "'>";
                    echo "<input type='hidden' name='nombre' value='" . $nombre . "'>";
                    echo "<input type='hidden' name='profesores' value='" . $profesores . "'>";
                    echo "<button class='enlace' name='btnEditar'>Editar</button>";
                    echo "</form></td>";
                }
            } else { // Si es el recreo
                echo "<td colspan='5'>RECREO</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        // Si le damos a editar, insertar o quitar
        if (isset($_POST["btnEditar"]) || isset($_SESSION["profesores"])) {

            // Variables
            if (isset($_SESSION["profesores"])) {
                $profesores = $_SESSION["profesores"];
                $dia = $_SESSION["dia"];
                $hora = $_SESSION["hora"];
            } else {
                $profesores = $_POST["profesores"];
                $dia = $_POST["dia"];
                $hora = $_POST["hora"];
            }

            // Para mostrar el número de hora seleccionado
            $num_hora = $hora;
            if ($num_hora < 3) {
                $num_hora++;
            }

            echo "<h2>Editando la " . $num_hora . "º (" . HORAS[$hora] . ") del " . DIAS[$dia] . "</h2>";

            // Consulta de las grupos del profesor en ese día
            try {
                $consulta = "select id_grupo, nombre from horario_lectivo, grupos where grupo=id_grupo and usuario = '" . $profesores . "' and dia = '" . $dia . "' and hora = '" . $hora . "'";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                session_destroy();
                mysqli_close($conexion);
                die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
            }

            // Si hemos realizado alguna acción, muestra el mensaje
            if (isset($_SESSION["mensaje"])) {
                echo "<p>" . $_SESSION["mensaje"] . "</p>";
                session_destroy();
            }

            // Creamos la tabla de los grupos
            echo "<table>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";

            // Si hay grupos, ponemos su nombre y el botón quitar
            if (mysqli_num_rows($resultado) > 0) {
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo "
                    <tr>
                        <td>" . $tupla["nombre"] . "</td>
                        <td>
                            <form action='index.php' method='post'>
                                <input type='hidden' name='hora' value='" . $hora . "'>
                                <input type='hidden' name='dia' value='" . $dia . "'>
                                <input type='hidden' name='profesores' value='" . $profesores . "'>
                                <button name='btnQuitar' class='enlace' value='" . $tupla["id_grupo"] . "'>Quitar</button>
                            </form>
                        </td>
                    </tr>";
                }
            }
            echo "</table>";

            // Consulta de las grupos que no tiene ese dia el profesor
            try {
                $consulta = "select * from grupos where id_grupo not in (select id_grupo from horario_lectivo, grupos where grupo=id_grupo and usuario = '" . $profesores . "' and dia = '" . $dia . "' and hora = '" . $hora . "')";
                $resultado = mysqli_query($conexion, $consulta);
            } catch (Exception $e) {
                session_destroy();
                mysqli_close($conexion);
                die("<p>Ha habido un error: " . $e->getMessage() . "</p></body></html>");
            }

            // Si hay grupos que no tenga el profesor ese dia disponible
            // Podrá elegir mediante un select la que quiera añadir
            if (mysqli_num_rows($resultado) > 0) {
                echo "<form action='index.php' method='post'>";
                echo '<select name="grupos" id="grupos">';
                while ($tupla = mysqli_fetch_assoc($resultado)) {
                    echo '<option value="' . $tupla['id_grupo'] . '">' . $tupla["nombre"] . '</option>';
                }
                echo "</select> ";
                echo "<input type='hidden' name='dia' value='" . $dia . "'>";
                echo "<input type='hidden' name='hora' value='" . $hora . "'>";
                echo "<input type='hidden' name='profesores' value='" . $profesores . "'>";
                echo "<button name='btnAñadir' type='submit'>Añadir</button>";
                echo "</form>";
            } else { // No hay grupos disponibles
                echo "<p>No hay más grupos.</p>";
            }
        }
    }

    // Liberamos y cerramos la conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion);
    ?>
</body>

</html>