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

function quitar_fin_linea($texto)
{
    $res="";
    for($i=0;$i<strlen($texto)-strlen(PHP_EOL);$i++)
        $res.=$texto[$i];
    return $res;
}

function codifica2($caracter,$despl,$ruta)
{
    @$fd=fopen($ruta,"r");
    if(!$fd)
        die("NO se ha podido abrir el fichero '".$ruta."'");

    $devolver="";
    $linea=fgets($fd);
    while($linea=fgets($fd))
    {
        $aux=mi_explode(";",quitar_fin_linea($linea));
        if($aux[0]==$caracter)
        {
            $devolver=$aux[$despl];
            break;
        }
    }
    fclose($fd);
    return $devolver;
}

function codifica($frase,$ruta)
{
    $res="";
    $long_frase=strlen($frase);
    for($i=0;$i<$long_frase;$i++)
    {
        if($frase[$i]>="0" && $frase[$i]<="5")
        {
            if($i+1<$long_frase)
            {
                if($frase[$i+1]=="0")
                {
                    if($frase[$i]=="0")
                    {
                        $res.="J";
                        $i++;
                    }
                    else
                        $res.=$frase[$i];
                }
                elseif($frase[$i+1]>="1" && $frase[$i+1]<="5")
                {
                    if($frase[$i]!="0")
                    {
                        $res.=codifica2($frase[$i],$frase[$i+1],$ruta);
                        $i++;
                    }
                    else
                        $res.=$frase[$i];
                }
                else
                    $res.=$frase[$i];
            }
            else
                $res.=$frase[$i];
            
        }
        else
            $res.=$frase[$i];
    }
    return $res;
}

if(isset($_POST["btnEnviar"]))
{

    $error_texto=$_POST["texto"]=="";
    $error_fichero=$_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain" || $_FILES["archivo"]["size"]>125000000;
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 3 PHP</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1>Ejercicio 3. Decodifica una frase</h1>
        <form method="post" action="ejercicio3_b.php" enctype="multipart/form-data">
           
            <label for="texto">Introduzca un Texto :</label><input type="text" name="texto" size="50" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>"/>
            <?php
                if(isset($_POST["texto"]) && $error_texto)
                    echo " Campo vacío";
            ?>
            <br/>
            
            <br/>
            <label for="archivo">Seleccione el archivo de claves (.txt y menor 1'25MB)</label><input type="file" name="archivo" accept=".txt" id="archivo"/>
            <?php
                if(isset($_POST["btnEnviar"]) && $_FILES["archivo"]["name"]!="")
                    if($_FILES["archivo"]["error"]) echo " Error al subir el fichero al servidor";
                    elseif($_FILES["archivo"]["type"]!="text/plain") echo " Error el fichero a subir debe ser texto plano ( .txt)";
                    elseif($_FILES["archivo"]["size"]>125000000) echo " Error el tamaño del fichero a subir debe ser inferior a 1'25MB";

            ?>

            <br/>
            <br/>
            <input type="submit" name="btnEnviar" value="Decodificar"/>
        </form>
        <?php
        if(isset($_POST["btnEnviar"]) && !$error_texto &&  !$error_fichero)
        {
            echo "<h1>Respuesta</h1>";
           echo "<p>El texto introducido decodificado sería: <br/><em>".codifica($_POST["texto"],$_FILES["archivo"]["tmp_name"])."</em><p>";
        }
        ?>
    </body>
</html>