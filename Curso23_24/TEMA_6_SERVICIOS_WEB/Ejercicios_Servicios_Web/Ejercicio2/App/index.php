<?php 

    session_name("ejercicio2_servicios_web");
    session_start();

    // Cogemos los servicios rest
    define("DIR_SERV", "http://localhost/Proyectos/DWES/Curso23_24/TEMA_6_SERVICIOS_WEB/Ejercicios_Servicios_Web/Ejercicio1/servicios_rest/"); // LLAMAMOS A LOS SERVICIOS DEL EJERCICIO 1
    
    // Y creamos la función
    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos))
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }

    // Definimos las constantes para la conexión
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_tienda");

    // Vamos a abrir la conexión con la base de datos
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
        return $respuesta;
    }        

    // Si le damos al botón de confirmar borrar
    if (isset($_POST["btnConfBorrar"])) {
        try{
            $consulta="delete from producto where cod=?";
            $sentencia=$conexion->prepare($consulta);
            $sentencia->execute([$_POST["btnConfBorrar"]]);
        }
        catch(PDOException $e)
        {
            $sentencia=null;
            $conexion=null;
            $respuesta["mensaje_error"] = "No se ha podido conectar a la base de datos: ".$e->getMessage();
            return $respuesta;
        }

        $_SESSION["mensaje"] = "Producto borrado con éxito";
        header("Location:index.php"); // Cuando hayamos puesto el mensaje vamos al inicio (para que al darle f5 no salga)
        exit;
    }

    // Si le damos al botón de continuar el insertar
    if (isset($_POST["btnContInsertar"])) {
        // Errores si está vacío (menos nombre y descripción) o la longitud no es correcta
        $error_codigo = $_POST["codigo"] == "" || strlen($_POST["codigo"]) > 12;
        $error_nombre = strlen($_POST["nombre"]) > 200;
        $error_nombre_corto = $_POST["nombre_corto"] == "" || strlen($_POST["nombre_corto"]) > 50;
        $error_pvp = $_POST["pvp"] == "" || !is_numeric($_POST["pvp"]);       
        
        // Si no hay error en el código comprobamos si está repetido
        if (!$error_codigo) {            
            $url = DIR_SERV . "/repetido/producto/cod/".$_POST["codigo"]."";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);
            // Para ver qué nos devuelve el objeto podemos hacer un var_dump($obj)
            // así hemos sacado que $obj->repetido devolvía true o false        
            $error_codigo = $obj->repetido; // El repetido nos devuelve true o false si está o no repetido            
        }

        $error_form = $error_codigo || $error_nombre || $error_nombre_corto || $error_pvp;

        // Si no hay error en el formulario seguimos
        if (!$error_form) {

            try {
                $url = DIR_SERV . "/producto/insertar";
                $datos = array("cod" => $_POST["codigo"], "nombre" => $_POST["nombre"], "nombre_corto" => $_POST["nombre_corto"], "descripcion" => $_POST["descripcion"], "PVP" => $_POST["pvp"], "familia" => $_POST["familia"]);
                $respuesta = consumir_servicios_REST($url, "POST", $datos); // Le tenemos que pasar un array con los datos
                $obj = json_decode($respuesta);            

                if (!$obj) die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
                if (isset($obj->mensaje_error)) die("<p>".$obj->mensaje_error."</p></body></html>");                
            } catch (PDOException $e) {
                $respuesta["mensaje_error"] = "No se ha podido insertar: ".$e->getMessage();
                return $respuesta;
            }            

            // Ponemos el mensaje si insertamos y volvemos
            $_SESSION["mensaje"] = "Producto insertado con éxito";
            header("Location:index.php");
            exit;

        }

    }

    // Si le damos al botón de continuar el editar
    

    // Cuando le demos al botón volver, volvemos y eliminamos los datos
    if (isset($_POST["btnVolver"])) {
        header("Location:index.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2 - CRUD</title>
    <style>
        table{
            border-collapse: collapse;
            text-align: center;
            width: 80%;            
            margin: 0 auto;
        }

        table, td, th{
            border: 1px solid black;
            padding: 0.5rem;
        }

        .enlace{
            border: none;
            background: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        div{
            width: 80%;
            margin: 0 auto;
            margin-bottom: 1rem;
        }

        .mensaje{
            font-size: 20px;
            color: blue;                       
        }

        .error{
            color: red;
        }


    </style>
</head>
<body>
    <h1 style="text-align: center;">Listado de los productos</h1>
    <?php
                
        // Cuando demos click al botón detalle
        if (isset($_POST["btnDetalle"])) {
            $url = DIR_SERV . "/producto/".$_POST["btnDetalle"]; // Le pasamos el codigo por la url
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);

            if (!$obj) die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);      
            if (isset($obj->mensaje_error)) die("<p>".$obj->mensaje_error."</p></body></html>");
            
            echo "<div>";
            echo "<strong>COD: </strong>".$obj->producto[0]->cod."<br>"; // Al ser un fetchAll lo que usamos nos devuelve un array y tenemos que coger el 0
            echo "<strong>Nombre: </strong>".$obj->producto[0]->nombre."<br>";
            echo "<strong>Nombre corto: </strong>".$obj->producto[0]->nombre_corto."<br>";
            echo "<strong>Descripción: </strong>".$obj->producto[0]->descripcion."<br>";
            echo "<strong>PVP: </strong>".$obj->producto[0]->PVP."€<br>";
            echo "<strong>Familia: </strong>".$obj->producto[0]->familia."<br>";            
            echo "</div>";

        }

        // Cuando le das al botón borrar
        if (isset($_POST["btnBorrar"])) {
            echo "<div><form action='index.php' method='post'>";
            echo "¿Estás seguro que deseas borrar el producto con id: <strong>".$_POST["btnBorrar"]."</strong>?";
            echo "<p><button name='btnVolver'>Volver</button> ";
            echo "<button name='btnConfBorrar' value='".$_POST["btnBorrar"]."'>Borrar</button></p>";
            echo "</form></div>";
        }

        // Si le damos al botón insertar
        if (isset($_POST["btnInsertar"]) || isset($_POST["btnContInsertar"])) {
            // Para que aparezca en el select necesito obtener las familias
            $url = DIR_SERV . "/familias";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);            

            if (!$obj) die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);    
            if (isset($obj->mensaje_error)) die("<p>".$obj->mensaje_error."</p></body></html>");

            // Imprimimos los inputs para que se metan los datos
            ?>
            <div><form action='index.php' method='post'>
            <p><strong>Código</strong>: <input type='text' maxlength='12' name='codigo' value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["codigo"]; ?>">
            <?php
                if (isset($_POST["btnContInsertar"]) && $error_codigo) {
                    if ($_POST["codigo"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else if(strlen($_POST["codigo"]) > 12){
                        echo "<span class='error'>*Máx 12 carácteres*</span>";
                    } else {
                        echo "<span class='error'>*Ese código está repetido*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Nombre</strong>: <input type='text' maxlength='200' name='nombre' value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["nombre"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                    if ($error_nombre) {
                        echo "<span class='error'>*Máx 200 carácteres*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Nombre corto</strong>: <input type='text' maxlength='50' name='nombre_corto' value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["nombre_corto"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_nombre_corto) {
                    if ($_POST["nombre_corto"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Máx 50 carácteres*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Descripcion</strong>: <textarea name='descripcion'></textarea></p>
            <p><strong>PVP</strong>: <input type='number' name='pvp' value="<?php if(isset($_POST["btnContInsertar"])) echo $_POST["pvp"]; ?>">
            <?php 
                if (isset($_POST["btnContInsertar"]) && $error_pvp) {
                    if ($_POST["pvp"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*No has introducido un número*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Familia</strong>:<select name='familia' id="familia">
            <?php
            foreach ($obj->familias as $tupla) { // Por cada familia vamos a crear un option en la que aparezca el nombre
                if (isset($_POST["btnContInsertar"]) && $tupla->cod == $_POST["familia"]) {
                    echo "<option value='".$tupla->cod."' selected>".$tupla->nombre."</option>";
                } else {
                    echo "<option value='".$tupla->cod."'>".$tupla->nombre."</option>";
                }
            }
            ?>
            </select></p>
            <p><strong><button name='btnVolver'>Volver</button> 
            <button name='btnContInsertar'>Insertar</button></p>
            </form></div>
            <?php
        }

        // Si le damos al botón de editar
        if (isset($_POST["btnEditar"])) {
            
            $url = DIR_SERV . "/producto/".$_POST["btnEditar"]."";
            $respuesta = consumir_servicios_REST($url, "GET");
            $obj = json_decode($respuesta);                   

            if (!$obj) die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);    
            if (isset($obj->mensaje_error)) die("<p>".$obj->mensaje_error."</p></body></html>");
            ?>
            <div><form action='index.php' method='post'>
            <p><strong>Nombre</strong>: <input type='text' maxlength='200' name='nombre' value="<?php if(isset($_POST["btnContEditar"])) echo $_POST["nombre"]; 
                                                                                                        else{echo $obj->producto->nombre;} ?>">
            <?php 
                if (isset($_POST["btnContEditar"]) && $error_nombre) {
                    if ($error_nombre) {
                        echo "<span class='error'>*Máx 200 carácteres*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Nombre corto</strong>: <input type='text' maxlength='50' name='nombre_corto' value="<?php if(isset($_POST["btnContEditar"])) echo $_POST["nombre_corto"]; 
                                                                                                                else{echo $obj->producto->nombre_corto;}?>">
            <?php 
                if (isset($_POST["btnContEditar"]) && $error_nombre_corto) {
                    if ($_POST["nombre_corto"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*Máx 50 carácteres*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Descripcion</strong>: <textarea name='descripcion'></textarea></p>
            <p><strong>PVP</strong>: <input type='number' name='pvp' value="<?php if(isset($_POST["btnContEditar"])) echo $_POST["pvp"];
                                                                                    else{echo $obj->producto->PVP;} ?>">
            <?php 
                if (isset($_POST["btnContEditar"]) && $error_pvp) {
                    if ($_POST["pvp"] == "") {
                        echo "<span class='error'>*Campo obligatorio*</span>";
                    } else {
                        echo "<span class='error'>*No has introducido un número*</span>";
                    }
                }
            ?>
            </p>
            <p><strong>Familia</strong>:<select name='familia' id="familia">
            <?php
            foreach ($obj->familias as $tupla) { // Por cada familia vamos a crear un option en la que aparezca el nombre
                if (isset($_POST["btnContEditar"]) && $tupla->cod == $_POST["familia"]) {
                    echo "<option value='".$tupla->cod."' selected>".$tupla->nombre."</option>";
                } else {
                    echo "<option value='".$tupla->cod."'>".$tupla->nombre."</option>";
                }
            }
            ?>
            </select></p>
            <p><strong><button name='btnVolver'>Volver</button> 
            <button name='btnContEditar'>Editar</button></p>
            </form></div>
            <?php
        }

        // Si hemos puesto algún mensaje en la sesión lo imprimimos, y unseteamos la session
        if (isset($_SESSION["mensaje"])) {
            echo "<div class='mensaje'>".$_SESSION["mensaje"]."</div>";
            unset($_SESSION["mensaje"]);
        }
                
        // Cogemos los datos para imprimir la tabla
        $url = DIR_SERV . "/productos";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj) die("<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta);
        if (isset($obj->mensaje_error)) die("<p>".$obj->mensaje_error."</p></body></html>");

        // Imprimimos la tabla
        echo "<table>";
        echo "<tr><th>COD</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' name='btnInsertar'>Producto+</button></form></th></tr>";
        foreach ($obj->productos as $tupla) {            
            echo "<tr><form action='index.php' method='post'>";
            echo "<td><button class='enlace' name='btnDetalle' value='".$tupla->cod."'>".$tupla->cod."</button></td>";
            echo "<td>".$tupla->nombre_corto."</td>";
            echo "<td>".$tupla->PVP."</td>";
            echo "<td><button class='enlace' name='btnBorrar' value='".$tupla->cod."'>Borrar</button> - <button class='enlace' name='btnEditar' value='".$tupla->cod."'>Editar</button></td>";
            echo "</form></tr>";
        }
        echo "</table>";        

        

    ?>
</body>
</html>