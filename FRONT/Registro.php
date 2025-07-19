<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/RECURSOS/CSS/style_REGISTRO.css">
    <title>Registro</title>    
</head>  
    <body>
        <h1>Registro</h1>
        

        <form class="Registro" action="../BACK/procesar_registro.php" method="post">
            <input class="controls" type="text" name="nombre" id="nombre" placeholder="Nombre" required>
            <br><br>
            <input class="botonsRegistro" type="submit" value="Registrarse para jugar">
            <br><br>
        </form>

        <input class="botonsInicio" type="button" value="Regresar al inicio" onclick="window.location.href='../index.html'">

    
</body></html>
