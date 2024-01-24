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
        if (isset($_POST["btnInsertar"])) {
            echo "<div><form action='index.php' method='post'>";
            echo "<p>Código: <input type='text' name='codigo'></p>";
            echo "<p><button name='btnVolver'>Volver</button> ";
            echo "<button name='btnContInsertar'>Insertar</button></p>";
            echo "</form></div>";
        }

        // Si hemos puesto algún mensaje en la sesión lo imprimimos
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
            echo "<td><button class='enlace' name='btnBorrar' value='".$tupla->cod."'>Borrar</button> - <button class='enlace' name='btnEditar'>Editar</button></td>";
            echo "</form></tr>";
        }
        echo "</table>";        

        

    ?>
</body>
</html>