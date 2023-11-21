<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
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
    
    <form action="ej6.php" method="post">
    <h1 id="tit1">Quita acentos - Formulario</h1>
        <p>Escribe un texto y le quitaré los acentos.</p>
        <p><label for="pri">Texto:</label>
            <textarea name="fra" id="fra"><?php if(isset($_POST["btnEnviar"])) echo $_POST['fra']?></textarea>            
            <span class="falloFra">
                <?php 
                    if (isset($_POST["btnEnviar"])) {
                        $err_fra_vacia = $_POST["fra"] == "";                        
                        $err_form = $err_fra_vacia;
                        if ($err_fra_vacia) {
                            echo "Campo obligatorio";
                        }
                    }
                    
                    
                ?>
            </span>            
        </p>      

        <p><input type="submit" name="btnEnviar" value="Quitar acentos"></p>

    </form>
        

    </div>

    <?php 

        if (isset($_POST["btnEnviar"]) && !$err_form) {
            ?>
            <div class="resultado">
                <h1 id="tit2">Quitar acentos - Resultado</h1>
            
            <?php            

            $textoConAcentos = $_POST["fra"];

            function quitarAcentos($c){
                
                $c = str_replace(
                    array('á', 'Á'), // Lo que queremos cambiar
                    array('a', 'A'), // Por lo que queremos cambiar
                    $c // El string a mirar
                );                    
                $c = str_replace(
                    array('é', 'É'),
                    array('e', 'E'),
                    $c
                );
                $c = str_replace(
                    array('í', 'Í'),
                    array('i', 'I'),
                    $c
                );
                $c = str_replace(
                    array('ó', 'Ó'),
                    array('o', 'O'),
                    $c
                );
                $c = str_replace(
                    array('ú', 'Ú'),
                    array('u', 'U'),
                    $c
                );    
                $c = str_replace(
                    array('ü', 'Ü'),
                    array('u', 'U'),
                    $c
                );    
                return $c;                            
            }
            
            $textoSinAcentos = quitarAcentos($textoConAcentos);
            echo "<p>Texto original:</p><br/>";
            echo "<p>$textoConAcentos</p>";
            echo "<p>Texto sin acentos:</p>";
            echo "<p>$textoSinAcentos</p>";

            ?>
            </div>
            <?php

        }

    ?>

</body>
</html>