<?php
    //inicio de la sesión al cargar la página.
    session_start();
    include "functions.php";
    //control de qué botón se ha presionado.
    if(isset($_POST["insertBook"])) {
        if ((checkBookData($_POST["ISBN"],$_POST["title"],$_POST["price"]))&&(!checkISBN($_POST["ISBN"]))) {
            //Inserta el libro y refresca la página para que se vean los cambios.
            insertBook($_POST["ISBN"],$_POST["title"],$_POST["price"]);
            header("Refresh:0");
        } else {
            //Si los datos introducidos son incorrectos, muestra una alerta.
            echo "<script>alert('error: Los datos introducidos son incorrectos.')</script>";
        }
    } elseif(isset($_POST["calcTotal"])) {
        //Muestra una ventana emergente con el precio total de los libros.
        totalPrice();
    } elseif(isset($_GET["isbn"])) {
        //Borra el libro y redirige al índice para que se vean los cambios al instante.
        deleteBook($_GET["isbn"]);
        header("Location:index.php"); 
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
    <h1>Gestión Librería - <?php echo $_SESSION["logonUser"] ?></h1>
    <form action="index.php" method="POST">
        <label>ISBN: </label>
        <input type="text" name="ISBN">
        <label>Título: </label>
        <input type="text" name="title">
        <label>Precio en tienda: </label>
        <input type="text" name="price">
        <br>
        <input type="submit" name="insertBook" value="Insertar">
        <input type="submit" name="calcTotal" value="Calcular precio total">
    </form>
    <table class="bookTable">
        <th>ISBN</th>
        <th>Título</th>
        <th>Precio en tienda</th>
        <th>Borrar</th>
        <?php showBooks(); ?>
    </table>
    <?php
        }
    ?>
</body>
</html>