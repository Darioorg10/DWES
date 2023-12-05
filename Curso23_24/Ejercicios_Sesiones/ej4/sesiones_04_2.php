<?php

    session_name("ej3_ses_23_24");
    session_start();

    if (isset($_POST["btnContador"])) {
        if ($_POST["btnContador"] == "cero") {
            session_destroy();            
        } else if($_POST["btnContador"] == "mas"){
            $_SESSION["contador"]++;     
        } else {
            $_SESSION["contador"]--;    
        }
    }
    
    header("Location:sesiones_03_1.php");
    exit;
        
?>