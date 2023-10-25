<?php // Control de errores y mis funciones
if (isset($_POST["btnEnviar"])) {
    $error_vacio = $_FILES["fichero"]["name"] == "";
    $error_subida = $_FILES["fichero"]["error"];
    $error_tipo = $_FILES["fichero"]["type"] != "text/plain";
    $error_tamanio = $_FILES["fichero"]["size"] > 1000 * 1024;

    $error_form = $error_vacio || $error_subida || $error_tipo || $error_tamanio;
}

function mi_strlen($texto){
    $contador = 0;
    while (isset($texto[$contador])) {
        $contador++;
    }
    return $contador;
}

function mi_explode($separador, $texto){
    // $aux = array(); Esto es lo mismo que $aux = [];
    $aux = [];        
    $longitud_texto = mi_strlen($texto);
    $i = 0;
    while ($i < $longitud_texto && $texto[$i] == $separador) { // Esto sirve para quitar los separadores si hay en el principio
        $i++;
    }

    if ($i < $longitud_texto) { // Si ya viendo los separadores del principio no hemos terminado todavía
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($i=$i+1; $i < $longitud_texto; $i++) {
            if ($texto[$i] != $separador) { // Si no es un separador le concatenamos la siguiente letra/carácter
                $aux[$j].=$texto[$i];
            } else {
                while ($i < $longitud_texto && $texto[$i] == $separador) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                    $i++;                        
                }

                if ($i < $longitud_texto) {
                    $j++;    
                    $aux[$j] = $texto[$i];
                }
                
            }
        }
    }

    return $aux;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <style>
        .error {
            color: red
        }
        
        .text_centrado{
            text-align: center;
        }

        table, th, td{
            border: 1px solid black;
        }

        table{
            border-collapse: collapse;
            width: 90%;
            margin: 0 auto;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

    </style>
</head>

<body>
    <h1>Ejercicio 4</h1>
    <?php
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        @$var = move_uploaded_file($_FILES["fichero"]["tmp_name"], "horario/horarios.txt"); // Movemos el fichero que nos suban a horario y le llamamos horarios.txt
        if (!$var) {
            echo "<h3>El fichero seleccionado no ha podido moverse a la carpeta destino</h3>";
        }
    }

    if (!file_exists("horario/horarios.txt")) { // Si el archivo no existe
        echo "<h2>No se encuentra el archivo <em>horario/horarios.txt</em></h2>";
    ?>
        <form action="ej4.php" method="post" enctype="multipart/form-data">
            <label for="fichero">Selecciona un fichero .txt de menos de 1MB</label>
            <input type="file" name="fichero" id="fichero" accept=".txt">
            <?php
            if (isset($_POST["btnEnviar"]) && $error_form) {
                if ($error_vacio) {
                    echo "<span class='error'>*</span>";
                } else if ($error_subida) {
                    echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                } else if ($error_tipo) {
                    echo "<span class='error'>El archivo no es .txt</span>";
                } else if ($error_tamanio) {
                    echo "<span class='error'>El archivo pesa más de 1MB</span>";
                }
            }
            ?>
            <br>
            <button type="submit" name="btnEnviar">Enviar</button>
        </form>
        <?php
    } else {
        @$fd = fopen("horario/horarios.txt", "r");
        if ($fd){
            $options = "";
            while($linea = fgets($fd)){
                $datos_linea = mi_explode("\t", $linea);
                if (isset($_POST["btnVerHorario"]) && $_POST["profesor"] == $datos_linea[0]) {
                    $options .= "<option selected value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
                    $nombre_prof =  $datos_linea[0]; // Ya tenemos directamente los datos del profesor
                    for ($i=1; $i < count($datos_linea); $i+=3) {
                        if (isset($horario_profe[$datos_linea[$i]][$datos_linea[$i+1]])) {
                            $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]].="/".$datos_linea[$i+2]; // Esto es solo para concatenar si hay más de una clase en la misma hora                            
                        } else {
                            $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]]= $datos_linea[$i+2];
                        }
                    }
                } else {
                    $options .= "<option value='".$datos_linea[0]."'>".$datos_linea[0]."</option>";
                }
                                
            }
        }
        ?>

            <h2>Horario de los profesores</h2>
            <form action="ej4.php" method="post">
                <label for="profesor">Horario del profesor:</label>
                <select name="profesor" id="profesor">
                <?php
                    echo $options;        
                ?>
                </select>                
                <button type="submit" name="btnVerHorario">Ver horario</button>
            </form>

        <?php
        if (isset($_POST["btnVerHorario"])) {
            echo "<h3 class='text_centrado'>Horario del profesor: ".$nombre_prof."</h3>";

            $horas[1]="8:15-9:15";
            $horas[]="9:15-10:15";
            $horas[]="10:15-11:15";
            $horas[]="11:15-11:45";
            $horas[]="11:45-12:45";
            $horas[]="12:45-13:45";
            $horas[]="13:45-14:45";

            echo "<table>";
            echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>"; // Ponemos la primera fila con los días
            for ($hora=1; $hora <= 7; $hora++) {
                echo "<tr>";
                echo "<th>".$horas[$hora]."</th>";
                if ($hora == 4) { // En el recreo
                    echo "<td colspan='5'>RECREO</td>";
                } else {
                    for ($dia=1; $dia <= 5; $dia++) {
                        if (isset($horario_profe[$dia][$hora])) {
                            echo "<td>".$horario_profe[$dia][$hora]."</td>";
                        } else {
                            echo "<td></td>";
                        }
                        
                    }
                }                
                echo "</tr>";
            }
            echo "</table>";

        }
            fclose($fd);
        }    
        ?>    
</body>

</html>