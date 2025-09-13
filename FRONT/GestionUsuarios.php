

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Eliminar usuario si se recibe el parámetro
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $sql = "DELETE FROM usuario WHERE ID_Usuario = $id";
    mysqli_query($conn, $sql);
    header("Location: GestionUsuarios.php");
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT ID_Usuario, nombre FROM usuario";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../RECURSOS/CSS/style_admin.css">
</head>
<body>
    <div class="PanelAdmin">
        <h1>Usuarios Registrados</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['ID_Usuario']; ?></td>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td>
                    <a href="GestionUsuarios.php?eliminar=<?php echo $row['ID_Usuario']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <br>
        <a href="Administrador.php">Volver al panel de administrador</a>
    </div>
</body>
</html>