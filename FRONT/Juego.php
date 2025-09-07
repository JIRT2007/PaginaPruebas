<<?php
include '../SEGURIDAD/proteccion.php';
session_start();
$jugadores = isset($_SESSION['jugadores']) ? $_SESSION['jugadores'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Estilos externos -->
  <link rel="stylesheet" href="../RECURSOS/CSS/style_juego.css">
  <!-- Librería de iconos (FontAwesome) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Partida</title>

  <style>
    /* --- Estilo del tablero --- */
    .tablero {
      background-image: url("../RECURSOS/IMAGENES/SpriteTablero.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      width: 70%;
      height: 80%;
      border: 7px solid rgba(255, 255, 255, 1);
      position: relative;
    }

    /* Fondo desenfocado con oscurecimiento */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("../RECURSOS/IMAGENES/fondoInicio.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      filter: blur(8px) brightness(0.7);
      z-index: -1;
    }

    .icon-btn:hover {
      background-color: #45a049;
      transform: scale(1.1);
    }



  </style>
</head>

<body>
  <!-- Tablero con 7 zonas donde se pueden colocar los dinosaurios -->
  <div class="tablero" id="tablero"> 
    <div class="region region-top-left dropzone"></div>
    <div class="region region-top-right dropzone"></div>
    <div class="region region-middle-left dropzone"></div>
    <div class="region region-middle-right dropzone"></div>
    <div class="region region-bottom-left dropzone"></div>
    <div class="region region-bottom-right dropzone"></div>
    <div class="region region-center dropzone"></div>
  </div>



  <!-- Zona para tomar dinosaurios y botones de control -->
  <div class="tab" id="TomaDinosaurios">
    <div id="zona-dinos"></div> <!-- Aquí aparecen los dinos disponibles -->
    <br> 
    
    <span id="turno-info" style="color:black; margin-left:10px;"> Turno: 1 - <?php echo isset($jugadores[0]) ? htmlspecialchars($jugadores[0]) : 'Jugador 1'; ?></span>

    <!-- Botón con un icono (ejemplo: tirar dado) -->
    <button class="Dado" onclick="alert('¡Botón presionado!')">
      <i class="fa-solid fa-dice"></i>
    </button>

    <!-- Botón para cambiar de turno -->
    <button class="CambioTurno" id="btn-cambiar-turno">
      <i class="fa-solid fa-users"></i>
    </button>
   



    <!-- Botón para regresar (logout) -->
    <button class="Salir"  onclick="window.location.href='../BACK/logout.php'">
      <i class="fa-solid fa-right-from-bracket"></i>
    </button>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Referencias a elementos HTML
    const dinosContainer = document.getElementById('zona-dinos');
    const btnCambiarTurno = document.getElementById('btn-cambiar-turno');
    const turnoInfo = document.getElementById('turno-info');

    const maxJugadores = 5; // cantidad máxima de jugadores
    let turnoActual = 1;    // empieza en el turno 1
    let dinoColocado = false; // controla si ya puso un dino en el turno

    // Estructura para guardar los tableros de cada jugador
    let tableros = Array.from({ length: maxJugadores }, () => {
      return {
        "region-top-left": [],
        "region-top-right": [],
        "region-middle-left": [],
        "region-middle-right": [],
        "region-bottom-left": [],
        "region-bottom-right": [],
        "region-center": []
      };
    });

    // Lista de imágenes de los dinosaurios disponibles
    const imagenesDinos = [
      "../RECURSOS/IMAGENES/DinoRojoSprite.png",
      "../RECURSOS/IMAGENES/DinoAzulSprite.png",
      "../RECURSOS/IMAGENES/DinoAmarilloSprite.png",
      "../RECURSOS/IMAGENES/DinoNaranjaSprite.png",
      "../RECURSOS/IMAGENES/DinoVerdeSprite.png",
      "../RECURSOS/IMAGENES/DinoVioletaSprite.png"
    ];

    // Agrega eventos de arrastre a un dino
    function agregarEventosArrastre(elem) {
      elem.addEventListener("dragstart", e => {
        if (dinoColocado) {
          e.preventDefault(); // no permite mover otro dino si ya puso uno
          return;
        }
        e.dataTransfer.setData("text/html", elem.outerHTML);
        e.dataTransfer.effectAllowed = "move";
        elem.classList.add("drag-source");
      });

      elem.addEventListener("dragend", () => {
        elem.classList.remove("drag-source");
      });
    }

    // Genera 6 dinosaurios aleatorios en la zona de toma
    function generarDinos() {
      dinosContainer.innerHTML = ''; // limpiar zona
      for (let i = 0; i < 6; i++) {
        const randomIndex = Math.floor(Math.random() * imagenesDinos.length);
        const imgSrc = imagenesDinos[randomIndex];

        const dinoDiv = document.createElement('div');
        dinoDiv.classList.add('draggable');
        dinoDiv.draggable = true;

        const img = document.createElement('img');
        img.src = imgSrc;
        img.alt = "Dino";

        dinoDiv.appendChild(img);
        dinosContainer.appendChild(dinoDiv);

        agregarEventosArrastre(dinoDiv);
      }
      dinoColocado = false; // reinicia para el nuevo turno
    }

    // Guarda el tablero actual del jugador
    function guardarTablero(jugador) {
      document.querySelectorAll(".dropzone").forEach(zone => {
        const id = zone.classList[1];
        const dinos = [];
        zone.querySelectorAll("img").forEach(img => {
          dinos.push(img.src);
        });
        tableros[jugador - 1][id] = dinos;
      });
    }

    // Carga el tablero guardado de un jugador
    function cargarTablero(jugador) {
      document.querySelectorAll(".dropzone").forEach(zone => {
        const id = zone.classList[1];
        zone.innerHTML = "";
        tableros[jugador - 1][id].forEach(src => {
          const dinoDiv = document.createElement('div');
          dinoDiv.classList.add('draggable');
          dinoDiv.draggable = true;

          const img = document.createElement('img');
          img.src = src;
          img.alt = "Dino";

          dinoDiv.appendChild(img);
          zone.appendChild(dinoDiv);

          agregarEventosArrastre(dinoDiv);
        });
      });
    }

    // Permitir soltar dinos en el tablero 
    document.querySelectorAll(".dropzone").forEach(zone => {
      zone.addEventListener("dragover", e => {
        e.preventDefault();
        if (!dinoColocado) {
          zone.style.backgroundColor = "rgba(255,255,255,0.1)";
        }
      });

      zone.addEventListener("dragleave", () => {
        zone.style.backgroundColor = "transparent";
      });

      zone.addEventListener("drop", e => {
        e.preventDefault();
        zone.style.backgroundColor = "transparent";

        const source = document.querySelector(".drag-source");
        if (!source || dinoColocado) return;

        const idZona = zone.classList[1]; // Ej: region-top-left
        const imgs = Array.from(zone.querySelectorAll("img"));
        const nuevoSrc = source.querySelector("img").src;

        // Restricción para la zona solo iguales
        if (idZona === "region-top-left" && imgs.length > 0) {
          const primerSrc = imgs[0].src;
          if (nuevoSrc !== primerSrc) {
            alert("Solo puedes colocar dinosaurios del mismo tipo en esta zona.");
            return;
          }
        }

        // Restricción para la zona solo diferentes
        if (idZona === "region-middle-right") {
          if (imgs.some(img => img.src === nuevoSrc)) {
            alert("Solo puedes colocar dinosaurios diferentes en esta zona.");
            return;
          }
        }

        // Límite por zona
        const limite = limitePorZona[zone.className] || 99;
        if (imgs.length >= limite) {
          alert("Este recinto alcanzó el límite de dinosaurios admitidos");
          return;
        }

        // Si pasa las restricciones, coloca el dino
        source.classList.remove("drag-source");
        zone.appendChild(source);
        dinoColocado = true;
      });
    });

    // --- Cambiar de turno ---
    btnCambiarTurno.addEventListener('click', () => {
      guardarTablero(turnoActual);

      turnoActual = (turnoActual % maxJugadores) + 1;
      turnoInfo.textContent = `Turno: ${turnoActual}`;

      cargarTablero(turnoActual);
      generarDinos(); // genera automáticamente para el nuevo turno
    });

    // Genera dinos al iniciar la partida automáticamente
    generarDinos();
  });

  //Cantidad de dinos por recinto
  const limitePorZona = {
  "region region-top-left dropzone": 6,
  "region region-top-right dropzone": 1,
  "region region-middle-left dropzone": 3,
  "region region-middle-right dropzone": 6,
  "region region-bottom-left dropzone": 12,
  "region region-bottom-right dropzone": 1,
  "region region-center dropzone": 60
};

</script> 

</body>
</html>
