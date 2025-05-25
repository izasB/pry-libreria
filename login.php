<?php
    //inicio de la sesión al cargar la página.
    session_start();
    //Si hay una cookie previa, asigna el valor del usuario a ella. Si no, se inicia vacía
    if(isset($_COOKIE["logonUser"])){
        $logonUser = $_COOKIE["logonUser"];
    } else $logonUser = "";
    
    if (isset($_POST["loginButton"])) {
        include "functions.php";
        //si el usuario es correcto, guarda una cookie con su nombre y redirige a la página principal.
        //También guarda en la sesión el nombre del usuario.
        if (checkLogin($_POST["username"],$_POST["passwd"])) {
            setcookie("logonUser",$_POST["username"],time()+3600*24);
            $_SESSION["logonUser"] = $_POST["username"];
            
            header("Location:index.php"); 
        } else {
            echo "<h1 style='color:red;text-align: center;'>Las credenciales introducidas son incorrectas</h1>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="login.php" method="POST" class="loginForm">
        <label> Nombre de usuario </label>
        <input type="text" name="username" value="<?php echo $logonUser; //Imprime el valor del usuario loggeado o vacío si no hay cookie ?>">
        <br>
        <label> Contraseña </label>
        <input type="password" name="passwd">
        <br>
        <input type="submit" name="loginButton" value="Login">
    </form>
</body>
</html>