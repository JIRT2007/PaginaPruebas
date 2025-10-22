<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebPruebas</title>
  <link rel="stylesheet" href="RECURSOS/CSS/style_INDEX.css">
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<style>
    body {background-image: url('RECURSOS/IMAGENES/fondoInicio.png');
          background-size: cover;
          background-repeat: no-repeat; 
          background-attachment: fixed; 
          background-position: center;}
</style>

<body>
  
<nav class="BarraMenu">
  <img src="RECURSOS/IMAGENES/isotipo.png" alt="Logo" class="titulo" onclick="toggleMenu()" />
</nav>

<div class="Menu" id="menuLateral">
  <span class="close-btn" onclick="toggleMenu()">&times;</span>

    <button class="BotonRedireccion05" onclick="window.location.href='#Inicio'">
    <i class="fa-regular fa-house"></i> Regresar al inicio
  </button>

    <button class="BotonRedireccion02" onclick="window.location.href='#Informacion'">
    <i class="fa-regular fa-building-flag"></i> Sobre BrontoGames
  </button>

  <button class="BotonRedireccion01" onclick="window.location.href='#Reglas'">
    <i class="fa-regular fa-book"></i> Reglamento
  </button>

  <button class="BotonRedireccion03" onclick="window.location.href='FRONT/Registro.php'">
    <i class="fa-regular fa-book"></i> Registrarse 
  </button>

    <button class="BotonRedireccion03" onclick="window.location.href='FRONT/login_administrador.php'">
    <i class="fa-regular fa-book"></i> Login Administrador 
  </button>

    <button class="BotonRedireccion03" onclick="window.location.href='FRONT/RegistroPartidas.php'">
    <i class="fa-regular fa-book"></i> Registro de partidas 
  </button>

</div>

<script>
  function toggleMenu() {
    const menu = document.getElementById("menuLateral");
    menu.classList.toggle("open");
  }

  window.addEventListener('click', function(event) {
    const menu = document.getElementById("menuLateral");
    const img = document.querySelector('.BarraMenu .titulo');
    if (!menu.contains(event.target) && event.target !== img) {
      menu.classList.remove('open');
    }
  });
</script>


<section id="Inicio" class="PantallaInicio">
  <a href="">
    <img src="RECURSOS/IMAGENES/Title.png" alt="Logo" class="logo">
  </a>
</section>

<section class="Informacion">
  <input class="BotonRedireccion03" type="button" value="Jugar Draftosaurus🕹️" onclick="window.location.href='FRONT/login.php'"/> 
  <input class="BotonRedireccion04" type="button" value="Calcular puntaje" onclick="window.location.href='FRONT/Calculadora.html'"/>
</section>
  
<section id="Informacion" class="DatosEmpresa">
  <h2>Sobre nosotros</h2>
  <p>Presentamos BrontoGames, una empresa dedicada al desarrollo de software, donde la temática principal gira en torno a los dinosaurios.
Mezclamos lo moderno de los videojuegos y experiencias recreativas, con el universo prehistórico de los dinosaurios.
Buscamos traer a la vida a nuestros queridos amigos del Triasico, Jurasico y Cretacico. Nos basamos en el Brontosaurus para el nombre y logo de nuestra empresa, buscando generar impacto e impresión, buscamos dejar una huella, tal como este lo haría en sus épocas, por ello fue apodado como “Lagarto trueno”.

<div class="isotipoEmpresa">
  <img src="RECURSOS/IMAGENES/isotipo.png" alt="Logo" class="isotipo"><img/>
</div>

 <div class="MapaUbicacion">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3272.4355440479853!2d-56.1093717!3d-34.89551790000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x959f86cbe884e9ef%3A0x7d674cc9bf7f571b!2sRbla.%20Rep%C3%BAblica%20de%20Chile%204607%2C%2011400%20Montevideo%2C%20Departamento%20de%20Montevideo!5e0!3m2!1ses-419!2suy!4v1752874704963!5m2!1ses-419!2suy" 
    width="100%" 
    height="400" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>

<div class="Instagram">
  <a href="https://www.instagram.com/brontogames?igsh=MThyNjlhMjBkZXZqNA==" target="_blank">
      <img src="RECURSOS/IMAGENES/instagram-brands-solid-full.svg" alt="Logo" class="logoIG" onclick="toggleMenu()"><img/>
    </a>
    <h3>Siguenos en Instagram</h3>
</p>

</section>

<section id="Reglas" class="Reglas">
<h2>Reglamentacion</h2>

  <p font-size: 1.2rem;>
 
 
<b> -Instrumentos: </b>

<br><br>
*5 Tableros de parque (Uno para cada jugador).
<br>
*60 Piezas de dinosauros (En 6 colores diferentes, representando diferentes especies).
<br>
*1 Dado de colocacion.
<br><br>

<b>-Objetivo del juego:</b>

