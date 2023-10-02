<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 7</title>
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
        .falloNum{color:red}        

    </style>
</head>
<body>        

    <div class="formulario">
    
    <form action="ej7.php" method="post">
    <h1 id="tit1">Unifica separador decimal - Formulario</h1>
        <p>Escribe varios números separados por espacios y unificaré el separador decimal a puntos</p>
        <p><label for="pri">Número:</label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST['num']?>">            
            <span class="falloNum">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        $err_num_vacio = $_POST["num"] == "";
                        $err_no_num = !is_float($_POST["num"]) || !is_numeric($_POST["num"]) || !is_int($_POST["num"]);                                                 
                        $err_form = $err_num_vacio || $err_no_num;
                        if ($err_num_vacio) {
                            echo "Campo obligatorio";
                        } else if ($err_no_num){
                            echo "No has introducido un número";
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
                <h1 id="tit2">Unifica separador decimal - Resultado</h1>
            
            <?php            

            $numRegular = trim($_POST["num"]); // Las ponemos sin espacio y mayúsculas
            $numBien = str_replace(",", ".", $numRegular);            

            echo "<p>Números originales</p>";
            echo "<p>\t$numRegular</p>";

            echo "<p>Números corregidos</p>";        
            echo "<p>\t$numBien</p>";                        

            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>