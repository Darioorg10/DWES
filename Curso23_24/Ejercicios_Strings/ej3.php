<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .formulario{background-color:lightblue; border:3px solid black}
        .resultado{
                    background-color:lightgreen; 
                    border:3px solid black;
                    margin-top:2%;
                  }
        p{padding:5px}
        #tit1{text-align:center}
        #tit2{text-align:center}
        .falloFra{color:red}        

    </style>
</head>
<body>
    
    <!-- No te va a responder hasta que pongas 3 caracteres -->

    <div class="formulario">
    
    <form action="ej3.php" method="post">
    <h1 id="tit1">Frases palíndromas - Formulario</h1>
        <p>Dime una frase y te diré si es una frase palíndroma</p>
        <p><label for="pri">Frase:</label>
            <input type="text" name="fra" id="fra" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST['fra']?>">            
            <span class="falloFra">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        $err_fra_vacia = $_POST["fra"] == "";
                        $err_fra_corta = strlen($_POST["fra"]) < 3;
                        $err_no_string = is_string($_POST["fra"]) == false;
                        $err_form = $err_fra_vacia || $err_fra_corta;
                        if ($err_fra_vacia) {
                            echo "Campo obligatorio";
                        } else if ($err_fra_corta) {
                            echo "La frase debe tener al menos 3 carácteres";
                        }
                    }
                    
                    
                ?>
            </span>            
        </p>      

        <p><input type="submit" name="btnEnviar" value="Comprobar"></p>

    </form>
        

    </div>

    <?php 

        if (isset($_POST["btnEnviar"]) && !$err_form) {
            ?>
            <div class="resultado">
                <h1 id="tit2">Frases palíndromas - Resultado</h1>
            
            <?php            

            $palabraRegular = strtoupper(trim($_POST["fra"])); // Las ponemos sin espacio y mayúsculas
            $palabraBien = str_replace(" ", "", $palabraRegular);            

            function esPalindroma($p){                
                
                for ($i=0; $i < strlen($p)/2; $i++) {
                    if ($p[$i] != $p[strlen($p) - 1 - $i]) { // Vamos mirando si la primera y la última posición son iguales
                        return false;
                    }
                }
                return true;
            }            
            
            if (esPalindroma($palabraBien)) {
                echo "<p>La frase ".$_POST['fra']." es palíndroma</p>";
            } else {
                echo "<p>La frase ".$_POST['fra']." no es palíndroma</p>";
            }


            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>