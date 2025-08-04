<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RECURSOS/CSS/style_REGISTRO.css">
    <title>Registro</title>  
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

    <form class="Registro" action="../BACK/procesar_registro.php" method="POST">
        <h1>Registro</h1>
        <input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <br>
        <input class="controls" type="text" name="password" id="password" placeholder="Contraseña" required>
        <br><br>
        <input class="botonsRegistro" type="submit" value="Registrarse para jugar">
        <br><br>
        <input class="botonsInicio" type="button" value="Regresar al inicio" onclick="window.location.href='../index.html'">
    </form>
    
</body>
</html>
