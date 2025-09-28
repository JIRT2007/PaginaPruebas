<?php
include '../SEGURIDAD/proteccion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <button class="Dado">
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
  document.addEventListener("DOMContentLoaded", () => {
    // --- Constantes y variables globales ---
    const dinosContainer = document.getElementById("zona-dinos");
    const btnCambiarTurno = document.getElementById("btn-cambiar-turno");
    const turnoInfo = document.getElementById("turno-info");

    const maxJugadores = 5;
    let turnoActual = 1;
    let dinoColocado = false;

    // Estructura para tableros de jugadores
    // Cada jugador tiene un objeto con las regiones del tablero
    let tableros = Array.from({ length: maxJugadores }, () => ({
      "region-top-left": [],
      "region-top-right": [],
      "region-middle-left": [],
      "region-middle-right": [],
      "region-bottom-left": [],
      "region-bottom-right": [],
      "region-center": []
    }));

    // Lista de imágenes de dinosaurios disponibles
    const imagenesDinos = [
      "../RECURSOS/IMAGENES/DinoRojoSprite.png",
      "../RECURSOS/IMAGENES/DinoAzulSprite.png",
      "../RECURSOS/IMAGENES/DinoAmarilloSprite.png",
      "../RECURSOS/IMAGENES/DinoNaranjaSprite.png",
      "../RECURSOS/IMAGENES/DinoVerdeSprite.png",
      "../RECURSOS/IMAGENES/DinoVioletaSprite.png"
    ];

    // Límite de dinosaurios por zona del tablero
    const limitePorZona = {
      "region region-top-left dropzone": 6,
      "region region-top-right dropzone": 1,
      "region region-middle-left dropzone": 3,
      "region region-middle-right dropzone": 6,
      "region region-bottom-left dropzone": 12,
      "region region-bottom-right dropzone": 1,
      "region region-center dropzone": 60
    };

    // --- Funciones ---

    /**
     * Agrega eventos de arrastre a un elemento dinosaurio.
     * Permite arrastrar el dinosaurio y marca el origen.
     * @param {HTMLElement} elem - Elemento dinosaurio.
     */
    function agregarEventosArrastre(elem) {
      elem.addEventListener("dragstart", (e) => {
        if (dinoColocado) {
          e.preventDefault();
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

    /**
     * Genera 6 dinosaurios aleatorios y los muestra en la zona de toma.
     * Reinicia el estado de dinoColocado.
     */
    function generarDinos() {
      dinosContainer.innerHTML = "";
      for (let i = 0; i < 6; i++) {
        const randomIndex = Math.floor(Math.random() * imagenesDinos.length);
        const imgSrc = imagenesDinos[randomIndex];

        const dinoDiv = document.createElement("div");
        dinoDiv.classList.add("draggable");
        dinoDiv.draggable = true;

        const img = document.createElement("img");
        img.src = imgSrc;
        img.alt = "Dino";

        dinoDiv.appendChild(img);
        dinosContainer.appendChild(dinoDiv);

        agregarEventosArrastre(dinoDiv);
      }
      dinoColocado = false;
    }

    /**
     * Guarda el estado actual del tablero del jugador.
     * @param {number} jugador - Número de jugador (1-indexado).
     */
    function guardarTablero(jugador) {
      document.querySelectorAll(".dropzone").forEach((zone) => {
        const id = zone.classList[1];
        const dinos = [];
        zone.querySelectorAll("img").forEach((img) => dinos.push(img.src));
        tableros[jugador - 1][id] = dinos;
      });
    }

    /**
     * Carga el tablero guardado del jugador actual.
     * @param {number} jugador - Número de jugador (1-indexado).
     */
    function cargarTablero(jugador) {
      document.querySelectorAll(".dropzone").forEach((zone) => {
        const id = zone.classList[1];
        zone.innerHTML = "";
        tableros[jugador - 1][id].forEach((src) => {
          const dinoDiv = document.createElement("div");
          dinoDiv.classList.add("draggable");
          dinoDiv.draggable = true;

          const img = document.createElement("img");
          img.src = src;
          img.alt = "Dino";

          dinoDiv.appendChild(img);
          zone.appendChild(dinoDiv);

          agregarEventosArrastre(dinoDiv);
        });
      });
    }

    // --- Inicialización de eventos en zonas ---
    // Permite soltar dinosaurios en las regiones del tablero
    document.querySelectorAll(".dropzone").forEach((zone) => {
      zone.addEventListener("dragover", (e) => {
        e.preventDefault();
        if (!dinoColocado) {
          zone.style.backgroundColor = "rgba(255,255,255,0.1)";
        }
      });

      zone.addEventListener("dragleave", () => {
        zone.style.backgroundColor = "transparent";
      });

      zone.addEventListener("drop", (e) => {
        e.preventDefault();
        zone.style.backgroundColor = "transparent";

        const source = document.querySelector(".drag-source");
        if (!source || dinoColocado) return;

        const idZona = zone.classList[1];
        const imgs = Array.from(zone.querySelectorAll("img"));
        const nuevoSrc = source.querySelector("img").src;

        // Restricción: solo dinos del mismo tipo en region-top-left
        if (idZona === "region-top-left" && imgs.length > 0) {
          if (nuevoSrc !== imgs[0].src) {
            alert("Solo puedes colocar dinosaurios del mismo tipo en esta zona.");
            return;
          }
        }

        // Restricción: solo dinos diferentes en region-middle-right
        if (idZona === "region-middle-right") {
          if (imgs.some((img) => img.src === nuevoSrc)) {
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

        // Coloca el dinosaurio en la zona
        source.classList.remove("drag-source");
        zone.appendChild(source);
        dinoColocado = true;

        if (restriccionActual) {
  const valido = validadores[restriccionActual](idZona, imgs);
  if (!valido) {
    alert("No puedes colocar aquí: " + restriccionActual);
    return;
  }
}

      });
    });

    /**
     * Cambia el turno al siguiente jugador.
     * Guarda el tablero actual y carga el siguiente.
     */
    btnCambiarTurno.addEventListener("click", () => {
      guardarTablero(turnoActual);
      turnoActual = (turnoActual % maxJugadores) + 1;
      turnoInfo.textContent = `Turno: ${turnoActual}`;
      cargarTablero(turnoActual);
      generarDinos();
    });

    // --- Inicio de partida ---
    generarDinos();
  });

  //Caras del dado
const restriccionesDado = [
  "Zona izquierda del parque",  
  "Zona derecha del parque",    
  "Zona boscosa",               
  "Zona rocosa",                
  "Recinto vacío",
  "Recinto sin T-Rex"
];

let restriccionActual = null;

//Función para tirar dado
function tirarDado() {
  const randomIndex = Math.floor(Math.random() * restriccionesDado.length);
  restriccionActual = restriccionesDado[randomIndex];
  alert("Restricción del turno: " + restriccionActual);
}

//Validadores de restricción
const validadores = {
  "Zona izquierda del parque": (zona, imgs) => zona.includes("left"),
  "Zona derecha del parque":  (zona, imgs) => zona.includes("right"),
  "Zona boscosa":             (zona, imgs) => zona === "region-top-left",
  "Zona rocosa":              (zona, imgs) => zona === "region-bottom-right",
  "Recinto vacío":            (zona, imgs) => imgs.length === 0,
  "Recinto sin T-Rex":        (zona, imgs) => !imgs.some(img => img.src.includes("DinoRojoSprite.png"))
};

//Asignar botón del dado
document.querySelector(".Dado").addEventListener("click", tirarDado);

</script>

</body>
</html>