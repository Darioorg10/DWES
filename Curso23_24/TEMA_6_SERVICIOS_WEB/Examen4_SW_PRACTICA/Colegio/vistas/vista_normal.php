<?php 

    $url = DIR_SERV."/notasAlumno/".$datos_usuario_log->cod_usu;

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
    <h1>Vista normal</h1>

    <form action='index.php' method="post">
        <p>Bienvenido <strong><?php echo $datos_usuario_log->usuario; ?></strong> - <button type="submit" name="btnSalir" class="enlace">Salir</button></p>
    </form>

    <?php 
    
        echo "<h2>Notas del alumno ".$datos_usuario_log->nombre." </h2>";
        echo "<table>";
        echo "<tr><th>Asignatura</th><th>Nota</th></tr>";
        foreach ($obj->notas as $tupla) {
            echo "<tr>";
            echo "<td>".$tupla->denominacion."</td>";
            echo "<td>".$tupla->nota."</td>";
            echo "</tr>";
        }
        echo "</table>";
    
    ?>

</body>
</html>