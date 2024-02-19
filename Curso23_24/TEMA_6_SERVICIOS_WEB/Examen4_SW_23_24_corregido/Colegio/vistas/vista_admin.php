<?php     

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

    if (isset($_POST["alumno"])) { // Si existe alumno ("se ha pulsado el botón de ver notas)
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
                    echo "<td>".$tupla->nota."</td>";
                    echo "<td>";
                    echo "<form action='index.php' method='post'>";
                    echo "<input type='hidden' name='alumno' value='".$_POST["alumno"]."'><input type='hidden' name='asignatura' value='".$tupla->cod_asig."'>";
                    echo "<button type='submit' class='enlace' name='btnEditar'>Editar</button> - <button type='submit' class='enlace' name='btnBorrar'>Borrar</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                    }
                
            echo "</table>";

        }
    }
    ?>
</body>
</html>