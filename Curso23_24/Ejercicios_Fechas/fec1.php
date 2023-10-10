<?php 
    // Vamos a definir los errores
    if (isset($_POST["btnEnviar"])) {

        $error_vac1 = trim($_POST["fec1"]) == "";
        $error_vac2 = trim($_POST["fec2"]) == "";
        $error_longitud1 = trim(strlen($_POST["fec1"])) != 10; 
        $error_longitud2 = trim(strlen($_POST["fec2"])) != 10;
        $error_formato_1 = trim(substr($_POST["fec1"], 0, 2)) != "/" || trim(substr($_POST["fec1"], 0, 5)) != "/";
        $error_formato_2 = trim(substr($_POST["fec2"], 0, 2)) != "/" || trim(substr($_POST["fec1"], 0, 5)) != "/";


        $error_form = $error_vac1 || $error_vac2 || $error_longitud1 || $error_longitud2 || $error_formato_1 || $error_formato_2;
    }    

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechas - Formulario</title>
    <style>
        h1{text-align: center;}
        .error{color:red}
    </style>
</head>
<body>

    <div class="formulario"> <!-- Hay que calcular la diferencia entre dos fechas -->
        <h1>Fechas - Formulario</h1>
        <form action="fec1.php" method="post">
            <p>
                <label for="fec1">Introduzca una fecha: (DD/MM/YYYY)</label>                
                <input type="text" name="fec1" id="fec1" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST["fec1"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        if ($error_longitud1) {
                            echo "<span class='error'>No has introducido una fecha correcta</span>";
                        } else if($error_formato_1){
                            echo "<span class='error'>La fecha no tiene el formato correcto</span>";
                        } else if($error_vac1){
                            echo "<span class='error'>Campo obligatorio</span>";
                        }
                    }                    
                ?>
            </p>
            <p>
                <label for="fec2">Introduzca una fecha: (DD/MM/YYYY)</label>
                <input type="text" name="fec2" id="fec2" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST["fec2"];?>">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        if ($error_longitud2) {
                            echo "<span class='error'>No has introducido una fecha correcta</span>";
                        } else if($error_formato_2){
                            echo "<span class='error'>La fecha no tiene el formato correcto</span>";
                        } else if($error_vac2){
                            echo "<span class='error'>Campo obligatorio</span>";
                        }
                    }                    
                ?>
            </p>
            <input type="submit" name="btnEnviar" value="Calcular">
        </form>
    </div>

    <?php 
        if(isset($_POST["btnEnviar"]) && !$error_form){
            ?>
            <div class="respuesta">
            <h1>Fecha - Respuesta</h1>
            </div>
            <?php
        }
    ?>
    
    

</body>
</html>