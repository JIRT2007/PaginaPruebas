<?php
session_start();

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

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['nombre'];
    $password = $_POST['password'];

    // Buscar al administrador por nombre
    $sql = "SELECT * FROM administrador WHERE Nombre = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $admin = $resultado->fetch_assoc();

        // Comparar contraseñas
        if ($password === $admin['Password']) {
            // Login correcto: guardar sesión y redirigir
            $_SESSION['admin'] = $admin['Nombre'];
            header("Location: ../FRONT/Administrador.php"); // revisa que exista exactamente
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href='../FRONT/login_administrador.php';</script>";
        }
    } else {
        echo "<script>alert('Administrador no encontrado'); window.location.href='../FRONT/login_administrador.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
