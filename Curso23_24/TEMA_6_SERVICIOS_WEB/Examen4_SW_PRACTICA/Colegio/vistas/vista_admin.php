<?php 

    $url = DIR_SERV."/alumnos";

    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);

    if (!$obj) {
        session_destroy();
        die(error_page("Examen4", "Ha habido un error en $url"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj->error.""));
    }

    if (isset($obj->no_auth)) {
        session_destroy();
        die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj->no_auth.""));
    }

    // Si se pulsa el botón de ver notas
    if (isset($_POST["btnVerNotas"])) {

        $url = DIR_SERV."/notasAlumno/".$_POST["alumno"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj2 = json_decode($respuesta);

        if (!$obj2) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error en $url"));
        }

        if (isset($obj2->error)) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj2->error.""));
        }

        if (isset($obj2->no_auth)) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj2->no_auth.""));
        }        

        $url = DIR_SERV."/NotasNoEvalAlumno/".$_POST["alumno"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj4 = json_decode($respuesta);

        if (!$obj4) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error en $url"));
        }

        if (isset($obj4->error)) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj4->error.""));
        }

    }

    if (isset($_POST["btnBorrar"])) {
        $url = DIR_SERV."/quitarNota/".$_POST["alumno"];
        $datos["cod_asig"] = $_POST["asignatura"];
        $respuesta = consumir_servicios_REST($url, "DELETE", $datos);
        $obj3 = json_decode($respuesta);

        if (!$obj3) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error en $url"));
        }

        if (isset($obj3->error)) {
            session_destroy();
            die(error_page("Examen4", "Ha habido un error al consumir el servicio: ".$obj3->error.""));
        }

        $_SESSION["mensaje_accion"] = "¡¡ Asignatura descalificada con éxito !!";
        $_SESSION["alumno"] = $_POST["alumno"];
        header("Location:index.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 4</title>
</head>
<style>

    .enlace{
        border: none;
        background: none;
        color: blue;
        text-decoration: underline;
        cursor: pointer;
    }

    .mensaje{
        font-size: 1.5em;
        color: blue;
    }

    table{
        border-collapse: collapse;
    }

    tr, th, td{
        border: 1px solid black;        
    }

    th{
        background-color: #CCC;
    }

</style>
<body>
    <h1>Vista admin</h1>

    <form action='index.php' method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button type="submit" name="btnSalir" class="enlace">Salir</button></p>
    </form>

    <?php 

        // Si no hay alumnos
        if (count($obj->alumnos) < 0) {
            echo "En estos momentos no tenemos ningún alumno registrado en la base de datos";
        } else {
            echo "<form action='index.php' method='post'>";
            echo "<label for='alumno'>Seleccione un alumno: </label>";
            echo "<select name='alumno' id='alumno'>";
            foreach ($obj->alumnos as $tupla) {
                if (isset($_POST["alumno"]) && $tupla->cod_usu == $_POST["alumno"]) {
                    $nombre_alumno = $tupla->nombre;
                    echo "<option selected value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                } else {
                    echo "<option value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                }                
            }
            echo "</select>";
            echo "&nbsp;";
            echo "<button type='submit' name='btnVerNotas'>Ver Notas</button>";    
            echo "</form>";
            echo "<br><br>";
        }

        if (isset($_POST["btnVerNotas"])) {
            echo "<form action='index.php' method='post'>";
            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
            foreach ($obj2->notas as $tupla) {
                echo "<tr>";
                echo "<td>".$tupla->denominacion."</td>";
                echo "<td>".$tupla->nota."</td>";
                echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'>";
                echo "<input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                echo "<td><button type='submit' name='btnEditar' class='enlace'>Editar</button> - <button type='submit' name='btnBorrar' class='enlace'>Borrar</button></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</form>";
            echo "<br><br>";

            if (count($obj4->notas) < 0) {
                echo "<p>A <strong>".$nombre_alumno."</strong> no le quedan asignaturas por calificar</p>";
            } else {
                echo "<form action='index.php' method='post'>";
                echo "<label for='porCalificar'>Asignaturas que a <strong>".$nombre_alumno."</strong> aún le quedan por calificar: </label>";
                echo "<select name='porCalificar'>";
                foreach ($obj4->notas as $tupla) {
                    echo "<option>".$tupla->denominación."</option>";
                }
                echo "</select>&nbsp;";
                echo "<button type='submit' name='btnCalificar'>Calificar</button>";
                echo "</form>";
            }

        }

        if (isset($_SESSION["mensaje_accion"])) {
            echo "<span class='mensaje'>".$_SESSION["mensaje_accion"]."</span>";
            unset($_SESSION["mensaje_accion"]);
            unset($_POST["alumno"]);
            if (isset($_SESSION["cod_asig"])) {
                unset($_SESSION["cod_asig"]);
            }
        }

    ?>


</body>
</html>