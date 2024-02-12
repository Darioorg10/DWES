<?php 

        // Aquí mostramos los libros
        $url = DIR_SERV."/obtener_libros";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);

        if (!$obj) {
            session_destroy();
            die(error_page("Librería", "Error consumiendo el servicio: $obj"));
        }

        if (isset($obj->error)) {
            session_destroy();
            die(error_page("Librería", "Error consumiendo el servicio: ".$obj->error.""));
        }

        echo "<div id='libros'>";        
        foreach ($obj->libros as $tupla) {
            echo "<div>";
            echo "<img src='images/".$tupla->portada."' title='".$tupla->titulo."' alt='".$tupla->portada."'>";
            echo "<p>".$tupla->titulo." - ".$tupla->precio."€</p>";
            echo "</div>";
        }                
        echo "</div>";

?>