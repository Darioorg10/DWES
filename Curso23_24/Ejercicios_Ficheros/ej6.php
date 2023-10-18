<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>

<body>  
    <h3>Ejercicio 6</h3>
    <?php
    @$fd = fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt", "r");
    if (!$fd) {
        die("<h3>No se ha podido abrir el fichero</h3>");
    }
    
    $linea = fgets($fd);
    $datos_linea = explode("\t", $linea);
    $n_col = count($datos_linea);
    for ($i=0; $i < $n_col; $i++) {
        $arr1 = explode("\t", $datos_linea[$i]);        
    }

    for ($i=0; $i < count($arr1); $i++) { 
        $arr2 = explode(",", $arr1[$i]);
    }
    

    
    fclose($fd);
    ?>
    <form action="ej6.php" method="post">
        <p>
            <label for="pais">Seleccione un país</label>
            <select name="pais" id="pais">
                
            </select>
        </p>
        <p>
            <button type="submit" name="btnBuscar">Buscar</button>
        </p>
    </form>
</body>

</html>