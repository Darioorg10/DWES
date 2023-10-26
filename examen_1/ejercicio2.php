<?php // Control de errores
    if (isset($_POST["btnContar"])) {
        $error_form = $_POST["texto"] == "";
    }

    function mi_explode($separador, $texto){        
        $aux = array();        
        $l_texto = strlen($texto);
        $i = 0;
        while ($i < $l_texto && $texto[$i] == $separador) { // Quitamos los separadores del principio
            $i++;
        }
    
        if ($i < $l_texto) { // Si quitando los separadores seguimos teniendo texto
            $j = 0;
            $aux[$j] = $texto[$i];
            for ($i=$i+1; $i < $l_texto; $i++) {
                if ($texto[$i] != $separador) { // Si no es un separador le concatenamos el siguiente carácter
                    $aux[$j].=$texto[$i];
                } else {
                    while ($i < $l_texto && $texto[$i] == $separador) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                        $i++;                        
                    }
    
                    if ($i < $l_texto) {
                        $j++;    
                        $aux[$j] = $texto[$i];
                    }
                    
                }
            }
        }
    
        return $aux;
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
    <style>
        .error{
            color:red
        }
    </style>
</head>
<body>
    <h1>Ejercicio 2. Contar Palabras sin las vocales (a, e, i, o, u, A, E, I, O, U)</h1>
    <form action="ejercicio2.php" method="post">
        <p>
            <label for="texto">Introduzca un texto: </label>
            <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["btnContar"]) && $_POST["texto"] != "") echo $_POST["texto"];?>">
            <?php
            if (isset($_POST["btnContar"]) && $error_form) {
                echo "<span class='error'>*Campo obligatorio*</span>";
            }                                    
                
            ?>
        </p>
        <p>
            <label for="separadorSel">Elija un separador: </label>
            <select name="separadorSel" id="separadorSel">
                <option value=";" <?php if(isset($_POST["texto"]) && $_POST["separadorSel"] == ";") echo "selected";?>>;</option>
                <option value=":" <?php if(isset($_POST["texto"]) && $_POST["separadorSel"] == ":") echo "selected";?> >:</option>
                <option value="," <?php if(isset($_POST["texto"]) && $_POST["separadorSel"] == ",") echo "selected";?>>,</option>
                <option value=" " <?php if(isset($_POST["texto"]) && $_POST["separadorSel"] == " ") echo "selected";?> > (espacio)</option>
            </select>
        </p>
        <p>
            <button type="submit" id="btnContar" name="btnContar">Contar</button>
        </p>
        <?php 
            if (isset($_POST["btnContar"]) && !$error_form) {
                echo "<h1>Respuesta</h1>";
                $palabras = mi_explode($_POST["separadorSel"], $_POST["texto"]);                
                $palabrasSinVocal = 0;
                $esVocal = false;
                foreach($palabras as $palabra){ // Por cada palabra
                    for ($i=0; $i < strlen($palabra); $i++) { // Recorremos letra por letra en busca de una vocal                        
                        if ($palabra[$i] == "a" || $palabra[$i] == "e" || $palabra[$i] == "i" || $palabra[$i] == "o" || $palabra[$i] == "u"
                        ||  $palabra[$i] == "A" || $palabra[$i] == "E" || $palabra[$i] == "I" || $palabra[$i] == "O" || $palabra[$i] == "U") { // Vemos cada letra
                                $esVocal = true; // En cuanto aparezca una vocal, esa palabra ya no vale
                                break;
                        } else {
                            $palabrasSinVocal++;                                                
                        }
                    }
                        
                    }

                echo "El texto ".$_POST["texto"]." con el separador ".$_POST["separadorSel"]." contiene ".$palabrasSinVocal - count($palabras) ." palabras sin vocales.";                

                }                                                
            
        ?>
    </form>
    
</body>
</html>