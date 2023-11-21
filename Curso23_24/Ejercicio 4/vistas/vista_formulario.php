<!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=1, initial-scale=1.0">
                <title>Ejercicio 4</title>
                <style>
                    .error{color:red};
                </style>
            </head>
            <body>
                
                <h1>Esta es mi super página</h1>
                <form action="index.php" method="post">

                    <p>
                        <label for="i1">Nombre:</label>
                        <input type="text" name="nombre" id="i1" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
                        <?php 
                            if (isset($_POST["btnEnviar"]) && $error_nombre) {
                                echo "<span class='error'>Campo vacío</span>";
                            }
                        ?>
                    </p>

                    <p>
                        <label for="i2">Nacido en:</label>
                        <select name="nacido" id="i2">
                            <option value="Málaga" <?php if(isset($_POST["nacido"]) && $_POST["nacido"] == "Málaga") echo "selected";?>>Málaga</option>
                            <option value="Marbella" <?php if(isset($_POST["nacido"]) && $_POST["nacido"] == "Marbella") echo "selected";?>>Marbella</option>
                            <option value="Estepona" <?php if(isset($_POST["nacido"]) && $_POST["nacido"] == "Estepona") echo "selected";?>>Estepona</option>
                        </select>
                    </p>
                    <p>
                        Sexo:
                        <label for="hombre">Hombre</label>
                        <input type="radio" name="sexo" id="hombre" value="hombre" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked";?>>
                        <label for="mujer">Mujer</label>
                        <input type="radio" name="sexo" id="mujer" value="mujer" <?php if(isset($_POST["sexo"]) && $_POST["sexo"] == "mujer") echo "checked";?>>
                        <?php 
                            if (isset($_POST["btnEnviar"]) && $error_sexo) {
                                echo "<span class='error'>Debes seleccionar un sexo</span>";
                            }
                        ?>
                    </p>

                    <p>
                        Aficiones: <label for="deportes">Deportes</label>
                        <input type="checkbox" name="aficiones[]" id="deportes" value="Deportes" <?php if(isset($_POST["aficiones"]) && en_array("Deportes", $_POST["aficiones"])) echo "checked";?>>
                        <label for="lectura">Lectura</label>
                        <input type="checkbox" name="aficiones[]" id="lectura" value="Lectura" <?php if(isset($_POST["aficiones"]) && en_array("Lectura", $_POST["aficiones"])) echo "checked";?>>
                        <label for="otros">Otros</label>
                        <input type="checkbox" name="aficiones[]" id="otros" value="Otros" <?php if(isset($_POST["aficiones"]) && en_array("Otros", $_POST["aficiones"])) echo "checked";?>>
                    </p>

                    <p>
                        <label for="comentarios">Comentarios:</label>
                        <textarea name="comentarios" id="comentarios"><?php if(isset($_POST["comentarios"])) echo $_POST['comentarios'];?></textarea>
                    </p>

                    <p>
                        <button type="submit" name="btnEnviar">Enviar</button>
                    </p>

                </form>

            </body>
</html>