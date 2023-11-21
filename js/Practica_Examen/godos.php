<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$myJSON ='{"reyesgodos":[{"nombre":"Alarico","hijos":["Atanagildo","Leovigildo",{"nombre":"RecaredoI","hijos":["Sisebuto","RecaredoII",{"nombre":"Suintila","hijos":["Chindasvinto","Recesvinto","Wamba","Égica","Witiza","Rodrigo"]}]},"Sisenando","Chintila"]},"Witerico","Gundemaro"]}';
echo $myJSON;
?>