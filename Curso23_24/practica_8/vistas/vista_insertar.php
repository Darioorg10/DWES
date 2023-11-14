<?php // Control de errores
if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
    if (isset($_POST["btnContInsertar"])) {
                
    }
}
?>

<form action="index.php" method="post" enctype="multipart/form-data">
                <p>
                    <label for="nombre">Nombre:</label><br/>
                    <input type="text" name="nombre" id="nombre" placeholder="Nombre...">
                </p>
                <p>
                    <label for="usuario">Usuario:</label><br/>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario...">
                </p>
                <p>
                    <label for="psw">Contraseña:</label><br/>
                    <input type="password" name="psw" id="psw" placeholder="Contraseña...">
                </p>
                <p>
                    <label for="dni">DNI:</label><br/>
                    <input type="text" name="dni" id="dni" placeholder="DNI: 11223344Z">
                </p>
                <p>
                    <label for="sexo">Sexo:</label><br/>
                    <input type="radio" name="sexo" id="hombre" value="hombre"><label for="hombre">Hombre</label></input><br/>
                    <input type="radio" name="sexo" id="mujer" value="mujer"><label for="mujer">Mujer</label></input><br/>
                </p>
                <p>
                    <label for="archivo">Incluir mi foto </label><input type="file" name="archivo" id="archivo">
                </p>

                <button type="submit" name="btnContInsertar">Guardar Cambios</button>
                <button type="submit" name="btnAtras">Atrás</button>
</form>