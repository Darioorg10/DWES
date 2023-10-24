<?php 

function mi_strlen($texto){
    $contador = 0;
    while (isset($texto[$contador])) {
        $contador++;
    }
    return $contador;
}

function mi_explode($separador, $texto){
    // $aux = array(); Esto es lo mismo que $aux = [];
    $aux = [];        
    $longitud_texto = mi_strlen($texto);
    $i = 0;
    while ($i < $longitud_texto && $texto[$i] == $separador) { // Esto sirve para quitar los separadores si hay en el principio
        $i++;
    }

    if ($i < $longitud_texto) { // Si ya viendo los separadores del principio no hemos terminado todavía
        $j = 0;
        $aux[$j] = $texto[$i];
        for ($i=$i+1; $i < $longitud_texto; $i++) {
            if ($texto[$i] != $separador) { // Si no es un separador le concatenamos la siguiente letra/carácter
                $aux[$j].=$texto[$i];
            } else {
                while ($i < $longitud_texto && $texto[$i] == $separador) { // Si estamos en un separador vamos avanzado hasta que no sea un separador o hasta el final
                    $i++;                        
                }

                if ($i < $longitud_texto) {
                    $j++;    
                    $aux[$j] = $texto[$i];
                }
                
            }
        }
    }

    return $aux;
}

function quitarElemento($palabra, $indice){
    $nueva_palabra = "";
    for ($i=0; $i < mi_strlen($palabra); $i++) { 
        if ($indice != $i){
            $nueva_palabra .= $palabra[$i];
        }
    }
    return $nueva_palabra;
}

?>