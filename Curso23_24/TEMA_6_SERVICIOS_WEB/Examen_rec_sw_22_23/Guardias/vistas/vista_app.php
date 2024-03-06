<?php 

    // Si se le da al botón de equipo (vemos si el profesor está en guardia esa hora)
    if (isset($_POST["btnEquipo"])) {
        
        $url = DIR_SERV."/deGuardia/".$_POST["diaEquipo"]."/".$_POST["horaEquipo"]."/".$datos_usuario_log->id_usuario;
        $respuesta = consumir_servicios_REST($url, "GET", $datos);
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj->error));
        }

        if (isset($obj->mensaje)) {
            session_unset();
            $_SESSION["seguridad"] = $obj->mensaje;
            header("Location:index.php");
            exit;
        }

        // Si el profesor tiene guardia, obtenemos todos los profesores que también tienen guardia ese día y hora
        if ($obj->de_guardia == true) { // cambiado $obj->de_guardia == true
            
            $url = DIR_SERV."/usuariosGuardia/".$_POST["diaEquipo"]."/".$_POST["horaEquipo"]; // cambiado /usuariosGuardia/1/1
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj2 = json_decode($respuesta);            

            if (!$obj2) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj2->error)) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj2->error));
            }

            if (isset($obj2->mensaje)) {
                session_unset();
                $_SESSION["seguridad"] = $obj2->mensaje;
                header("Location:index.php");
                exit;
            }            

        }

        // Si se pulsa algún nombre de un profesor mostramos los detalles
        if (isset($_POST["btnDetalle"])) {
                
            $url = DIR_SERV."/usuario/".$_POST["btnDetalle"];
            $respuesta = consumir_servicios_REST($url, "GET", $datos);
            $obj3 = json_decode($respuesta);

            if (!$obj3) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: $url"));
            }

            if (isset($obj3->error)) {
                session_destroy();
                die(error_page("Gestión de guardias", "Ha habido un error al consumir el servicio: ".$obj3->error));
            }

            if (isset($obj3->mensaje)) {
                session_unset();
                $_SESSION["seguridad"] = $obj3->mensaje;
                header("Location:index.php");
                exit;
            }

            $profeDetalles = $obj3->usuario;

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

    form#profes{
        display: flex;
    }

    .profesoresGuardia, .infoProfesor{
        margin: 0;
        flex: 40%;        
    }

    .profesoresGuardia{
        margin-left: 1rem;
    }

    .infoProfesor{
        margin-right: 1rem;
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

        // Guardamos los equipos en un array
        for ($i=1; $i <= 30; $i++) {
            $equipos[$i] = "Equipo ".$i;
        }        

        // Imprimimos la tabla
        echo "<form action='index.php' method='post'>";
        echo "<table>";

        // Imprimimos la cabecera
        echo "<tr>";
        for ($dia=0; $dia <= 5; $dia++) {
            echo "<th>".$dias[$dia]."</th>";
        }
        echo "</tr>";

        // Por cada hora queremos una nueva fila
        for ($hora=1; $hora <= count($horas); $hora++) {
            if ($hora == 4) {
                echo "<tr><td colspan='6'>RECREO</td></tr>";
                echo "<tr><td>".$horas[$hora]."</td>";
                for ($i=16; $i <= 20; $i++) { 
                    echo "<form action='index.php' method='post'>"; // Ponemos un formulario por botón
                    echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>";
                    echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>"; // CAMBIAR (poner el día bien)
                    echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>";
                    echo "</form>";
                }
                echo "</tr>";
            } else {
                echo "<tr><td>".$horas[$hora]."</td>";

                switch ($hora) {
                    case 1:
                        for ($i=1; $i <= 5; $i++) {
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>"; // Guardamos en un hidden la hora
                            echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>"; // Guardamos en un hidden el día
                            echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>"; // Guardamos en el btnEquipo el número del equipo
                            echo "</form>";
                        }   
                        break;

                    case 2:
                        for ($i=6; $i <= 10; $i++) { 
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>";
                            echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>";
                            echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>";
                            echo "</form>";
                        }   
                        break;

                    case 3:
                        for ($i=11; $i <= 15; $i++) {
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>";
                            echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>";
                            echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>";
                            echo "</form>";
                        }   
                        break;

                    case 5:
                        for ($i=21; $i <= 25; $i++) {
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>";
                            echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>";
                            echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>";
                            echo "</form>";
                        }   
                        break;

                    case 6:
                        for ($i=26; $i <= 30; $i++) {
                            echo "<form action='index.php' method='post'>";
                            echo "<input type='hidden' name='horaEquipo' value='".$hora."'/>";
                            echo "<input type='hidden' name='diaEquipo' value='".$dia."'/>";
                            echo "<td><button class='enlace' name='btnEquipo' value='".$i."'>".$equipos[$i]."</button></td>";
                            echo "</form>";
                        }   
                        break;
                    
                    
                }

                echo "</tr>";
                
            }
        }

        echo "</table>";
        echo "</form>";

        // Si se le da a un equipo
        if (isset($_POST["btnEquipo"])) {

            echo "<h2>Equipo de guardia ".$_POST["btnEquipo"]."</h2>";

            // Si el profesor elegido no está de guardia ese día
            if ($obj->de_guardia == false) { // cambiado $obj->de_guardia !== false
                echo "<p>¡¡ Atención, usted no se encuentra de guardia el ".$dias[$_POST["diaEquipo"]]." a ".$_POST["horaEquipo"]."º hora !!</p>";
            } else {

                // Si está de guardia, mostramos todos los que están de guardia
                echo "<p>".$dias[$_POST["diaEquipo"]]." a ".$_POST["horaEquipo"]."º hora</p>";

                echo "<form action='index.php' method='post' id='profes'>";
                echo "<table class='profesoresGuardia'>";
                echo "<tr><th>Profesores de guardia</th></tr>";
                foreach ($obj2->usuarios as $tupla) {
                    echo "<tr><td><button type='submit' class='enlace' name='btnDetalle' value='".$tupla->id_usuario."'>".$tupla->nombre."</button></td></tr>";
                }
                echo "</table>";                

                echo "<table class='infoProfesor'>";
                echo "<tr><th>Información del profesor con id_usuario:";
                
                if (isset($_POST["btnDetalle"])) {
                    echo $_POST["btnDetalle"];
                    echo "<td rowspan='7'>"; // CAMBIAR (tendremos que poner de rowspan las tuplas que haya en profesores de guardia)
                    
                    echo "<p><strong>Nombre: </strong>".$profeDetalles->nombre."</p>";
                    echo "<p><strong>Usuario: </strong>".$profeDetalles->usuario."</p>";
                    echo "<p><strong>Contraseña: </strong><input type='hidden'>".$profeDetalles->clave."</input></p>"; // La contraseña no la mostramos pero la metemos en un hidden

                    if (isset($profeDetalles->email)) {
                        echo "<p><strong>Email: </strong>".$profeDetalles->email."</p>";
                    } else {
                        echo "<p><strong>Email: </strong> Email no disponible</p>";
                    }

                    echo "</td>";
                }
                echo "</th></tr>";
                echo "</table>";
                echo "</form>";

            }
        }

    ?>

</body>
</html>