<?php
session_name("primer_CRUD_con_SW");
session_start();

require "src/constantes_funciones.php"; // Nos traemos las funciones y las constantes

if (isset($_POST["btnContBorrar"])) {
    $url = DIR_SERV . "/borrarUsuario/" . $_POST["btnContBorrar"];
    $respuesta = consumir_servicios_REST($url, "DELETE");
    $obj = json_decode($respuesta);

    if (!$obj) {
        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
    }

    if (isset($obj->error)) {
        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: " . $obj->error . "</p>"));
    }

    $_SESSION["mensaje"] = "El usuario ha sido borrado con éxito";
    header("Location:index.php");
    exit();
}

if (isset($_POST["btnContEditar"])) {
    $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
    $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
    if (!$error_usuario) {
        
        // Si no hay error miramos si está repetido
        $url = DIR_SERV."/repetido/usuarios/usuario/".$_POST["usuario"]."/id_usuario/".$_POST["btnContEditar"]."";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            
            if (!$obj) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
            }

            if (isset($obj->error)) {
                die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
            }        

        $error_usuario = $obj->repetido;

        if (is_string($error_usuario)) {
            die($error_usuario);
        }

        $error_clave = strlen($_POST["clave"]) > 15;
        $error_email = $_POST["email"] == "" || strlen($_POST["email"]) > 50 || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

        $url = DIR_SERV."/repetido/usuarios/email/".$_POST["email"]."/id_usuario/".$_POST["btnContEditar"]."";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
            
        if (!$obj) {
            die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
        }

        if (isset($obj->error)) {
            die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
        }        
        
        $error_email = $obj->repetido;

        if (is_string($error_email)) {
            die($error_email);
        }

        $error_form = $error_nombre || $error_usuario || $error_clave || $error_email;

        if (!$error_form) {
            try {
                if ($_POST["clave"] == "") {
                    $url = DIR_SERV."/actualizarUsuarioSinClave/".$_POST["btnContEditar"];
                    $datos = array("nombre" => $_POST["nombre"], "usuario" => $_POST["usuario"], "email" => $_POST["email"]); // Metemos los atributos en un array
                    $respuesta = consumir_servicios_REST($url, "PUT", $datos);
                    $obj = json_decode($respuesta);
                        
                    if (!$obj) {
                        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
                    }

                    if (isset($obj->error)) {
                        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
                    }
                } else {
                    $url = DIR_SERV."/actualizarUsuario/".$_POST["btnContEditar"];
                    $datos = array("nombre" => $_POST["nombre"], "usuario" => $_POST["usuario"], "clave" => $_POST["clave"], "email" => $_POST["email"]); // Metemos los atributos en un array
                    $respuesta = consumir_servicios_REST($url, "PUT", $datos);
                    $obj = json_decode($respuesta);
                        
                    if (!$obj) {
                        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: ".$url."</p>"));
                    }

                    if (isset($obj->error)) {
                        die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: ".$obj->error."</p>"));
                    }
                }                

            } catch (Exception $e) {                
                session_destroy();
                die(error_page("Práctica 1ºCRUD", "<h1>Práctica 1ºCRUD</h1><p>No se ha podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
            }
            
            $_SESSION["mensaje"] = "El usuario ha sido actualizado con éxito";
            header("Location:index.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1ºCRUD SW</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
        }

        th {
            background-color: #CCC;
        }

        img {
            width: 50px;
            height: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        .error {
            color: red
        }

        .mensaje {
            color: blue;
            font-size: 1.5em;
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    require "vistas/vista_tabla.php";

    // Si se pulsa un nombre que nos de los datos
    if (isset($_POST["btnDetalle"])) {

        require "vistas/vista_detalle.php";

    } else if (isset($_POST["btnBorrar"])) {

        require "vistas/vista_conf_borrar.php";

    } else if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {

        require "vistas/vista_editar.php";

    } else {

        require "vistas/vista_nuevo.php";

    }

    ?>
</body>

</html>