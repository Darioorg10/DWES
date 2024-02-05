<?php

define("DIR_SERV", "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Examen_SW_22_23/servicios_rest");

if (isset($_POST["btnLogin"])) {
    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;
}

function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title,$cabecera,$mensaje)
{
    $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html.='<title>'.$title.'</title></head>';
    $html.='<body><h1>'.$cabecera.'</h1>'.$mensaje.'</body></html>';
    return $html;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
</head>
<body>
    <h1>Librería</h1>
    <form action="index.php" method="post">
        <p><label for="usuario">Nombre de usuario: </label><input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST["btnEnviar"])) ?>"></input></p>
        <p><label for="clave">Contraseña: </label><input type="text" name="clave" id="clave"></input></p>
        <p><button type="submit" name="btnLogin">Entrar</button></p>
    </form>
</body>
</html>