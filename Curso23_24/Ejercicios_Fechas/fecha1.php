<?php // Controlamos los errores

function buenos_separadores($texto){
    return substr($texto, 2, 1) == "/" && substr($texto, 5, 1) == "/"; // Empezamos en 2 o 5 y cogemos el siguiente
}

function numeros_buenos($texto){
    return is_numeric(substr($texto, 0, 2)) && is_numeric(substr($texto, 3, 2)) && is_numeric(substr($texto, 6, 4));
}

function fecha_valida($texto){
    return checkdate(substr($texto, 3, 2), substr($texto, 0, 2), substr($texto, 6, 4)); // El checkdate mira primero el mes, luego el día y luego el año
}

if (isset($_POST["btnEnviar"])) {    
            
    $error_fecha1 = $_POST["texto1"]=="" || strlen($_POST["texto1"])!=10 || !buenos_separadores($_POST["texto1"]) || !numeros_buenos($_POST["texto1"]) || !fecha_valida($_POST["texto1"]);        
    $error_fecha2 = $_POST["texto1"]=="" || strlen($_POST["texto1"])!=10 || !buenos_separadores($_POST["texto2"]) || !numeros_buenos($_POST["texto2"]) || !fecha_valida($_POST["texto2"]);

    $error_form = $error_fecha1 || $error_fecha2;

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
        .fondo_verdoso{background-color: lightgreen;}
        .centro{text-align: center;}
        .error{color:red}
    </style>
</head>
<body>
    <div class="cuadro fondo_celeste">
        <h1 class="centro">Fechas - formulario</h1>
        <form action="fecha1.php" method="post">
            <p>
                <label for="texto1">Introduzca una fecha (DD/MM/AAAA)</label>
                <input type="text" id="texto1" name="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"]) && $error_fecha1) {
                        if ($_POST["texto1"] == "") {
                            echo "<span class='error'> Campo vacío </span>";                        
                        } else {
                            echo "<span class='error'> Fecha no válida </span>";
                        }
                    }
                ?>
            </p>    
            <p>
                <label for="texto2">Introduzca una fecha (DD/MM/AAAA)</label>
                <input type="text" id="texto2" name="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"]) && $error_fecha2) {
                        if ($_POST["texto2"] == "") {
                            echo "<span class='error'> Campo vacío </span>";                        
                        } else {
                            echo "<span class='error'> Fecha no válida </span>";
                        }
                    }
                ?>
            </p>
            <p>
                <input type="submit" name="btnEnviar" value="Restar">
            </p>                        
        </form>
    </div>

    <?php // Si no da problemas
    if (isset($_POST["btnEnviar"]) && !$error_form ) {
        
        // Resuelvo el problema

        $fecha1 = explode("/", $_POST["texto1"]);
        $fecha2 = explode("/", $_POST["texto2"]);

        $tiempo1 = mktime(0,0,0,$fecha1[1],$fecha1[0],$fecha1[2]); // Los segundos que han pasado desde 1970 hasta esta fecha
        $tiempo2 = mktime(0,0,0,$fecha2[1],$fecha2[0],$fecha2[2]);

        $dif_segundos = abs($tiempo1-$tiempo2);
        $dias_pasados = floor($dif_segundos/(60*60*24)); // Por si salen decimales que nos aproxime a lo bajo y dividimos los segundos en días

        echo "<div class='cuadro fondo_verdoso'>";
        echo "<h1 class='centro'>Fechas - resultado</h1>";
        echo "<p> La diferencia en días entre las fechas es de: $dias_pasados días</p>";
        echo "</div>";        
        
        
    }
    
    ?>
</body>
</html>