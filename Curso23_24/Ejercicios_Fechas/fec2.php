<?php 
    
    function comprobarFecha($mes, $dia, $anyo){
        return checkdate($mes, $dia, $anyo);
    }


    if (isset($_POST["btnEnviar"])) {

        $error_fecha1 = !comprobarFecha($_POST["mes1"], $_POST["dia1"], $_POST["anyo1"]);
        $error_fecha2 = !comprobarFecha($_POST["mes2"], $_POST["dia2"], $_POST["anyo2"]);

        $error_form = $error_fecha1 || $error_fecha2;
    }
    

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha 2</title>
    <style>
        .cuadro {
            border: solid;
            padding: 5px;
        }

        .fondo_celeste {
            background-color: lightblue;
        }

        .fondo_verdoso {
            background-color: lightgreen;
        }

        .centro {
            text-align: center;
        }

        .error {
            color: red
        }
    </style>
</head>

<body>
    <div class="cuadro fondo_celeste">
        <h1 class="centro">Fechas - formulario</h1>
        <form action="fec2.php" method="post">
            <p>
                <label for="texto1">Introduzca una fecha:</label>
            <p>
                <label for="dia1">Día:</label>
                <select name="dia1" id="dia1">
                    <?php
                    for ($i = 1; $i < 32; $i++) {
                        if (isset($_POST["btnEnviar"]) && $_POST["dia1"] == $i) {
                            printf("<option selected value='%02d'>%02d</option>", $i, $i);
                        } else {
                            printf("<option value='%02d'>%02d</option>", $i, $i);
                        }
                    }
                    ?>
                </select>
                <label for="mes1">Mes:</label>
                <select name="mes1" id="mes1">
                    <?php
                    $meses = array(
                        "Enero" => 1, "Febrero" => 2, "Marzo" => 3, "Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7,
                        "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10, "Noviembre" => 11, "Diciembre" => 12
                    );

                    foreach ($meses as $n => $v) {
                        if (isset($_POST["btnEnviar"]) && $_POST["mes1"] == $v) {
                            echo "<option selected value='$v'>$n</option>";
                        } else {
                            echo "<option value='$v'>$n</option>";
                        }
                    }

                    ?>
                </select>
                <label for="anyo1">Año:</label>
                <select name="anyo1" id="anyo1">
                    <?php
                    for ($i = 1973; $i <= 2023; $i++) {
                        if (isset($_POST["btnEnviar"]) && $_POST["anyo1"] == $i) {
                            echo "<option selected value='$i'>$i</option>";
                        } else {
                            echo "<option value='$i'>$i</option>";
                        }
                    }
                    ?>
                </select>
                <?php 
                    if (isset($_POST["btnEnviar"]) && $error_fecha1) {
                        echo "<span class='error'>Esta fecha no existe</span>";
                    }
                ?>
            </p>
            </p>
            <p>
                <label for="texto2">Introduzca una fecha:</label>
            <p>
                <label for="dia2">Día:</label>
                <select name="dia2" id="dia2">
                    <?php
                    for ($i = 1; $i < 32; $i++) {
                        if (isset($_POST["btnEnviar"]) && $_POST["dia2"] == $i) {
                            printf("<option selected value='%02d'>%02d</option>", $i, $i);
                        } else {
                            printf("<option value='%02d'>%02d</option>", $i, $i);
                        }
                    }
                    ?>
                </select>
                <label for="mes2">Mes:</label>
                <select name="mes2" id="mes2">
                    <?php
                    $meses = array(
                        "Enero" => 1, "Febrero" => 2, "Marzo" => 3, "Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7,
                        "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10, "Noviembre" => 11, "Diciembre" => 12
                    );

                    foreach ($meses as $n => $v) {
                        if (isset($_POST["btnEnviar"]) && $_POST["mes2"] == $v) {
                            echo "<option selected value='$v'>$n</option>";
                        } else {
                            echo "<option value='$v'>$n</option>";
                        }
                    }

                    ?>
                </select>
                <label for="anyo2">Año:</label>
                <select name="anyo2" id="anyo2">
                    <?php
                    for ($i = 1973; $i <= 2023; $i++) {
                        if (isset($_POST["btnEnviar"]) && $_POST["anyo2"] == $i) {
                            echo "<option selected value='$i'>$i</option>";
                        } else {
                            echo "<option value='$i'>$i</option>";
                        }
                    }
                    ?>
                </select>
                <?php 
                    if (isset($_POST["btnEnviar"]) && $error_fecha2) {
                        echo "<span class='error'>Esta fecha no existe</span>";
                    }                
                ?>
            </p>
            </p>
            <p>
                <input type="submit" name="btnEnviar" value="Calcular">
            </p>
        </form>
    </div>

    <?php // Si no da problemas
    if (isset($_POST["btnEnviar"]) && !$error_form) {

        $tiempo1 = mktime(0, 0, 0, $_POST["mes1"], $_POST["dia1"], $_POST["anyo1"]);
        $tiempo2 = mktime(0, 0, 0, $_POST["mes2"], $_POST["dia2"], $_POST["anyo2"]);

        $dif_segundos = abs($tiempo2 - $tiempo1);
        $dif_pasado = floor($dif_segundos/(60*60*24));        

        echo "<div class='cuadro fondo_verdoso'>";
        echo "<h1 class='centro'>Fechas - respuesta</h1>";
        echo "<p>La diferencia de días es de $dif_pasado días</p>";                 
        echo "</div>";

    }

    ?>
</body>

</html>