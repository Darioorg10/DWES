<?php

// Iniciamos la sesión
session_name("Examen3_17-18");
session_start();

// Si estoy logueado voy por un lado
if (isset($_SESSION["usuario"])) {
?>
    <h2>Video Club</h2>
    <form action="index.php" method="post">
        <label for="nombreUsuario">Nombre de usuario:</label>
        <input type="text" name="nombreUsuario" id="nombreUsuario"><br /><br />
        <label for="clave">Contraseña:</label>
        <input type="text" name="clave" id="clave"><br /><br />
        <button type="submit" name="btnLogin" id="btnLogin">Entrar</button>
        <button type="submit" name="btnRegistrar" id="btnRegistrar">Registrarse</button>
    </form>

<?php
} else {
    // Si no estoy logueado, voy por otro lado

}

?>