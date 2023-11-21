<?php

// mysqli_insert_id($conexion) te da el último id de la última inserción
// que se ha hecho en la base de datos

$con = mysqli_connect("localhost","my_user","my_password","my_db");

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}

mysqli_query($con, "INSERT INTO Persons (FirstName, LastName, Age) VALUES ('Glenn', 'Quagmire', 33)");

// Print auto-generated id
echo "New record has id: " . mysqli_insert_id($con);

mysqli_close($con);

// Si queremos tener argumentos variables en una función
function repetido($p1, $p2=null, $p3=null){
  if (isset($p2)) {
    // Código incluyendo los parámetros $p2 y $p3
  } else {
    // Código sin incluir los parámetros $p2 y $p3
  }
}

?>

<!-- el unlink para las imágenes de los que se han borrado -->