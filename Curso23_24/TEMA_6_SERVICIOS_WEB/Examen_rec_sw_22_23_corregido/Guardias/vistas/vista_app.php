<?php 

    // Cuando se pulsa el botón de equipo, es lo mismo que poner el $_POST["btnGuardia"], porque dia, hora y equipo existen solo cuando se pulsa el botón,
    // miramos si el profesor con el que estamos logueado está de guardia ese día y hora
    if (isset($_POST["equipo"])) {
        $url = DIR_SERV."/deGuardia/".$_POST["dia"]."/".$_POST["hora"]."/".$datos_usuario_log->id_usuario;
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
        }

        if (isset($obj->error)) {
            consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
            session_destroy();
            die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj->error));
        }

        if (isset($obj->no_auth)) {
            session_unset();
            $_SESSION["seguridad"] = "No tienes permiso para acceder a este servicio";
            header("Location:index.php");
            exit;
        }

        // Si el profesor el día y hora seleccionadas está de guardia, mostramos todos los que están de guardia ese día y esa hora
        if ($obj->de_guardia) { // $obj->de_guardia == true
            $url = DIR_SERV."/usuariosGuardia/".$_POST["dia"]."/".$_POST["hora"];
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj2 = json_decode($respuesta);

            if (!$obj2) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj2->error)) {
                consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj2->error));
            }

            if (isset($obj2->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "No tienes permiso para acceder a este servicio";
                header("Location:index.php");
                exit;
            }
        }

        // Si pulsamos el nombre de un profesor mostramos sus detalles
        if (isset($_POST["btnDetalles"])) {
            $url = DIR_SERV."/usuario/".$_POST["btnDetalles"];
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj3 = json_decode($respuesta);

            if (!$obj3) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj3->error)) {
                consumir_servicios_REST(DIR_SERV."/salir", "POST", $datos);
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj3->error));
            }

            if (isset($obj3->no_auth)) {
                session_unset();
                $_SESSION["seguridad"] = "No tienes permiso para acceder a este servicio";
                header("Location:index.php");
                exit;
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de guardias</title>
</head>
<style>

    .enlace{
        background: none;
        border: none;
        color: blue;
        text-decoration: underline;
        cursor: pointer;
    }

    table{
        border-collapse: collapse;
        width: 80%;
        margin: 0 auto;
        text-align: center;
    }

    tr, th, td{
        border: 1px solid black;
    }

    th{
        background-color: #CCC;
    }

</style>
<body>
    
    <h1>Gestión de guardias</h1>

    <form action="index.php" method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button type="submit" class="enlace" name="btnSalir">Salir</button></p>
    </form>

    <h2>Equipo de guardias del ies mar de alborán</h2>

    <?php 

        // Vamos a meter los datos de los días y horas en variables e imprimimos la tabla
        $dias[0] = "";
        $dias[1] = "Lunes";
        $dias[2] = "Martes";
        $dias[3] = "Miércoles";
        $dias[4] = "Jueves";
        $dias[5] = "Viernes";

        $horas[1] = "1º Hora";
        $horas[2] = "2º Hora";
        $horas[3] = "3º Hora";        
        $horas[4] = "4º Hora";
        $horas[5] = "5º Hora";
        $horas[6] = "6º Hora";

        // Creamos la tabla
        echo "<table>";

        // Imprimimos la cabecera
        echo "<tr>";        
        for ($dia=0; $dia <= 5; $dia++) {
            echo "<th>".$dias[$dia]."</th>";
        }
        echo "</tr>";

        // Imprimimos las horas
        $contador = 1;
        for ($hora=1; $hora <= 6; $hora++) {
            // En el recreo
            if ($hora == 4) {
                echo "<tr><td colspan='6'>RECREO</td></tr>";
            }

            echo "<tr>";
            echo "<td>".$horas[$hora]."</td>"; // La primera columna (1º hora, 2ºhora...)
            for ($dia=1; $dia <= 5; $dia++) { // Estamos dentro de cada hora, pues cada día de cada hora ponemos el botón de equipo (cada uno un form)
                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='dia' value='".$dia."'/><input type='hidden' name='hora' value='".$hora."'/><input type='hidden' name='equipo' value='".$contador."'/>"; // Nos pasamos con tres hidden el día, la hora y el número de equipo seleccionado
                echo "<button name='btnGuardia' class='enlace'>Equipo ".$contador."</button>";
                echo "</form>";
                echo "</td>";
                $contador++; // En cada botón vamos sumando al contador
            }
            echo "</tr>";
        }

        echo "</table>";

        if (isset($_POST["equipo"])) { // Cuando se pulsa el botón de equipo, es lo mismo que poner el $_POST["btnGuardia"], porque dia, hora y equipo existen solo cuando se pulsa el botón
                
            echo "<h2>EQUIPO DE GUARDIA ".$_POST["equipo"]."</h2>";

            if ($obj->de_guardia) { // Si el profesor está de guardia (mostramos la tabla)

                echo "<p>".$dias[$_POST["dia"]]." a ".$_POST["hora"]."º hora</p>"; // Mostramos el mensaje

                $n_profesores = count($obj2->usuarios); // Nos da el número de profesores (que van a ser las filas)

                echo "<table>";
                echo "<tr>";
                echo "<th>Profesores de guardia</th>";
                echo "<th>Información del profesor con id_usuario:";
                if (isset($_POST["btnDetalles"])) {
                    echo $_POST["btnDetalles"]; // Si se ha pulsado un profesor, ponemos su id en el th
                }
                echo "</th>";
                echo "</tr>";
                foreach ($obj2->usuarios as $key => $tupla) { // En key estamos guardando el índice (la fila por la que vamos)
                    echo "<tr>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='dia' value='".$_POST["dia"]."'/><input type='hidden' name='hora' value='".$_POST["hora"]."'/><input type='hidden' name='equipo' value='".$_POST["equipo"]."'/>"; // Ahora nos volvemos a pasar todos los hidden para que al pulsar un nombre vayamos por el mismo lado, si no no se guardan (porque tendríamos que volver a pulsar el botón y se perderían)
                    echo "<button name='btnDetalles' value='".$tupla->id_usuario."' class='enlace'>Equipo ".$tupla->nombre."</button>"; // Guardamos la id del usuario seleccionado
                    echo "</form>";                    
                    echo "</td>"; // Ponemos un td por cada nombre

                    if ($key == 0) { // La primera fila es diferente porque en el segundo th le vamos a meter el otro td con rowspan con el valor del nº de profesores que haya
                        echo "<td rowspan='".$n_profesores."'>";
                        if (isset($_POST["btnDetalles"])) {
                            echo "<p><strong>Nombre: </strong>".$obj3->usuario->nombre."</p>";
                        }
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                

            } else {
                echo "<p>¡¡ Atención, usted no se encuentra de guardia el ".$dias[$_POST["dia"]]." a ".$_POST["hora"]."º hora !!</p>"; // Mostramos el mensaje
            }            

        }

    ?>

</body>
</html>