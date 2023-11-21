<?php     

    require "src/funciones.php";

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
        $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
        $error_sexo = !isset($_POST["sexo"]); // Si no se marca ni hombre ni mujer
        $error_comentarios = $_POST["comentarios"] == "";
        $error_archivo = $_FILES["archivo"]["error"] || $_FILES["archivo"]["size"] > 500*1024 ;

        $error_form = $error_nombre || $error_apellidos || $error_contrasena || $error_dni
        || $error_sexo || $error_comentarios  || $error_archivo;                    

    }        

    if(isset($_POST["btnEnviar"]) && !$error_form)
    {
        require "vistas/vista_respuestas.php";                                

    } else {

        require "vistas/vista_formulario.php";

    }   

?>



