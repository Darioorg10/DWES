<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
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

    <div class="formulario">
    
    <form action="ej4.php" method="post">
    <h1 id="tit1">romanos a árabes - Formulario</h1>
        <p>Dime un número en números romanos y lo convertiré en cifras árabes</p>
        <p><label for="pri">Número:</label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST['num']?>">            
            <span class="falloNum">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        $err_num_vacio = trim($_POST["num"]) == "";                        
                        $err_form = $err_num_vacio;
                        if ($err_num_vacio) {
                            echo "Campo obligatorio";
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
                <h1 id="tit2">romanos a árabes - Resultado</h1>
            
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