<?php 
    session_name("ejer_02_ses_23_24");
    session_start();

    if (isset($_POST["btnSig"]) || isset($_POST["btnBorrar"])) {
        if (isset($_POST["btnBorrar"])) {
            session_destroy();                        
        } else {
            if ($_POST["nombre"] == "") {
                $_SESSION["error"] = "No has tecleado nada";
                unset($_SESSION["nombre"]);
            } else {
                $_SESSION["nombre"] = $_POST["nombre"];
            }
        }
    }      
    
    header("Location:sesiones_02_1.php");
    exit;

?>