<?php

    if (isset($_POST["btnInsertar"])) {
        $url = DIR_SERV . "/insertarGrupo";
        // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
        $datos["usuario"] = $_POST["profesor"];
        $datos["dia"] = $_POST["dia"];
        $datos["hora"] = $_POST["hora"];
        $datos["grupo"] = $_POST["grupo"];
        $respuesta = consumir_servicios_REST($url, "POST", $datos);
        $obj = json_decode($respuesta); // Aquí no tenemos que cambiar el $obj porque vamos a saltar
        if (!$obj) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No estás autorizado";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = "Grupo insertado correctamente";
        $_SESSION["profesor"] = $_POST["profesor"];
        $_SESSION["dia"] = $_POST["dia"];
        $_SESSION["hora"] = $_POST["hora"];
        header("Location:index.php");
        exit;

    }

    if (isset($_POST["btnQuitar"])) {
        $url = DIR_SERV . "/borrarGrupo/".$_POST["btnQuitar"];
        // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad        
        $respuesta = consumir_servicios_REST($url, "DELETE", $datos);
        $obj = json_decode($respuesta); // Aquí no tenemos que cambiar el $obj porque vamos a saltar
        if (!$obj) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No estás autorizado";
            header("Location:index.php");
            exit;
        }

        $_SESSION["mensaje_accion"] = "Grupo borrado correctamente";
        $_SESSION["profesor"] = $_POST["profesor"];
        $_SESSION["dia"] = $_POST["dia"];
        $_SESSION["hora"] = $_POST["hora"];
        header("Location:index.php");
        exit;

    }

    // Vamos a obtener los profesores
    $url = DIR_SERV . "/obtenerUsuarios";
    // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
    $respuesta = consumir_servicios_REST($url, "GET", $datos);
    $obj = json_decode($respuesta);
    if (!$obj) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj->error)) {
        session_destroy();
        die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
    }

    if (isset($obj->no_auth)) {
        session_unset();
        $_SESSION["seguridad"] = "No estás autorizado";
        header("Location:index.php");
        exit;
    }

    if (isset($_SESSION["profesor"])) {
        $_POST["profesor"] = $_SESSION["profesor"];
        $_POST["dia"] = $_SESSION["dia"];
        $_POST["hora"] = $_SESSION["hora"];
    }

    // Si le damos al botón de horario (está explicado abajo por qué lo he cambiado a profesor)
    if (isset($_POST["profesor"])) {

        // Vamos a obtener los horarios del profesor
        $url = DIR_SERV . "/obtenerHorario/".$_POST["profesor"];
        // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj2 = json_decode($respuesta); // COMO ARRIBA TENEMOS YA $obj, 
        if (!$obj2) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj2->error)) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj2->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No estás autorizado";
            header("Location:index.php");
            exit;
        }
    }

    if (isset($_POST["dia"])) {        

        // Vamos a obtener los horarios del profesor
        $url = DIR_SERV . "/obtenerHorarioDiaHora/".$_POST["profesor"];
        // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
        $datos["dia"] = $_POST["dia"];
        $datos["hora"] = $_POST["hora"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj3 = json_decode($respuesta); // COMO ARRIBA TENEMOS YA $obj, 
        if (!$obj3) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj3->error)) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj3->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No estás autorizado";
            header("Location:index.php");
            exit;
        }

        $url = DIR_SERV . "/obtenerHorarioNoDiaHora/".$_POST["profesor"];
        // $datos["api_session"] = $_SESSION["api_session"]; Esto lo tenemos ya de seguridad
        $datos["dia"] = $_POST["dia"];
        $datos["hora"] = $_POST["hora"];
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj4 = json_decode($respuesta); // COMO ARRIBA TENEMOS YA $obj, 
        if (!$obj4) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj4->error)) {
            session_destroy();
            die(error_page("Examen SW 22_23", "<h1>Horario</h1><p>Error consumiendo el servicio : $url</p>"));
        }

        if (isset($obj4->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No estás autorizado";
            header("Location:index.php");
            exit;
        }

    }


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen 2 23_24 SW</title>
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

        .centrado{
            text-align: center;
        }

        table{
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            text-align: center;
        }

        td, tr, th{
            border: 1px solid black;
            padding: 0.5rem;
        }

        th{
            background-color: #CCC;
        }

        .tab-grupos{
            width: 20%;
            margin: 0 0;
        }

        .mensaje{
            font-size: 1.25em;
            color: blue;
        }

    </style>
</head>

