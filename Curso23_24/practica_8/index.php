<?php 
    require "const_y_funciones.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
    <style>
        table, td, th{
            border: 1px solid black;            
        }        

        table{
            border-collapse: collapse;
            text-align: center;
            width: 90%;
        }

        td{
            padding: 1rem;
        }

        th{
            background-color: #CCC;
        }

        img{
            width: 50px;
            height: 50px;
        }               
        
        .enlace{
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline;
        }

        .error{
            color:red
        }
    </style>
</head>
<body>    
    <h1>Práctica 8</h1>
    <h3>Listado de los usuarios</h3>
    <?php     

        // Mostramos la tabla conectandonos a la base de datos   
        require "vistas/vista_tabla.php";
        
        // Si se pulsa un nombre mostramos los datos
        if (isset($_POST["btnListar"])) {            
            require "vistas/vista_listar.php";
        } else if(isset($_POST["btnInsertar"])){                                  
            require "vistas/vista_insertar.php";
        } else if(isset($_POST["btnBorrar"])){
            require "vistas/vista_borrar.php";
        }

        mysqli_close($conexion);

    ?>    
</body>
</html>