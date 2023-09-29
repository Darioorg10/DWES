<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
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
        .falloPri{color:red}
        .falloSeg{color:red}

    </style>
</head>
<body>
    
    <!-- No te va a responder hasta que pongas 3 caracteres por cada uno
    y completes los dos inputs. Tienes que hacerle un trim a los strings de dentro-->

    <div class="formulario">
    
    <form action="ej1.php" method="post">
    <h1 id="tit1">Ripios - Formulario</h1>
        <p>Dime dos palabras y te diré si riman o no.</p>
        <p><label for="pri">Primera palabra:</label>
            <input type="text" name="pri" id="pri">            
            <span class="falloPri">
                <?php 
                    $err_pri_vacio = $_POST["pri"] == "";
                    $err_pri_corto = strlen($_POST["pri"]) < 3;
                    if (isset($_POST["btnEnviar"]) && $err_pri_vacio) {
                        echo "Campo obligatorio";
                    }
                ?>
            </span>            
        </p>
        <p><label for="seg">Segunda palabra:</label>
            <input type="text" name="seg" id="seg">
            <span class="falloSeg">
                <?php 
                    $err_seg_vacio = $_POST["seg"] == "";        
                    $err_seg_corto = strlen($_POST["seg"]) < 3;
                    $err_form = $err_pri_corto || $err_pri_vacio || $err_seg_corto || $err_seg_vacio;
                ?>
            </span>
        </p>
        <p><input type="submit" name="btnEnviar" value="Comparar"></p>
    </form>
        

    </div>

    <?php 

        if (isset($_POST["btnEnviar"]) && !$err_form) {
            ?>
            <div class="resultado">
                <h1 id="tit2">Ripios - Resultado</h1>
            
            <?php            

            $palabraBien1 = strtoupper(trim($_POST["pri"])); // Las ponemos sin espacio y mayúsculas
            $palabraBien2 = strtoupper(trim($_POST["seg"]));                                    

            if (substr($palabraBien1, -3) == substr($palabraBien2, -3)) {
                echo "<p>Las palabras ".$_POST['pri']." y ".$_POST['seg']." riman</p>";
            }
            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>