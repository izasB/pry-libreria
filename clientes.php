<?php
    ini_set('output_buffering', 'On'); 
    //inicio de la sesión al cargar la página.
    session_start();
    include "functions.php";
    if(isset($_POST["insertClient"])) {
        if (($_POST["clientName"]!="")&&($_POST["surname"]!="")) {
            //Si está el nombre y apellido del cliente, se añade a la tabla.
            insertClient($_POST["clientName"],$_POST["surname"]);
            header("Refresh:0");
        } else {
            //Si no se introducen ambos, pone un error.
            echo "<script>alert('error: Debe introducir el nombre y apellido.')</script>";
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
    <h1>Gestión clientes - <?php echo $_SESSION["logonUser"] ?></h1>
    <form action="clientes.php" method="POST">
        <label>Nombre: </label>
        <input type="text" name="clientName">
        <label>Apellido: </label>
        <input type="text" name="surname">
        <br>
        <input type="submit" name="insertClient" value="Insertar cliente">
    </form>
    <table class="bookTable">
        <th>id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <?php showClients(); ?>
    </table>
    <?php
        }
    ?>
</body>
</html>