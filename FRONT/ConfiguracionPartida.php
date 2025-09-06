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
  <select id="cantidadJugadores" onchange="habilitarNombres()" name="cantidadJugadores" required>
    <option value="" disabled selected>Seleccionar la cantidad de jugadores</option>
    <option value="2">2 👤👤</option>
    <option value="3">3 👤👤👤</option>
    <option value="4">4 👤👤👤👤</option>
    <option value="5">5 👤👤👤👤👤</option>
  </select>

  <!-- Inputs de nombre deshabilitados por defecto -->
  <input class="controls" type="text" id="player1" name="Player1" placeholder="Nombre 1" disabled required>
  <input class="controls" type="text" id="player2" name="Player2" placeholder="Nombre 2" disabled required>
  <input class="controls" type="text" id="player3" name="Player3" placeholder="Nombre 3" disabled required>
  <input class="controls" type="text" id="player4" name="Player4" placeholder="Nombre 4" disabled required>
  <input class="controls" type="text" id="player5" name="Player5" placeholder="Nombre 5" disabled required>

  <br>
  <input class="botonJUEGO" type="submit" value="JUGAR" id="botonJugar" disabled>
  <br>
  <input class="botonREGRESAR" type="button" value="Regresar al inicio" onclick="window.location.href='../index.php'">
  </form>

</section>

<!--script>
  function habilitarNombres() {
    const cantidad = document.getElementById("cantidadJugadores").value;
    const inputs = [
      document.getElementById("Player1"),
      document.getElementById("Player2"),
      document.getElementById("Player3"),
      document.getElementById("Player4"),
      document.getElementById("Player5")
    ];
    const botonJugar = document.getElementById("botonJugar");

    // Deshabilita todos los inputs primero
    inputs.forEach(input => input.disabled = true);

    // Habilita solo los necesarios
    for (let i = 0; i < cantidad; i++) {
      inputs[i].disabled = false;
    }

    // Habilita el botón JUGAR cuando haya selección
    botonJugar.disabled = false;
  }

    
  </script-->
  
<script>
function habilitarNombres() {
  const cantidad = parseInt(document.getElementById("cantidadJugadores").value, 10);
  const ids = ["player1", "player2", "player3", "player4", "player5"];
  const botonJugar = document.getElementById("botonJugar");

  // Deshabilita todos los inputs primero
  ids.forEach(id => {
    document.getElementById(id).disabled = true;
  });

  // Habilita solo los necesarios
  for (let i = 0; i < cantidad; i++) {
    document.getElementById(ids[i]).disabled = false;
  }

  // Guarda la cantidad para usarla en el juego
  cantidadJugadoresPartida = cantidad;

  // Habilita el botón JUGAR solo si la cantidad es válida
  botonJugar.disabled = isNaN(cantidad) || cantidad < 1;

}

</script>

</body>
</html>
