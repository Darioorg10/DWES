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
            <span class="falloPri"></span>            
        </p>
        <p><label for="seg">Segunda palabra:</label>
            <input type="text" name="seg" id="seg">
            <span class="falloSeg"></span>
        </p>
        <p><input type="submit" name="btnEnviar" value="Comparar"></p>
    </form>
        

    </div>

    <?php 

        if (isset($_POST["btnEnviar"])) {
            ?>
            <div class="resultado">
                <h1 id="tit2">Ripios - Resultado</h1>
            </div>
            <?php

            $err_pri_vacio = if ($_POST["pri"]) == "";
            $err_seg_vacio = if ($_POST["seg"]) == "";
            $err_pri_corto = if (strlen($_POST["pri"])) < 3;


        }

    ?>

</body>
</html>