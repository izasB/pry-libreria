<?php
    /*
        Fichero de la instalación de la base de datos.

        Este fichero crea la base de datos de la tienda de libros, y crea las tablas user y book.
        User contendrá la información de los usuarios y book la de los libros.

        Este fichero se debería borrar una vez ejecutado por seguridad.
   */ 
    $databaseIP="";
    $databaseUser="";
    $databasePass="";
    $databaseName="";
    //Inicio de la conexión al SGBD.
    $connection = mysqli_connect($databaseIP,$databaseIP,$databaseIP);

    if (!$connection) {
        echo "<p> Ha habido un error con la conexión al sistema gestor de bases de datos </p>";
    } else {
        //Si se ha conectado correctamente, crea la base de datos de la tienda de libros.
        $sql = "CREATE DATABASE IF NOT EXISTS tiendalibros;";
        mysqli_query($connection,$sql);
        mysqli_close($connection);

        //Conexión a la base de datos de la tienda de libros.
        $connection = mysqli_connect($databaseIP,$databaseIP,$databaseUser,$databaseName);
        if (!$connection) {
            echo "<p> Ha habido un error al conectarse a la base de datos </p>";
        } else {
            //Si hay conexión a la base de datos de la tienda de libros, crea la tabla de los usuarios.
            $sql = "CREATE TABLE IF NOT EXISTS user (
                    userId INT NOT NULL AUTO_INCREMENT ,
                    userName VARCHAR(20) NOT NULL , 
                    userPass VARCHAR(50) NOT NULL , 
                    PRIMARY KEY (userId) ,
                    UNIQUE (userName));";
            mysqli_query($connection,$sql);

            //Crea un usuario por defecto.
            $sql = "INSERT INTO user VALUES (NULL,'Izas','Alu-in2a');";
            mysqli_query($connection,$sql);

            //Creación de la tabla de libros.
            $sql = "CREATE TABLE IF NOT EXISTS book (
                    ISBN VARCHAR(13) NOT NULL ,
                    title VARCHAR(30) NOT NULL ,
                    price INT(3) NOT NULL ,
                    PRIMARY KEY (ISBN));";
            mysqli_query($connection,$sql);
            
            //Creación de la tabla de ejemplares.
            $sql = "CREATE TABLE IF NOT EXISTS bookCopy (
                idCopy INT AUTO_INCREMENT PRIMARY KEY ,
                ISBN VARCHAR(13) NOT NULL ,
                FOREIGN KEY (ISBN) REFERENCES book(ISBN) ON DELETE CASCADE);";
            mysqli_query($connection,$sql);

            //Creación de la tabla de clientes.
            $sql = "CREATE TABLE IF NOT EXISTS client (
                idClient INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(30) NOT NULL,
                surname VARCHAR(30) NOT NULL);";
            mysqli_query($connection,$sql);

            //Creación de la tabla de ventas
            $sql = "CREATE TABLE IF NOT EXISTS sales (
                idCopy INT NOT NULL ,
                idClient INT NOT NULL ,
                saleDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
                PRIMARY KEY (idCopy, idClient) ,
                FOREIGN KEY (idCopy) REFERENCES bookCopy(idCopy) ON DELETE CASCADE ,
                FOREIGN KEY (idClient) REFERENCES client(idClient) ON DELETE CASCADE);";
            mysqli_query($connection,$sql);

            //Cierre de la conexión con la base de datos
            mysqli_close($connection);
        }
    }
?>
