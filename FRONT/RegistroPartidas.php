<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RECURSOS/CSS/style_REGISTRO.css">
    <title>RegistroPartidas</title>

       
    <style>
        body {
            background-image: url('../RECURSOS/IMAGENES/fondoInicio.png');
            background-size: cover;
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center;
        }
    </style>
</head>

<body>
    
    <?php
    session_start();
    
    // Mostrar mensaje de error si existe
    if (isset($_SESSION["error_login"])) {
        echo '<div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin: 20px auto; max-width: 400px; text-align: center;">';
        echo htmlspecialchars($_SESSION["error_login"]);
        echo '</div>';
        unset($_SESSION["error_login"]); // Limpiar el mensaje después de mostrarlo
    }
    ?>
    
    <form class="Registro" action="../BACK/verificar_usuario_partidas.php" method="POST">
        <h1>Registro de partidas pasadas</h1>
    
        <input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre de usuario" autocomplete="off" required>
        <br>
        <input class="controls" type="password" name="password" id="password" placeholder="Contraseña" required>
        <br><br>
        <input class="botonsRegistro" type="submit" value="Acceder al registro">
        <br><br>
        <input class="botonsInicio" type="button" value="Regresar al inicio" onclick="window.location.href='../index.php'">
    </form>

</body>
</html>