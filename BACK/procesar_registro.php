<?php 
session_start();

// Configuración de la base de datos

/*
$hostname = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";
*/

$hostname = "192.168.1.50";
$username = "bd-manager";
$password = "mBdi4#32";
$database = "draftosaurus";

try {
    // Primero conectar sin especificar la base de datos para poder crearla
    $conn = mysqli_connect($hostname, $username, $password);
    if (!$conn) {
        die('Fallo la conexión inicial: ' . mysqli_connect_error());
    }
    
    // Verificar que se recibieron los datos del formulario
    if (!isset($_POST["nombre"]) || !isset($_POST["password"])) {
        die("Error: No se recibieron los datos del formulario");
    }
    
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $password_raw = $_POST["password"];
    $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
    
    // Usar prepared statements para mayor seguridad
    $stmt = mysqli_prepare($conn, "INSERT INTO draftosaurus.usuario (nombre, password) VALUES (?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $password_hash);
        
        if (mysqli_stmt_execute($stmt)) {
            $id = mysqli_insert_id($conn);
            $_SESSION["ID"] = $id;
            $_SESSION["Nombre"] = $nombre;
            
            echo "Usuario registrado exitosamente con ID: $id<br>";
            
            // Cerrar statement y conexión antes de redirigir
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error al insertar usuario: " . mysqli_stmt_error($stmt);
        }
        
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparando consulta: " . mysqli_error($conn);
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
} finally {
    // Asegurar que la conexión se cierre
    if (isset($conn) && $conn) {
        mysqli_close($conn);
    }

}
?>
