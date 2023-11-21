<?php

// Esta función ya existe y se llama in_array
function en_array($valor, $arr)
{
    $esta = false;

    for ($i=0; $i < count($arr); $i++) { 
        if ($arr[$i] == $valor) {
            $esta = true;
            break;
        }
    }

    return $esta;
}


// Hacemos el control de errores
if (isset($_POST["btnEnviar"])) 
{
    $error_nombre = $_POST["nombre"]=="";
    $error_sexo = !isset($_POST["sexo"]);
    $error_form = $error_nombre || $error_sexo;                
}

// Decido vista según errores
if (isset($_POST["btnEnviar"]) && !$error_form) 
{
    require "vistas/vista_respuesta.php";
}
else 
{               
    require "vistas/vista_formulario.php";
}

?>

