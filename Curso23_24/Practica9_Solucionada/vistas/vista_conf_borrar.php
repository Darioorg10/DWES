<!-- html que muestra lo que se vería al pulsar el borrar -->
<form action="index.php" method="post">
    <p>Se dispone usted a borrar la película con id= <?php echo $_POST["btnBorrar"] ?> </p>
    <p>
        <input type="hidden" name="foto" value="<?php echo $_POST["foto"] ?>">
        <button type="submit" name="btnContBorrar" value="<?php echo $_POST["btnBorrar"] ?>">Continuar</button>
        <button type="submit" name="btnVolver">Atrás</button>
    </p>
</form>