<br><br>
*Construir un parque de dinosaurios y colocarlos de forma estrategica en los distintos recintos del mapa para obtener la mayor cantidad de puntos al final de las partidas.
<br><br>

<b>-Como se inicia el juego?:</b>

<br><br>
*El juego se desarrolla en dos rondas las cuales cuentan con seis turnos. Al inicio cada jugador toma un tablero del parque y lo coloca frente a si, todas las piezas de dinosaurios se meten en el saco de tela y se mezclan y finalmente los jugadores deben de llegar a un consenso (o dejarlo al azar) para determinar quien inicia el juego.
<br><br>

<b>-Inicio del juego:</b>

<br><br>
1- Cada jugador toma 6 piezas de dinosaurios al azar.
<br><br>
2- Los jugdores inician a lanzar el dado el cual impone una restriccion para el resto de jugadores en la colocacion del siguiente dinosaurio (Estas restricciones no se aplican al jugador que lanza el dado).
<br><br>
3- Los jugadores eligen 1 dinosaurios de su mano y lo colocan en su parque, respetando las reglas de colocacion y las restricciones del dado.
<br><br>
4- Cada jugador pasa las piezas de dinosaurios restantes de su mano al jugador a su izquierda, el jugador que lanzo el dado previamente tiene que pasarselo al jugador a su derecha y se repite el proceso de los pasos anteriores hasta que se hayan colocado 6 dinosaurios en los tableros.
<br><br>
5- Se repiten los pasos sacando 6 dinosaurios nuevos de la bolsa para una segunda ronda.
<br><br>

<b>-Restricciones del dado:</b>

<br><br>
*El dado del juego determina en que zona del parque se debe colocar un dinosaurio en ese turno (Dicha restriccion no aplica al jugador que lo lanza).
<br><br>
# Zona izquiera o derecha del parque.
<br>
# Zona boscosa o de rocas.
<br>
# Recinto vacio.
<br>
# Recinto que no contenga un T-REX.
<br><br>
*Si un jugador no puede colocar un dinosaurio en un recinto valido, debe colocarlo en un espacio de rio.
<br><br>

<b>-Reglas de los recintos y puntuacion:</b>

<br><br>
1- "Bosque de la semejanza": Este recinto solo puede albergar dinosaurios de la misma especie y debe de ocuparse siempre de izquierda a derecha sin dejar espacios intermedios. Al final de la partida, el jugador ganara los puntos de victoria indicados segun el numero total de dinosaurios colocados.
<br><br>
2- "El prado de la diferencia": Solo puede albergar dinosaurios de especies distintas y debe de ocuparse siempre de izquierda a derecha sin dejar espacios intermedios. Al final de la partida, el jugador ganara los puntos de victoria indicados.
<br><br>
3- "La pradera del amor": Puede albergar dinosaurios de todas las especies y al finalizar la partida conseguiras 5 puntos de victoria por cada pareja de dinosaurios de la misma especie que se encentre en el recinto. Esta permitido tener mas de una pareja de la misma especie pero los dinosaurios que no formen parte de una.
<br>
4- "El trio frondoso": Alberga hasta tres dinosaurios sin importar su especie y al final de la partida el jugador ganara 7 puntos de victoria si hay exactamente 3 piezas de dinosaurio dentro del recinto pero si al final de la partida el jugador no logra llenar el recitno con exactamente 3 dinosaurios, no ganara ningun punto.
<br><br>
5- "El rey de la selva": Este recinto puede albergar un unico dinosaurio y al final de la partida ganara el jugador 7 puntos si ningun otro jugador tiene en su parque mas dinosaurios que tu de esa especie pero en caso de empate recibes igualmente los 7 puntos.
<br><br>
6- "La isla solitaria": Al igual que el recinto anterior, este solo puede albergar un unico dinosaurios que al final de la partida le otorga 7 puntos si es el unico de su especie en el parque del jugador, en caso contrario no otorga ningun punto.
<br><br>
*Despues de la segunda ronda (Cuando cada jugador ha ganado 12 dinosaurios en su parque), se suman los puntos y se determina el ganador.
<br><br>
# Se suman los puntajes de cada recinto. <br>
# Cada dinosaurio en el rio suman 1 punto.<br>
# Cada recinto con al menos 1 T-REX otorga 1 punto extra.<br>
# El jugador con mas puntos es el ganador.<br>
# En un caso de empate por puntos, gana aquel jugador que tenga mas dinosaurios en su parque.<br>
<br><br>

<b>-Resumen del reglamento y modo de juego:</b>

<br><br>
# Tomar 6 piezas de dinosaurios.<br>
# Lanzar el dado y aplicar la restriccion designada.<br>
# Elegir y colocar un dinosaurio.<br>
# Pasar los dinosaurios restantes.<br>
# Repetir hasta colocar 6 piezas de dinosaurios (Final de la ronda)<br>
# Hacer una segunda ronda con otros 6 dinosaurios.<br>
# Contar los puntos y determinar."<br>
</p>
</section>


</body>
</html>