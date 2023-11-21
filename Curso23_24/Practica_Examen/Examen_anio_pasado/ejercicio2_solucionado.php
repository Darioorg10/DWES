<?php
function mi_explode($separador, $texto)
{
    $res=array();

    //No cuento los separadores que pudiera haber inicialmente
    $j=0;
    $long_texto=strlen($texto);
    while($j<$long_texto && $texto[$j]==$separador)
        $j++;

    if($j<$long_texto)
    {  
        $cont=0;
        $res[$cont]=$texto[$j];
        $j++;
        while($j<$long_texto)
        {
            if($texto[$j]!=$separador)
            {
                $res[$cont].=$texto[$j];
                $j++;
            }
            else
            {
                $j++;
                while($j<$long_texto && $texto[$j]==$separador)
                    $j++;
                    
                if($j<$long_texto)
                {
                    $cont++;
                    $res[$cont]=$texto[$j];
                    $j++;
                } 
            }
        }
    }
    return $res;
}

if(isset($_POST["btnEnviar"]))
{
    $error_texto=$_POST["texto"]=="";
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 2 PHP</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1>Ejercicio 2. Longitud de las palabras extraídas</h1>
        <form method="post" action="ejercicio2_b.php">
           
            <p><label for="texto">Introduzca un Texto: </label><input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>"/>
            <?php
                if(isset($_POST["texto"]) && $error_texto)
                    echo " Campo vacío";
            ?>
            </p>
            <p>
            <label for="separador">Elija el Separador: </label>
            <select name="separador" id="separador">
                <option <?php if(isset($_POST["separador"]) && $_POST["separador"]==";") echo "selected";?> value=";">; (Punto y Coma)</option>
                <option <?php if(isset($_POST["separador"]) && $_POST["separador"]==",") echo "selected";?> value=",">, (Coma)</option>
                <option <?php if(isset($_POST["separador"]) && $_POST["separador"]==":") echo "selected";?> value=":">: (Dos puntos)</option>
                <option <?php if(isset($_POST["separador"]) && $_POST["separador"]==" ") echo "selected";?> value=" "> (Espacio)</option>
            </select>
            </p>
            <p><input type="submit" name="btnEnviar" value="Contar"/></p>
        </form>
        <?php
        if(isset($_POST["btnEnviar"]) && !$error_texto)
        {
            echo "<h1>Respuesta</h1>";
            $palabras=mi_explode($_POST["separador"], $_POST["texto"]);
            
            echo "<ol>";
            for($i=0;$i<count($palabras);$i++)
                echo "<li>".$palabras[$i]." ( ".strlen($palabras[$i])." )</li>";
            echo "</ol>";
        }
        ?>
    </body>
</html>