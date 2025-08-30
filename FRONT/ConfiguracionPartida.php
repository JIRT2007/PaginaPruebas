<?php include '../SEGURIDAD/proteccion.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../RECURSOS/CSS/style_ConfiguracionPartida.css">
  <title>Configuración de Partida</title>
  <style>
    body {
      background-image: url("../RECURSOS/IMAGENES/fondoInicio.png"); 
      background-size: cover;
      background-repeat: no-repeat; 
      background-attachment: fixed; 
      background-position: center;
    }
  </style>
</head>

<body>
 <form method="POST" action="../BACK/guardar_configuracion.php">
  <section class="seleccion">
    <h1>Configuración de la partida</h1>
    <label for="cantidadJugadores">Cantidad de Jugadores</label>
    <br>
    <select name="cantidadJugadores" id="cantidadJugadores" onchange="habilitarBoton()">
      <option value="" disabled selected>Seleccionar la cantidad de jugadores</option>
      <option value="2">2 👤👤</option>
      <option value="3">3 👤👤👤</option>
      <option value="4">4 👤👤👤👤</option>
      <option value="5">5 👤👤👤👤👤</option>
    </select>

    <br>
    <input class="botonJUEGO" type="submit" value="JUGAR" id="botonJugar" disabled>
    <br>
    <input class="botonREGRESAR" type="button" value="Regresar al inicio" onclick="window.location.href='../index.php'">
  </section>
</form>

<script>
  function habilitarBoton() {
    const select = document.getElementById("cantidadJugadores");
    const boton = document.getElementById("botonJugar");
    // Si no hay valor seleccionado, el botón queda deshabilitado
    boton.disabled = !select.value;
  }
</script>


</body>
</html>
