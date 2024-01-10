<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6 POO</title>
</head>
<body>
    <h1>Ejercicio 6 POO</h1>
    <?php 

        require "Menu.php";
        $m = new Menu();
        $m->cargar("https:/www.google.es", "Google");
        $m->cargar("https:/www.youtube.es", "Youtube");
        $m->cargar("https:/www.maralboran.eu", "Mar de alborán");
        $m->vertical();
        $m->horizontal();

    ?>
</body>
</html>