<body>
    <h1>Horarios</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
        <h1>Horario de los profesores</h1>
        <form action="index.php" method='post'>
            <p>
                <label for="profesor">Horario del profesor:</label>
                <select name="profesor" id="profesor">
                    <?php

                        foreach ($obj->usuarios as $tupla) {
                            if ($tupla->tipo === "normal") { // Solo traemos a los normales
                                if (isset($_POST["profesor"]) && $_POST["profesor"] == $tupla->id_usuario) {
                                    $nombre_profesor = $tupla->nombre;
                                    echo "<option value='".$tupla->id_usuario."' selected>".$tupla->nombre."</option>"; // Le pasamos como value la id
                                } else {
                                    echo "<option value='".$tupla->id_usuario."'>".$tupla->nombre."</option>";
                                }
                            }                            
                        }
                                    
                    ?>
                </select>
                <button type="submit" name="btnVerHorario">Ver horario</button>
            </p>

            <?php 
                if (isset($_POST["profesor"])) { // Antes teníamos isset($_POST["btnVerHorario"]), ahora como añadimos lo de editar, el $_POST["profesor"] existe al darle click al botón de ver horario y al de editar
                    echo "<h3 class='centrado'>Horario del profesor: <i>".$nombre_profesor."</i></h3>";

                    // Vamos a guardar en cada día y hora el grupo
                    foreach ($obj2->horario as $tupla) {
                        if (isset($horario[$tupla->dia][$tupla->hora])) { // Si ya hay un grupo ahí, los concatenamos
                            $horario[$tupla->dia][$tupla->hora] .= "/".$tupla->nombre; // Guardamos el nombre del grupo en el día y hora
                        } else {
                            $horario[$tupla->dia][$tupla->hora] = $tupla->nombre;
                        }
                    }

                    $dias[] = ""; // Esto sería el [0]
                    $dias[] = "Lunes";
                    $dias[] = "Martes";
                    $dias[] = "Miércoles";
                    $dias[] = "Jueves";
                    $dias[] = "Viernes";

                    $horas[1] = "8:15-9:15";
                    $horas[] = "9:15-10:15";
                    $horas[] = "10:15-11:15";
                    $horas[] = "11:15-11:45";
                    $horas[] = "11:45-12:45";
                    $horas[] = "12:45-13:45";
                    $horas[] = "13:45-14:45";                    

                    echo "<table>";
                    echo "<tr>";
                    // Mostramos los días arriba
                    for ($i=0; $i <= 5; $i++) {
                        echo "<th>".$dias[$i]."</th>";
                    }
                    echo "</tr>";

                    for ($hora=1; $hora <= 7; $hora++) {
                        echo "<tr>";
                        echo "<th>".$horas[$hora]."</th>"; // Mostramos las horas en la primera columna
                        // Si estamos en el recreo
                        if ($hora == 4) {
                            echo "<td colspan='5'>RECREO</td>";
                        } else {
                            for ($dia=1; $dia <= 5; $dia++) { // En cada hora de cada día
                                if (isset($horario[$dia][$hora])) { // Si existe horario en el día y hora por el que voy
                                    echo "<td>".$horario[$dia][$hora];
                                    echo "<form action='index.php' method='post'>"; // Ponemos el botón editar, y le pasamos el id del profesor, el día y la hora
                                    echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>";
                                    echo "<input type='hidden' name='dia' value='".$dia."'>";
                                    echo "<input type='hidden' name='hora' value='".$hora."'>";
                                    echo "<button class='enlace' name='btnEditar'>Editar</button>";
                                    echo "</form></td>";
                                } else {
                                    echo "<td><form action='index.php' method='post'>";
                                    echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>";
                                    echo "<input type='hidden' name='dia' value='".$dia."'>";
                                    echo "<input type='hidden' name='hora' value='".$hora."'>";
                                    echo "<button class='enlace' name='btnEditar'>Editar</button>";
                                    echo "</form></td>";
                                }
                            }
                        }                        
                        echo "</tr>";
                    }

                    echo "</table>";

                    // Si se le da al botón editar
                    if (isset($_POST["dia"])) {
                        echo "<h2>Editando la ".$_POST["hora"]."º hora (".$horas[$_POST["hora"]].") del ".$dias[$_POST["dia"]]."</h2>";

                        if (isset($_SESSION["mensaje_accion"])) {
                            echo "<p class='mensaje'>".$_SESSION["mensaje_accion"]."</p>";
                            unset($_SESSION["mensaje_accion"]);
                            unset($_SESSION["dia"]);
                            unset($_SESSION["hora"]);
                            unset($_SESSION["profesor"]);
                        }

                        // Vamos a hacer la tabla que muestra los grupos y nos deja borrarlos
                        echo "<table class='tab-grupos'>";
                        echo "<tr><th>Grupo</th><th>Acción</th></tr>";
                        foreach($obj3->horario as $tupla) {
                            echo "<tr>";
                            echo "<td>".$tupla->nombre."</td>";
                            echo "<td>";
                            echo "<form action='index.php' method='post'>"; // Ponemos el botón de quitar, y le pasamos el id del profesor, el día y la hora
                            echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>";
                            echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'>";
                            echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                            echo "<button class='enlace' name='btnQuitar' value='".$tupla->id_horario."'>Quitar</button>";
                            echo "</form></td>";
                            echo "<tr>";
                        }
                        echo "</table>";

                        ?>
                            <form action="index.php" method="post">
                                <p>
                                    <?php 
                                        echo "<input type='hidden' name='profesor' value='".$_POST["profesor"]."'>";
                                        echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'>";
                                        echo "<input type='hidden' name='hora' value='".$_POST["hora"]."'>";
                                        echo "<select name='grupo'>";
                                        foreach ($obj4->horario as $tupla) {
                                            echo "<option value='".$tupla->id_grupo."'>".$tupla->nombre."</option>";
                                        }
                                    ?>
                                    </select>
                                    <button type="submit" name="btnInsertar">Añadir</button>
                                </p>
                            </form>
                        <?php

                    }
                }
            ?>            
        </form>        
    </div>
</body>

</html>