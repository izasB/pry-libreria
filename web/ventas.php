<?php
    ini_set('output_buffering', 'On'); 
    //inicio de la sesión al cargar la página.
    session_start();

    include "functions.php";
    if(isset($_POST["insertSale"])) {
        //Si ambos números son mayores a 0, y no está la id del ejemplar ya en la tabla de ventas.
        if (($_POST["idCopy"]>0)&&($_POST["idClient"]>0)&&(!checkSale($_POST["idCopy"]))&&(checkClient($_POST["idClient"]))) {
            //Si existe el ISBN y se introduce un número mayor a 0, se inserta en la tabla de ejemplares.
            insertSale($_POST["idCopy"],$_POST["idClient"]);
            header("Refresh:0");
        } else {
            //Si no se introducen adecuadamente los datos.
            echo "<script>alert('error: Datos introducidos incorrectos.')</script>";
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
    <h1>Gestión ventas - <?php echo $_SESSION["logonUser"] ?></h1>
    <p>Escriba la id del ejemplar comprado y la id del cliente</p>
    <form action="ventas.php" method="POST">
        <label>ID ejemplar: </label>
        <input type="number" name="idCopy" placeholder=0>
        <label>ID cliente: </label>
        <input type="number" name="idClient" placeholder=0>
        <br>
        <input type="submit" name="insertSale" value="Insertar venta">
    </form>
    <table class="bookTable">
        <th>id ejemplar</th>
        <th>id cliente</th>
        <th>fecha compra</th>
        <?php showSale(); ?>
    </table>
    <?php
        }
    ?>
</body>
</html>
