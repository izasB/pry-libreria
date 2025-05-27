<?php
    /*
        Script de funciones para la página de la tienda de libros.
    */
    $databaseIP="";
    $databaseUser="";
    $databasePass="";
    $databaseName="";

    //Recibe la información introducida en el formulario de login.
    //Si es correcta, devuelve true. Si no, devuelve false.
    function checkLogin($name,$password) {
        //Conexión a la base de datos de la tienda de libros.
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if (!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else {
            //Si se ha conectado a la base de datos, prepara la consulta SQL.
            //Los nombres son únicos, así que si el nombre y la contraseña son correctos sólo encontrará un registro.
            //Si no lo encuentra, el login será inválido.
            $sql = "SELECT userName FROM user WHERE userName = ? AND userPass = ?;";
            $statement = mysqli_prepare($connection,$sql);

            mysqli_stmt_bind_param($statement,"ss",$name,$password);
            mysqli_stmt_execute($statement);

            //Guarda el valor antes de cerrar la sesión y la sentencia.
            //Si se ha encontrado un registro, fetch será true. Si no, será false.
            $result = mysqli_stmt_fetch($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);

            return $result;
        }
    }

    //Recibe los datos de un libro y los añade a la base de datos.
    //La función comprueba que no se haya introducido un libro repetido mediante el ISBN.
    function insertBook($ISBN,$title,$price) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //si el ISBN ya estaba, muestra un error.
            if(checkISBN($ISBN)) {
                echo "<script>alert('error: el libro introducido ya existe en el sistema.')</script>";
            } else {
                //Si el ISBN no estaba, añade el libro a la base de datos.                
                //Prepración de la sentencia.
                $sql = "INSERT INTO book VALUES(?,?,?);";
                $statement = mysqli_prepare($connection,$sql);
                
                //Inserción de datos y ejecución de la sentencia.
                mysqli_stmt_bind_param($statement,"ssi",$ISBN,$title,$price);
                mysqli_stmt_execute($statement);

                mysqli_stmt_close($statement);
                mysqli_close($connection);
            }

        }
    }

    //inserta los clientes en la tabla de clientes.
    function insertClient($clientName,$surname) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else {          
            //Prepración de la sentencia.
            $sql = "INSERT INTO client VALUES(NULL,?,?);";
            $statement = mysqli_prepare($connection,$sql);
                
            //Inserción de datos y ejecución de la sentencia.
            mysqli_stmt_bind_param($statement,"ss",$clientName,$surname);
            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }

    //inserta los X número de ejemplares de un ISBN dado.
    function insertCopy($ISBN,$copyNumber) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else {          
            //Prepración de la sentencia.
            for ($i=1;$i<=$copyNumber;$i++){
                $sql = "INSERT INTO bookCopy VALUES(NULL,?);";
                $statement = mysqli_prepare($connection,$sql);
                
                //Inserción de datos y ejecución de la sentencia.
                mysqli_stmt_bind_param($statement,"s",$ISBN);
                mysqli_stmt_execute($statement);
            }   
            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Inserta una id de un ejemplar y la del cliente que la compra.
    function insertSale($idCopy,$idSale) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else {          
            //Prepración de la sentencia.
            $sql = "INSERT INTO sales VALUES(?,?,NULL);";
            $statement = mysqli_prepare($connection,$sql);
                
            //Inserción de datos y ejecución de la sentencia.
            mysqli_stmt_bind_param($statement,"ii",$idCopy,$idSale);
            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Recibe el ISBN de un libro, si está en la base de datos devuelve true.
    function checkISBN($ISBN) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT ISBN FROM book WHERE ISBN = ?;";
            $statement = mysqli_prepare($connection,$sql);

            //Inserción de datos y ejecución.
            mysqli_stmt_bind_param($statement,"s",$ISBN);
            mysqli_stmt_execute($statement);

            //Guarda el resultado del fetch para cerrar la conexión y la consulta.
            $result = mysqli_stmt_fetch($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);

            return $result;
        }
    }
    //Recibe un número de ejemplar, si ha sido comprado, devuelve true.
    function checkSale($idCopy) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT idCopy FROM sales WHERE idCopy = ?;";
            $statement = mysqli_prepare($connection,$sql);

            //Inserción de datos y ejecución.
            mysqli_stmt_bind_param($statement,"i",$idCopy);
            mysqli_stmt_execute($statement);

            //Guarda el resultado del fetch para cerrar la conexión y la consulta.
            $result = mysqli_stmt_fetch($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);

            return $result;
        }
    }
    //Recibe un id del cliente, si existe, devuelve true.
    function checkClient($idClient) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT idClient FROM client WHERE idClient = ?;";
            $statement = mysqli_prepare($connection,$sql);

            //Inserción de datos y ejecución.
            mysqli_stmt_bind_param($statement,"i",$idClient);
            mysqli_stmt_execute($statement);

            //Guarda el resultado del fetch para cerrar la conexión y la consulta.
            $result = mysqli_stmt_fetch($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);

            return $result;
        }
    }
    //Muestra la información de los libros en la tabla.
    function showBooks() {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT * FROM book;";
            $statement = mysqli_prepare($connection,$sql);

            //Ejecución de la sentencia.
            mysqli_stmt_execute($statement);

            //Preparación de los resultados obtenidos por la consulta.
            mysqli_stmt_bind_result($statement,$ISBN,$title,$price);

            //mientras haya alguna consulta, añade un registro a la tabla.
            while(mysqli_stmt_fetch($statement)) {
                ?>
                    <tr>
                        <td><?php echo $ISBN; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><a href="http://localhost/index.php?isbn=<?php echo $ISBN ?>">Borrar</a></td>
                    </tr>
                <?php
            }

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Muestra la información de los libros en la tabla.
    function showClients() {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT * FROM client;";
            $statement = mysqli_prepare($connection,$sql);

            //Ejecución de la sentencia.
            mysqli_stmt_execute($statement);

            //Preparación de los resultados obtenidos por la consulta.
            mysqli_stmt_bind_result($statement,$id,$clientName,$surname);

            //mientras haya alguna consulta, añade un registro a la tabla.
            while(mysqli_stmt_fetch($statement)) {
                ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $clientName; ?></td>
                        <td><?php echo $surname; ?></td>
                    </tr>
                <?php
            }

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Muestra la información de los libros en la tabla.
    function showCopy() {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT * FROM bookCopy;";
            $statement = mysqli_prepare($connection,$sql);

            //Ejecución de la sentencia.
            mysqli_stmt_execute($statement);

            //Preparación de los resultados obtenidos por la consulta.
            mysqli_stmt_bind_result($statement,$id,$ISBN);

            //mientras haya alguna consulta, añade un registro a la tabla.
            while(mysqli_stmt_fetch($statement)) {
                ?>
                    <tr>
                        <td><?php echo $id; ?></td>
                        <td><?php echo $ISBN; ?></td>
                    </tr>
                <?php
            }

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Muestra la información de los libros en la tabla.
    function showSale() {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT * FROM sales;";
            $statement = mysqli_prepare($connection,$sql);

            //Ejecución de la sentencia.
            mysqli_stmt_execute($statement);

            //Preparación de los resultados obtenidos por la consulta.
            mysqli_stmt_bind_result($statement,$idCopy,$idClient,$date);

            //mientras haya alguna consulta, añade un registro a la tabla.
            while(mysqli_stmt_fetch($statement)) {
                ?>
                    <tr>
                        <td><?php echo $idCopy; ?></td>
                        <td><?php echo $idClient; ?></td>
                        <td><?php echo $date; ?></td>
                    </tr>
                <?php
            }

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }
    //Recibe un ISBN y borra el libro correspondiente.
    function deleteBook($ISBN) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "DELETE FROM book WHERE ISBN = ?;";
            $statement = mysqli_prepare($connection,$sql);

            //Inserción de datos y ejecución.
            mysqli_stmt_bind_param($statement,"s",$ISBN);
            mysqli_stmt_execute($statement);

            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }

    //Recibe los datos insertados por el usuario en el formulario, si son incorrectos muestra una alerta.
    function checkBookData($ISBN,$title,$price) {
        //Supongo que un libro es válido si:
        //   1. Su ISBN es de 13 carácteres.
        //   2. Su título no está vacío.
        //   3. Su precio es mayor a 0 y es numérico.
        if((strlen($ISBN) == 13)&&(strlen($title) > 1)&&($price > 0)&&(is_numeric($price))) {
            return true;
        } else {
            return false;
        }
    }

    //Calcula el precio total de los libros y lo muestra en una ventana emergente.
    function totalPrice() {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            //Prepración de la sentencia.
            $sql = "SELECT price FROM book;";
            $statement = mysqli_prepare($connection,$sql);

            //Ejecución de la sentencia.
            mysqli_stmt_execute($statement);

            //Preparación de los resultados obtenidos por la consulta.
            mysqli_stmt_bind_result($statement,$price);

            $totalPrice = 0;
            while(mysqli_stmt_fetch($statement)) {
                $totalPrice+=$price;
            }
            echo "<script>alert('Precio total de los libros: $totalPrice.')</script>";
            
            mysqli_stmt_close($statement);
            mysqli_close($connection);
        }
    }

    //Recibe un precio y muestra por la consola del navegador todos los libros que tengan ese mismo precio.
    function searchByPrice($price) {
        $connection = mysqli_connect($databaseIP,$databaseUser,$databasePass,$databaseName);
        if(!$connection) {
            echo "<p>Ha habido un error al conectarse a la base de datos</p>";
        } else { 
            $found = false;
            $sql = "SELECT ISBN, title FROM book WHERE price = ?;";
            $statement = mysqli_prepare($connection,$sql);

            mysqli_stmt_bind_param($statement,"i",$price);
            mysqli_stmt_execute($statement);

            mysqli_stmt_bind_result($statement,$ISBN,$title);
            while(mysqli_stmt_fetch($statement)) {
                echo "<script>console.log('El libro $title con ISBN $ISBN tiene precio de $price')</script>";
                ?>
                    <tr>
                        <td><?php echo $ISBN; ?></td>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><a href="http://localhost/proyecto/index.php?isbn=<?php echo $ISBN ?>">Borrar</a></td>
                    </tr>
                <?php
                $found = true;
            }
            if (!$found) {
                echo "<script>console.log('No hay ningún libro con precio de $price')</script>";
            }
        }
    }
?>
