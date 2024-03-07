<?php     

    if (isset($_POST["btnBorrar"])) {

            $url=DIR_SERV."/quitarNota/".$_POST["alumno"];
            $datos["cod_asig"] = $_POST["asignatura"];            
            $respuesta=consumir_servicios_REST($url,"DELETE",$datos); // El $datos["api_session"] ya lo pasamos en seguridad
            $obj=json_decode($respuesta); // Aquí no hace falta poner $obj4 porque saltamos
            if(!$obj)
            {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
            }

            $_SESSION["alumno"] = $_POST["alumno"];            
            $_SESSION["mensaje_accion"] = "¡¡ Nota borrada con éxito !!";
            header("Location:index.php");
            exit;
    }

    if (isset($_POST["btnCambiar"])) {
        $error_nota = $_POST["nota"] == "" || !is_numeric($_POST["nota"]) || $_POST["nota"] < 0 || $_POST["nota"] > 10;
        if (!$error_nota) {

            $url=DIR_SERV."/cambiarNota/".$_POST["alumno"];
            $datos["cod_asig"] = $_POST["asignatura"];
            $datos["nota"] = $_POST["nota"];
            $respuesta=consumir_servicios_REST($url,"PUT",$datos); // El $datos["api_session"] ya lo pasamos en seguridad
            $obj=json_decode($respuesta); // Aquí no hace falta poner $obj4 porque saltamos
            if(!$obj)
            {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if(isset($obj->error))
            {
                session_destroy();
                die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
            }

            $_SESSION["alumno"] = $_POST["alumno"];            
            $_SESSION["mensaje_accion"] = "¡¡ Nota cambiada con éxito !!";
            header("Location:index.php");
            exit;
        }
    }

    if (isset($_POST["btnCalificar"])) {
        $url=DIR_SERV."/ponerNota/".$_POST["alumno"];
        $datos["cod_asig"] = $_POST["cod_asig"];        
        $respuesta=consumir_servicios_REST($url,"POST",$datos);
        $obj=json_decode($respuesta); // Aquí no hace falta poner $obj4 porque saltamos
        if(!$obj)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj->error))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
        }

        $_SESSION["alumno"] = $_POST["alumno"];
        $_SESSION["cod_asig"] = $_POST["cod_asig"]; // Para quedarnos ahora en la nota de la asignatura a editar
        $_SESSION["mensaje_accion"] = "¡¡ Asignatura calificada con un 0. Cambie la nota si lo estima necesario !!";
        header("Location:index.php");
        exit;
        
    }

    if (isset($_SESSION["alumno"])) {
        $_POST["alumno"] = $_SESSION["alumno"];
        unset($_SESSION["alumno"]);
    }

    if (isset($_SESSION["cod_asig"])) {
        $_POST["asignatura"] = $_SESSION["cod_asig"];
        $_POST["btnEditar"] = true; // Así hacemos que exista
    }

    $url=DIR_SERV."/alumnos";
    $respuesta=consumir_servicios_REST($url,"GET",$datos); // El $datos["api_session"] ya lo pasamos en seguridad
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }

    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj->error."</p>"));
    }

    if (isset($_POST["alumno"])) { // Si existe alumno (se ha pulsado el botón de ver notas), cogemos sus notas
        $url=DIR_SERV."/notasAlumno/".$_POST["alumno"];
        $respuesta=consumir_servicios_REST($url,"GET",$datos);
        $obj2=json_decode($respuesta);
        if(!$obj2)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj2->error))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj2->error."</p>"));
        }

        $url=DIR_SERV."/NotasNoEvalAlumno/".$_POST["alumno"];
        $respuesta=consumir_servicios_REST($url,"GET",$datos);
        $obj3=json_decode($respuesta);
        if(!$obj3)
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if(isset($obj3->error))
        {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24","<h1>Notas de los alumnos</h1><p>".$obj3->error."</p>"));
        }
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colegios - Vista admin</title>
    <style>

        .enlinea{
            display: inline;
        }

        .enlace{
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .error{
            color: red;
        }

        .mensaje{
            font-size: 1.25rem;
            color: blue;
        }

        table{
            border-collapse: collapse;
            text-align: center;
        }

        tr, th, td{
            border: 1px solid black;
        }

        th{
            background-color: #CCC;
        }

    </style>
</head>
<body>
    <h1>Notas da los alumnos</h1>
    <div>
        Bienvenido <strong><?php echo $datos_usuario_log->usuario ?></strong> - <form class='enlinea' action="index.php" method="post"><button name="btnSalir" type="submit" class="enlace">Salir</button></form>
    </div>
    <?php 
        if (count($obj->alumnos) <= 0) {
            echo "<p>En estos momentos no tenemos ningún alumno registrado en la base de datos</p>";
        } else {
    ?>

        <form action="index.php" method="post">
            <p>
                <label for="alumno">Seleccione un alumno: </label>
                <select name="alumno" id="alumno">
                    <?php 
                        foreach ($obj->alumnos as $tupla) {
                            if (isset($_POST["alumno"]) && $_POST["alumno"] == $tupla->cod_usu) {
                                $nombre_alumno = $tupla->nombre;
                                echo "<option selected value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                            } else {
                                echo "<option value='".$tupla->cod_usu."'>".$tupla->nombre."</option>";
                            }                            
                        }
                    ?>
                </select>
                <button type="submit" name="btnVerNotas">Ver notas</button>
            </p>
        </form>
        
    <?php

        if (isset($_POST["alumno"])) {
            echo "<h2>Notas del alumno ".$nombre_alumno."</h2>";

            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Nota</th><th>Acción</th></tr>";
                foreach ($obj2->notas as $tupla) {
                    echo "<tr>";
                    echo "<td>".$tupla->denominacion."</td>";
                    if ((isset($_POST["btnEditar"]) && $_POST["asignatura"] == $tupla->cod_asig) || (isset($_POST["btnCambiar"]) && $_POST["asignatura"] == $tupla->cod_asig)) { // Cuando se le de al editar cambiamos por un input la nota (del alumno que se ha seleccionado), lo del alumno lo sabemos por el input hidden que hemos pasado. Y si a estas alturas está set el $_POST del btnCambiar es porque ha habido algún error
                        if (isset($_POST["btnEditar"])) { // Para mantener los valores
                            $nota = $tupla->nota;
                        } else {
                            $nota = $_POST["nota"];
                        }

                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='text' name='nota' value='".$nota."' placeholder='Introduzca un número entre 0 y 10'>";
                        if (isset($_POST["btnCambiar"])) { // Si hay error
                            echo "<br><span class='error'>*No has introducido un valor válido de nota*</span>";
                        }
                        echo "</td>";
                        echo "<td>";
                        echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'><input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                        echo "<button type='submit' class='enlace' name='btnCambiar'>Cambiar</button> - <button type='submit' class='enlace' name='btnAtras'>Atras</button></form>";
                        echo "</td>";                        
                    } else {
                        echo "<td>".$tupla->nota."</td>";
                        echo "<td>";
                        echo "<form action='index.php' method='post'>";
                        echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'><input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                        echo "<button type='submit' class='enlace' name='btnEditar'>Editar</button> - <button type='submit' class='enlace' name='btnBorrar'>Borrar</button>";
                        echo "</form>";
                        echo "</td>";                        
                    }                
                    echo "</tr>";    
                }
                
            echo "</table>";            

            if (count($obj3->notas) > 0) { // Si quedan asignaturas por calificar
                ?>
                    <form action="index.php" method="post">
                        <p>
                            <input type="hidden" name="alumno" value="<?php echo $_POST["alumno"]; ?>">
                            <label for="cod_asig">Asignaturas que a <strong><?php echo $nombre_alumno; ?></strong> aún le quedan por calificar</label>
                            <select name="cod_asig" id="cod_asig">
                                <?php 
                                    foreach ($obj3->notas as $tupla) {
                                        echo "<option value='".$tupla->cod_asig."'>".$tupla->denominacion."</option>";
                                    }
                                ?>
                            </select>
                            <button type="submit" name="btnCalificar">Calificar</button>
                        </p>
                    </form>
                <?php
            } else {
                echo "<p>A <strong>".$nombre_alumno."</strong> no lo quedan asignaturas por calificar</p>";
            }

            if (isset($_SESSION["mensaje_accion"])) {
                echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
                unset($_SESSION["mensaje_accion"]);
                unset($_POST["alumno"]);
                if (isset($_SESSION["cod_asig"])) {
                    unset($_SESSION["cod_asig"]);
                }                
            }

        }
    }
    ?>
</body>
</html>