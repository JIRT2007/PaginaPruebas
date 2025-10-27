<?php
session_start();

// Configuración de la base de datos
$hostname = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";

try {
    $conn = new mysqli($hostname, $username, $password, $database);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = trim($_POST["nombre"]);
        $password = trim($_POST["password"]);

        // Buscar usuario
        $stmt = $conn->prepare("SELECT ID_Usuario, nombre, password FROM usuario WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $usuario = $resultado->fetch_assoc();

            // Verificar contraseña con hash
            if (password_verify($password, $usuario["password"])) {
                $_SESSION["ID"] = $usuario["ID_Usuario"];
                $_SESSION["Nombre"] = $usuario["nombre"];

                // Redirigir a la página de partidas del usuario
                header("Location: ../FRONT/MisPartidas.php");
                exit();
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado. Debes registrarte primero.";
        }
        
        // Si hay error, redirigir de vuelta con mensaje
        if (isset($error)) {
            $_SESSION["error_login"] = $error;
            header("Location: ../FRONT/RegistroPartidas.php");
            exit();
        }
        
        $stmt->close();
    }

} catch (Exception $e) {
    $_SESSION["error_login"] = "Error del sistema: " . $e->getMessage();
    header("Location: ../FRONT/RegistroPartidas.php");
    exit();
} finally {
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>
