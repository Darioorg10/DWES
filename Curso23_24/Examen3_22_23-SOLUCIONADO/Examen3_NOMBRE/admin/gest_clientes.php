<?php
require "../src/ctes_funciones.php";
session_name("Examen2_curso18_19");
session_start();

if(isset($_SESSION["usuario"])) {
    $salto="../index.php";
    require "../src/seguridad.php";
    if ($datos_usuario_logueado["tipo"]=="admin")
        require "../vistas/vista_admin.php";
    else{
        header("Location: ../index.php");
    }
}else{
    header("Location: ../index.php");
}
?>