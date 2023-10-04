<?php

function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1); // Esto devuelve la letra correcta si le metes los números de un dni
}

function dni_bien_escrito($texto)
{ // Comprobamos, que tenga 9 carácteres, que los 8 primeros sean números y el último sea una letra
    return strlen($texto) == 9 && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
}

function dni_valido($texto)
{
    $numero = substr($texto, 0, 8);
    $letra = substr($texto, -1);
    $valido = LetraNIF($numero) == $letra;
    return $valido; // es lo mismo que return LetraNIF(substr($texto, 0, 8)) == substr($texto, -1)
}

?>
