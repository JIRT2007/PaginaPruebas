<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Configuración base de datos

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

// Conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST["nombre"]);
    $pass   = trim($_POST["password"]);

    // Buscar usuario
    $stmt = $conn->prepare("SELECT ID_Usuario, nombre, password FROM usuario WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar contraseña con hash
        if (password_verify($pass, $usuario["password"])) {
            $_SESSION["ID"] = $usuario["ID_Usuario"];
            $_SESSION["Nombre"] = $usuario["nombre"];

            header("Location: ../FRONT/ConfiguracionPartida.php");
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        // Usuario no registrado
        $error = "Debes registrarte antes de iniciar sesión.";
    }
    echo $error;
    $stmt->close();
}

$conn->close();
?>
