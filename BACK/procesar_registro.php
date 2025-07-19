<?php 
session_start();
// Conexión a la base de datos
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'registro_jugadores';

$conn = mysqli_connect($hostname, $username, $password, $database);
if (!$conn) {
    die('Fallo la conexión: ' . mysqli_connect_error());
}
  $nombre = $_POST["nombre"];

$query = "INSERT INTO registro_jugadores.jugadores (nombre) 
          VALUES ('$nombre')";
$result = mysqli_query($conn, $query);

$id = mysqli_insert_id($conn);
$_SESSION["ID"] = $id;
$_SESSION["Nombre"] = $nombre;;

 header("Location: ../FRONT/version.php");
        exit();
?>

<!--
CREATE DATABASE registro_jugadores;

CREATE TABLE jugadores( id INT AUTO_INCREMENT PRIMARY KEY, nombre VARCHAR(100) NOT NULL);

#Esto es el codigo para crear la base de datos del registro, NO BORRAR COMENTARIO. ATT: Barril de tuco#
-->
