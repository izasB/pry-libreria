<?php
    //inicio de la sesión al cargar la página.
    session_start();
    include "functions.php";
    if(isset($_POST["insertCopy"])) {
    if ((checkISBN($_POST["ISBN"]))&&($_POST["copyNumber"]>0)) {
        //Si existe el ISBN y se introduce un número mayor a 0, se inserta en la tabla de ejemplares.
        insertCopy($_POST["ISBN"],$_POST["copyNumber"]);
        header("Refresh:0");
    } else {
        //Si no se introducen ambos, pone un error.
        echo "<script>alert('error: Debe introducir un ISBN existente y un número mayor a 0.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería - Izas Buil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
        //Si no hay sesión iniciada, no se accede a la página.
        if(!isset($_SESSION["logonUser"])){
            echo "<h1>Sesión no iniciada</h1>";
        } else {
    ?>
    <div class="nav">
    <a href="index.php">índice</a><a href="clientes.php">Gestionar clientes</a><a href="ejemplares.php">Gestionar ejemplares</a><a href="ventas.php">Gestionar ventas</a>
    </div>
    <h1>Gestión ejemplares - <?php echo $_SESSION["logonUser"] ?></h1>
    <p>Escriba el ISBN del libro y el número de ejemplares que quiera añadir</p>
    <form action="ejemplares.php" method="POST">
        <label>ISBN: </label>
        <input type="text" name="ISBN">
        <label>Número ejemplares: </label>
        <input type="number" name="copyNumber" placeholder=0>
        <br>
        <input type="submit" name="insertCopy" value="Insertar ejemplares">
    </form>
    <table class="bookTable">
        <th>id</th>
        <th>ISBN</th>
        <?php showCopy(); ?>
    </table>
    <?php
        }
    ?>
</body>
</html>
