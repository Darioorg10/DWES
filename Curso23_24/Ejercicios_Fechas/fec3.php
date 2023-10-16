<?php // Controlamos los errores

if (isset($_POST["btnEnviar"])) {

    $error_fecha1 = $_POST["fecha1"] == "";
    $error_fecha2 = $_POST["fecha2"] == "";

    $error_form = $error_fecha1 || $error_fecha2;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha 3 completo</title>
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
            margin-top: 2em;
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
        <form action="fec3.php" method="post">
            <p>
                <label for="fecha1">Introduzca una fecha:</label>
                <input type="date" id="fecha1" name="fecha1" value="<?php if (isset($_POST["fecha1"])) echo $_POST["fecha1"]; ?>">
                <?php
                if (isset($_POST["btnEnviar"]) && $error_fecha1) {
                    echo "<span class='error'>No has seleccionado una fecha</span>";
                }
                ?>
            </p>
            <p>
                <label for="fecha2">Introduzca una fecha:</label>
                <input type="date" id="fecha2" name="fecha2" value="<?php if (isset($_POST["fecha2"])) echo $_POST["fecha2"]; ?>">
                <?php
                if (isset($_POST["btnEnviar"]) && $error_fecha2) {
                    echo "<span class='error'>No has seleccionado una fecha</span>";
                }
                ?>
            </p>
            <p>
                <input type="submit" name="btnEnviar" value="Restar">
            </p>
        </form>
    </div>

    <?php // Si no da problemas
    if (isset($_POST["btnEnviar"]) && !$error_form) {

        // Resuelvo el problema

        $tiempo1 = strtotime($_POST["fecha1"]);
        $tiempo2 = strtotime($_POST["fecha2"]);

        $dif_segundos = abs($tiempo1 - $tiempo2);
        $dias_pasados = floor($dif_segundos / (60 * 60 * 24)); // Por si salen decimales que nos aproxime a lo bajo y dividimos los segundos en días

        echo "<div class='cuadro fondo_verdoso'>";
        echo "<h1 class='centro'>Fechas - resultado</h1>";
        echo "<p> La diferencia en días entre las fechas es de: $dias_pasados días</p>";
        echo "</div>";
    }

    ?>
</body>

</html>