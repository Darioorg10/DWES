<?php 

    if (isset($_POST["btnBorrar"])) 
    {
        unset($_POST); // Quita los valores
        
        /* Otra opción sería (pero no es la recomendada): 
            header("Location:index.php");
            exit;
        */
    }

    if (isset($_POST["btnEnviar"])) // Vamos a hacer control de errores, por ejemplo suponiendo que que el nombre esté vacío es un error
    {
        $error_nombre = $_POST["nombre"] == "";
        $error_apellidos = $_POST["apellidos"] == "";
        $error_contrasena = $_POST["contrasena"] == "";
        $error_sexo = !isset($_POST["sexo"]); // Si no se marca ni hombre ni mujer
        $error_comentarios = $_POST["comentarios"] == "";

        $error_form = $error_nombre || $error_apellidos || $error_contrasena
            || $error_sexo || $error_comentarios;                    

    }        

    if(isset($_POST["btnEnviar"]) && !$error_form)
    {
        require "vistas/vista_respuestas.php";                                

    } else {

        require "vistas/vista_formulario.php";

    }   

?>



