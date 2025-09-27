<?php
session_start();

// Verifica si el admin está logueado
if (!isset($_SESSION['admin'])) {
    header("Location: login_administrador.php");
    exit();
}


$hostname = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";

/*
$hostname = "192.168.1.50";
$username = "bd-manager";
$password = "mBdi4#32";
$database = "draftosaurus";
*/

// Conexión directa
$con = mysqli_connect($hostname, $username, $password, $database);
if (!$con) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Eliminar usuario si se recibe el parámetro
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM usuario WHERE ID_Usuario = $id";
    mysqli_query($con, $sql);
    header("Location: Administrador.php");
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT ID_Usuario, nombre FROM usuario";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RECURSOS/CSS/style_admin.css">
    <title>Administrador</title>
    <style>
        body {
            background-image: url('../RECURSOS/IMAGENES/WallpaperAdmin.png');
            background-size: cover;
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center;
        }
    </style>
</head>
<body>
    <div class="PanelAdmin">
        <h1>Panel de Administrador</h1>
        <p>Bienvenido, administrador. Aquí puedes gestionar el sistema.</p>
        
        <h2>Usuarios Registrados</h2>
        <table border="1">
            <tr class="PanelControl_1">
                <th>ID_USER</th>
                <th>NAME_USER</th>
                <th>ACTION</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['ID_Usuario']; ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td>
                    <a href="Administrador.php?eliminar=<?php echo $row['ID_Usuario']; ?>" onclick="return confirm('Deseas eliminar este user?');">DELETE USER</a>
                </td>
            </tr>
            <?php } ?>
        </table>

            <button class="Salir"  onclick="window.location.href='../BACK/logout.php'">
      <label>Volver al inicio</label>
      <i class="fa-solid fa-right-from-bracket"></i>
    </button>
  </div>
    </div>
</body>
</html>