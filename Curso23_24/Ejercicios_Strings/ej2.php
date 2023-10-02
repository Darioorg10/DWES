<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
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
    
    <form action="ej2.php" method="post">
    <h1 id="tit1">Palíndromos / capicúas - Formulario</h1>
        <p>Dime una palabra o un número y te diré si es una palabra palíndroma o un número capicúa</p>
        <p><label for="pri">Palabra o número:</label>
            <input type="text" name="fra" id="fra" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST['fra']?>">            
            <span class="falloFra">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        $err_fra_vacia = trim($_POST["fra"]) == "";
                        $err_fra_corta = strlen(trim($_POST["fra"])) < 3;                        
                        $err_form = $err_fra_vacia || $err_fra_corta;
                        if ($err_fra_vacia) {
                            echo "Campo obligatorio";
                        } else if ($err_fra_corta) {
                            echo "La palabra o número debe tener al menos 3 carácteres";
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
                <h1 id="tit2">Palíndromos / capicúas - Resultado</h1>
            
            <?php            

            $palabraBien = strtoupper(trim($_POST["fra"])); // Las ponemos sin espacio y mayúsculas            

            function esPalindroma($p){                
                
                for ($i=0; $i < strlen($p)/2; $i++) {
                    if ($p[$i] != $p[strlen($p) - 1 - $i]) { // Vamos mirando si la primera y la última posición son iguales
                        return false;
                    }
                }
                return true;
            }            

            /* El profesor ha hecho para lo de palíndromo
            
            $i = 0;
            $j = str_len($texto) - 1;
            $bien = true;

            while($i<$j && $bien){
                if($texto_m[$i]==$texto_m[$j]){
                    $i++;
                    $j++;
                } else {
                    $bien = false;
                }
            }

            Y ya, if($bien) y es númerico, te da que es capicúo, y si no es númerico pues es palíndromo

            */
            
            if (is_numeric($palabraBien)) {
                if (esPalindroma($palabraBien)) {
                    echo "<p>El número " . $_POST['fra'] . " es capicúa</p>";
                } else {
                    echo "<p>El número " . $_POST['fra'] . " no es capicúa</p>";
                }
            } else {
                if (esPalindroma($palabraBien)) {
                    echo "<p>La palabra " . $_POST['fra'] . " es palíndroma</p>";
                } else {
                    echo "<p>La palabra " . $_POST['fra'] . " no es palíndroma</p>";
                }
            }
    


            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>