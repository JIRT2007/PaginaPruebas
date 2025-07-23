<?php 
session_start();

// Configuración de la base de datos
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'registro_jugadores';

try {
    // Primero conectar sin especificar la base de datos para poder crearla
    $conn_temp = mysqli_connect($hostname, $username, $password);
    if (!$conn_temp) {
        die('Fallo la conexión inicial: ' . mysqli_connect_error());
    }
    
    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS $database";
    if (mysqli_query($conn_temp, $sql)) {
        echo "Base de datos '$database' verificada/creada con éxito<br>";
    } else {
        echo "Error creando base de datos: " . mysqli_error($conn_temp) . "<br>";
    }
    
    // Cerrar conexión temporal
    mysqli_close($conn_temp);
    
    // Ahora conectar a la base de datos específica
    $conn = mysqli_connect($hostname, $username, $password, $database);
    if (!$conn) {
        die('Fallo la conexión a la base de datos: ' . mysqli_connect_error());
    }
    
    // Crear la tabla si no existe
    $sql = "CREATE TABLE IF NOT EXISTS jugadores( 
                          id INT AUTO_INCREMENT PRIMARY KEY, 
                          nombre VARCHAR(100) NOT NULL, 
                          password VARCHAR(255) NOT NULL
                          )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Tabla 'jugadores' verificada/creada con éxito<br>";
    } else {
        echo "Error creando tabla: " . mysqli_error($conn) . "<br>";
    }
    
    // Verificar que se recibieron los datos del formulario
    if (!isset($_POST["nombre"]) || !isset($_POST["password"])) {
        die("Error: No se recibieron los datos del formulario");
    }
    
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $password_raw = $_POST["password"];
    $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
    
    // Usar prepared statements para mayor seguridad
    $stmt = mysqli_prepare($conn, "INSERT INTO jugadores (nombre, password) VALUES (?, ?)");
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
            
            header("Location: ../FRONT/ConfiguracionPartida.php");
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