<?php

if (isset($_POST["btnEnviar"])) { // Comprobamos errores

    $texto = trim($_POST["num"]);
    $err_vacio = $texto == "";    
    $err_num = !is_numeric($texto);
    $err_negativo = $texto <= 0;
    $err_grande = $texto >= 5000;

    $err_form = $err_vacio || $err_num || $err_grande || $err_negativo;
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
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
    
    <form action="ej5.php" method="post">
    <h1 id="tit1">árabes a romanos - Formulario</h1>
        <p>Dime un número en números árabes y lo convertiré en números romanos</p>
        <p><label for="pri">Número:</label>
            <input type="text" name="num" id="num" value="<?php if(isset($_POST["btnEnviar"])) echo $_POST['num']?>">            
            <span class="falloNum">
                <?php                                         
                    if (isset($_POST["btnEnviar"]) && $err_form) {
                        if ($texto == "") {
                            echo "Campo obligatorio";
                        } else if($err_num){
                            echo "No has escrito el número correctamente";
                        } else if($err_grande){
                            echo "El número no puede ser mayor a 5000";
                        } else {
                            echo "El número no puede ser negativo";
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
                <h1 id="tit2">árabes a romanos - Resultado</h1>
            
            <?php            
                               
                
                $res = "";
                $num = $texto;
                while ($num > 0) {
                    if ($num >= 1000) {
                        $num -= 1000;
                        $res.="M";
                    } else if($num >= 500){
                        $num -= 500;
                        $res.="D";
                    } else if($num >= 100){
                        $num -= 100;
                        $res.="C";
                    } else if($num >= 50){
                        $num -= 50;
                        $res.="L";
                    } else if($num >= 10){
                        $num -= 10;
                        $res.="X";
                    } else if($num >= 5){
                        $num -= 5;
                        $res.="V";
                    } else if($num >= 1){
                        $num -= 1;
                        $res.="I";
                    }
                }
                
                


                echo "<p>El número árabe: $texto pasado a números romanos es: $res</p>";

            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>