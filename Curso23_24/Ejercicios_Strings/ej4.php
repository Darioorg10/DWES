<?php

const VALOR = array("M" => 1000, "D" => 500, "C" => 100, "L" => 50,
"X" => 10, "V" => 5, "I" => 1);

function letras_bien($texto){
    $bien = true;
    for ($i=0; $i < strlen($texto); $i++) {
        if (!isset(VALOR[$texto[$i]])) { // Si no existe algo del texto en las constantes
            $bien = false;
            break;
        }
    }
    return $bien;
}

function orden_bueno($texto){
    $bien = true;
    for ($i=0; $i < strlen($texto)-1; $i++) {
        if(VALOR[$texto[$i]] < VALOR[$texto[$i+1]]){ // Tienen que ir en orden creciente
            $bien = false;
            break;
        }
    }
    return $bien;
}

function repite_bien($texto){

    $veces["I"] = 4; // Es hasta el 5000
    $veces["V"] = 1;
    $veces["X"] = 4;
    $veces["L"] = 1;
    $veces["C"] = 4;
    $veces["D"] = 1;
    $veces["M"] = 4;

    $bien = true;
    for ($i=0; $i < strlen($texto); $i++) {
        $veces[$texto[$i]]--;
        if ($veces[$texto[$i]] == -1) {
            $bien = false;
            break;
        }
    }
    return $bien;
}

function es_romano($texto){


    return letras_bien($texto) && orden_bueno($texto) && repite_bien($texto);
}

if (isset($_POST["btnEnviar"])) { // Comprobamos errores
    $texto = trim($_POST["num"]);
    $texto_m = strtoupper($texto);

    $err_form = $texto == "" || !es_romano(strtoupper($texto_m));
    
}
?>

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
        .falloNum{color:red}        

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
                    if (isset($_POST["btnEnviar"]) && $err_form) {
                        if ($texto == "") {
                            echo "Campo obligatorio";
                        } else {
                            echo "No has escrito un número romano correcto";
                        }
                    }
                ?>
            </span>            
        </p>      

        <p><input type="submit" name="btnEnviar" value="Convertir"></p>

    </form>
        

    </div>

    <?php 

        if (isset($_POST["btnEnviar"]) && !$err_form) {
            ?>
            <div class="resultado">
                <h1 id="tit2">romanos a árabes - Resultado</h1>
            
            <?php            
                                    
                $res = 0;
                for ($i=0; $i < strlen($texto_m); $i++) { 
                    $res += VALOR[$texto_m[$i]];
                }

                echo "<p>El número romano: $texto pasado a cifras árabes es: $res</p>";

            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>