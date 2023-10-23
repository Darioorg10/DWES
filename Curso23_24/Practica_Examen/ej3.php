<?php 
    if (isset($_POST["btnEnviar"])) {
        $error_vacio = $_POST["texto"] == "";

        $error_form = $error_vacio;
    }

    function mi_strlen($texto){
        $contador = 0;
        while (isset($texto[$contador])) {
            $contador++;
        }
        return $contador;
    }

    function mi_explode($separador, $texto){
        $ind_sep = [];
        for ($i=0; $i < mi_strlen($texto); $i++) {
            if ($texto[$i] == $separador) {                
                    $ind_sep[] = $i;                
            }
        }
        return $ind_sep;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <style>
        .error{color:red}
    </style>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <form action="ej3.php" method="post">
        <label for="texto">Introduzca un texto:</label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        <?php 
            if (isset($_POST["btnEnviar"]) && $error_form) {
                if ($error_vacio) {
                    echo "<span class='error'>*Debes de introducir texto*</span>";
                }
            }
        ?>
        <br><br>
        <label for="separadorSel">Elige el separador:</label>
        <select name="separadorSel" id="separadorSel">
            <option value=":">:</option>
            <option value=";">;</option>
            <option value=",">,</option>
            <option value=" "> (espacio)</option>                        
        </select><br><br>
        <button type="submit" name="btnEnviar" id="btnEnviar">Enviar</button>
    </form>
</body>
<?php 
    if (isset($_POST["btnEnviar"]) && !$error_form) {
        if ($_POST["separadorSel"] == ":") {            
            $modificado = mi_explode(":", $_POST["texto"]);            
            echo "<p>El texto tiene: ".(count($modificado)+1)." palabras</p>";
        } else if($_POST["separadorSel"] == ";"){
            $modificado = mi_explode(";", $_POST["texto"]);            
            echo "<p>El texto tiene: ".(count($modificado)+1)." palabras</p>";
        } else if($_POST["separadorSel"] == ","){
            $modificado = mi_explode(",", $_POST["texto"]);            
            echo "<p>El texto tiene: ".(count($modificado)+1)." palabras</p>";
        } else {
            $modificado = mi_explode(" ", $_POST["texto"]);            
            echo "<p>El texto tiene: ".(count($modificado)+1)." palabras</p>";
        }
    }
?>
</html>