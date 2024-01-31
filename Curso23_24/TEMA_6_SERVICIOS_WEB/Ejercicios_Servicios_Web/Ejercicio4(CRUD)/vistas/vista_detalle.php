<?php
echo "<h3>Detalles del usuario con id: " . $_POST['btnDetalle'] . "</h3>";

$url = DIR_SERV . "/usuario/" . $_POST["btnDetalle"];
$respuesta = consumir_servicios_REST($url, "GET");
$obj = json_decode($respuesta);

if (!$obj) {
    session_destroy();
    die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error consumiendo el servicio: " . $url . "</p>"));
}

if (isset($obj->error)) {
    session_destroy();
    die(error_page("Práctica 1ºCRUD SW", "<h1>Práctica 1ºCRUD SW</h1><p>Error: " . $obj->error . "</p>"));
}

// Comprobamos que exista por si se borra un usuario
if (isset($obj->usuario)) { // Si hemos obtenido alguna tupla
    echo "<p>";
    echo "<strong>Nombre: </strong>" . $obj->usuario->nombre . "<br>";
    echo "<strong>Usuario: </strong>" . $obj->usuario->usuario . "<br>";
    echo "<strong>Email: </strong>" . $obj->usuario->email . "<br>";
    echo "</p>";
} else {
    echo "<p>El usuario seleccionado ya no está registrado en la BD</p>";
}

// Botón para volver
echo "<form action='index.php' method='post'>";
echo "<p><button type='submit' name='btnVolver'>Volver</button></p>";
echo "</form>";
