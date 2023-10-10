<?php // Controlamos los errores

if (isset($_POST["btnEnviar"])) {    

    $buenos_separadores1 = substr($_POST["texto1"], 2, 1) == "/" && substr($_POST["texto1"], 5, 1) == "/"; // Empezamos en 2 o 5 y cogemos el siguiente
    $array_numeros1 = explode("/", $_POST["texto1"]);
    $numeros_buenos1 = is_numeric($array_numeros1[0]) && is_numeric($array_numeros1[1]) && is_numeric($array_numeros1[2]);
    $fecha_valida1 = checkdate($array_numeros1[1], $array_numeros1[0], $array_numeros1[2]); // El checkdate mira primero el mes, luego el día y luego el año
    $error_fecha1 = $_POST["texto1"]=="" || strlen($_POST["texto1"])!=10 || !$buenos_separadores1 || !$numeros_buenos1 || !$fecha_valida1;

    $buenos_separadores2 = substr($_POST["texto2"], 2, 1) == "/" && substr($_POST["texto2"], 5, 1) == "/"; // Empezamos en 2 o 5 y cogemos el siguiente
    $array_numeros2 = explode("/", $_POST["texto2"]);
    $numeros_buenos2 = is_numeric($array_numeros2[0]) && is_numeric($array_numeros2[1]) && is_numeric($array_numeros2[2]);
    $fecha_valida2 = checkdate($array_numeros2[1], $array_numeros2[0], $array_numeros2[2]); // El checkdate mira primero el mes, luego el día y luego el año
    $error_fecha2 = $_POST["texto1"]=="" || strlen($_POST["texto1"])!=10 || !$buenos_separadores2 || !$numeros_buenos2 || !$fecha_valida2;

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fecha 1 completo</title>
    <style>
        .cuadro{border: solid; padding: 5px;}
        .fondo_celeste{background-color: lightblue;}
        .centro{text-align: center;}
    </style>
</head>
<body>
    <div class="cuadro fondo_celeste">
        <h1 class="centro">Fechas - formulario</h1>
        <form action="fecha1.php" method="post">
            <p>
                <label for="texto1">Introduzca una fecha (DD/MM/AAAA)</label>
                <input type="text" id="texto1" name="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>">
            </p>    
            <p>
                <label for="texto2">Introduzca una fecha (DD/MM/AAAA)</label>
                <input type="text" id="texto2" name="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"];?>">
            </p>
            <p>
                <input type="submit" name="btnEnviar" value="Restar">
            </p>                        
        </form>
    </div>

    <?php // Si no da problemas
    if (isset($_POST["btnEnviar"]) && !$error_form ) {
        
    }
    
    ?>
</body>
</html>