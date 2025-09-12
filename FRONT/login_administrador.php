<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RECURSOS/CSS/style_REGISTRO.css">
    <title>Login administrador</title>  
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


    <form class="Registro" action="../BACK/procesar_login_administrador.php" method="POST">
        <h1>Login</h1>
        <input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre" autocomplete="off" required>
        <br>
        <input class="controls" type="password" name="password" id="password" placeholder="Contraseña" required>
        <br><br>
        <input class="botonsRegistro" type="submit" value="Iniciar como adimnistrador">
        <br><br>
        <input class="botonsInicio" type="button" value="Regresar al inicio" onclick="window.location.href='../index.php'">
    </form>
    
<?php if (!empty($error)): ?>
    <div style="color: red; font-weight: bold;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

</body>
</html>
