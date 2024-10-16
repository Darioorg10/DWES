<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .error {
            color: red
        }
    </style>
</head>

<body>

    <h2>Rellena tu CV</h2>
    <form action="index.php" method="post" enctype="multipart/form-data"> <!-- Cuando hay archivos a mandar y/o contraseña se pone post-->

        <p>
            <label for="nombre">Nombre</label><br />
            <input type="text" id="nombre" name="nombre" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>" /> <!-- El name es fundamental porque si no no mandas nada, en el value hemos puesto eso para que se quede guardado si se reinicia la página por poner otro campo vacío -->
            <?php // Queremos avisar al usuario cuando de error en el nombre

            if (isset($_POST["btnEnviar"]) && $error_nombre) { // Es importante poner el && en ese orden, es decir que compruebe primero que se le ha dado al botón
                echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>

        <p>
            <label for="apellidos">Apellidos</label><br />
            <input type="text" id="apellidos" name="apellidos" value="<?php if (isset($_POST["apellidos"])) echo $_POST["apellidos"]; ?>" size="50" />
            <?php

            if (isset($_POST["btnEnviar"]) && $error_apellidos) {
                echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>

        <p>
            <label for="contrasena">Contraseña</label><br />
            <input type="password" id="contrasena" name="contrasena" />
            <?php

            if (isset($_POST["btnEnviar"]) && $error_contrasena) {
                echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>

        <p>
            <label for="dni">DNI</label><br/>
            <input type="text" id="dni" name="dni" placeholder="11223344Z" value="<?php if(isset($_POST['dni'])) echo $_POST['dni'];?>"/>
            <?php

            if (isset($_POST["btnEnviar"]) && $error_dni) {
                if ($_POST["dni"] == "") {
                    echo "<span class='error'> Campo vacío </span>";
                } else if(!dni_bien_escrito(strtoupper($_POST["dni"]))){
                    echo "<span class='error'>El dni no está bien escrito</span>";
                } else {
                    echo "<span class='error'>La letra no corresponde al dni</span>";
                }
            } 
            ?>
        </p>


        <p>
            Sexo
            <?php

            if (isset($_POST["btnEnviar"]) && $error_sexo) {
                echo "<span class='error'> Debes seleccionar un sexo </span>";
            }
            ?>

            <br />
            <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?> id="hombre" name="sexo" value="hombre" /> <label for="hombre">Hombre</label><br /> <!-- Hay que poner value, si no pone sexo=on, para evitar estas cosas, probar antes con get -->
            <input type="radio" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked"; ?> id="mujer" name="sexo" value="mujer" /> <label for="mujer">Mujer</label><br />
        </p>

        <p><label for="archivo">Incluir mi foto:</label>
            <input type="file" name="archivo" id="archivo" accept="image/*">
            <?php 
                if (isset($_POST["btnEnviar"]) && $error_archivo) {
                    if ($_FILES["archivo"]["name"] != "") // Solo me va a avisar de los errores si hemos seleccionado algo
                    {
                        if ($_FILES["archivo"]["error"]) {
                            echo "<span class='error'>No se ha podido subir el archivo al servidor</span>";
                        } else if (!getimagesize($_FILES["archivo"]["tmp_name"])) {
                            echo "<span class='error'>No has seleccionado un archivo de tipo imagen</span>";
                        } else {
                            echo "<span class='error'>El archivo seleccionado supera los 500KB</span>";
                        }
                    }   
                }
            ?>
        </p>

        <p><label for="nacido">Nacido en:</label>
            <select id="nacido" name="nacido">
                <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Málaga") {
                            echo "selected";
                        } ?>>Málaga</option>
                <option <?php if (isset($_POST["btnEnviar"]) && $_POST["nacido"] == "Granada") {
                            echo "selected";
                        } ?>>Granada</option>
                <option <?php if (!isset($_POST["btnEnviar"]) || (isset($_POST["btnEnviar"])) && $_POST["nacido"] == "Sevilla") {
                            echo "selected";
                        } ?>>Sevilla</option>
            </select>
        </p>

        <p>
            <label for="comentarios">Comentarios: </label>
            <textarea id="comentarios" name="comentarios" rows="5" cols="25"><?php if (isset($_POST["comentarios"])) echo $_POST["comentarios"]; ?></textarea>
            <?php

            if (isset($_POST["btnEnviar"]) && $error_comentarios) {
                echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>

        <p>
            <input type="checkbox" name="suscrito" id="suscrito" checked />
            <label for="suscrito">Subscribirse al boletín de novedades</label>
        </p>

        <p>
            <input type="submit" name="btnEnviar" value="Guardar cambios" />
            <button type="submit" name="btnBorrar">Borrar los datos introducidos</button> <!-- Para poner el reset con botón en vez de input-->
        </p>

    </form>

</body>

</html>