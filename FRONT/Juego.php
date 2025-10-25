<?php
include '../SEGURIDAD/proteccion.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener nombres de jugadores y filtrar vacíos
$jugadores = isset($_SESSION['jugadores']) ? array_filter($_SESSION['jugadores'], function($j) { return !empty($j); }) : [];
$jugadores = array_values($jugadores); // Reindexar
$maxJugadores = count($jugadores) > 0 ? count($jugadores) : 1;

// Obtener el ID de la partida de la URL
$id_partida = isset($_GET['id_partida']) ? intval($_GET['id_partida']) : null;
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
    <script>
      // Pasar los nombres de los jugadores, cantidad e ID de partida al JS
      window.nombresJugadores = <?php echo json_encode($jugadores); ?>;
      window.idPartida = <?php echo $id_partida !== null ? $id_partida : 'null'; ?>;
    </script>


    <!-- Mostrar restricción activa del dado -->
    <div id="restriccion-dado" style="color:#333; font-weight:bold; margin:10px 0;"></div>

    <!-- Botón para cambiar de turno -->
    <button class="CambioTurno" id="btn-cambiar-turno">
      <label>Cambiar Turno</label>
      <i class="fa-solid fa-users"></i>
    </button>
   
    <!-- Botón para regresar (logout) -->
    <button class="Salir"  onclick="window.location.href='../BACK/logout.php'">
      <label>Salir</label>
      <i class="fa-solid fa-right-from-bracket"></i>
    </button>
  </div>

  <!-- Sistema de puntajes -->
  <div class="score-system" id="score-system">
    <h3 style="color: white; text-align: center; margin: 10px 0; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Puntajes de Jugadores</h3>
    <div class="scores-container" id="scores-container">
      <!-- Los puntajes se mostrarán aquí dinámicamente -->
    </div>
    <div class="leader-display" id="leader-display">
      <span style="color: #FFD700; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Líder: </span>
      <span id="leader-name" style="color: #FFD700; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Ninguno</span>
    </div>
  </div>

<script>
document.addEventListener("DOMContentLoaded", () => {

  const dinosContainer   = document.getElementById("zona-dinos");
  const btnCambiarTurno  = document.getElementById("btn-cambiar-turno");
  const turnoInfo        = document.getElementById("turno-info");

  // Usar los nombres de los jugadores y cantidad real
  const nombresJugadores = window.nombresJugadores && window.nombresJugadores.length > 0 ? window.nombresJugadores : ["Jugador 1"];
  const maxJugadores = nombresJugadores.length;
  let turnoActual    = 1;
  let dinoColocado   = false;
  let jugadorActual = 1; // índice del jugador actual (1 a maxJugadores)
  let jugadorConDado = 1; // jugador que tiene el dado (no recibe restricción)

  // --- Estado de los tableros ---
  let tableros = Array.from({ length: maxJugadores }, () => ({
    "region-top-left": [], "region-top-right": [], "region-middle-left": [],
    "region-middle-right": [], "region-bottom-left": [], "region-bottom-right": [],
    "region-center": []
  }));

  const imagenesDinos = [
    "../RECURSOS/IMAGENES/DinoRojoSprite.png",
    "../RECURSOS/IMAGENES/DinoAzulSprite.png",
    "../RECURSOS/IMAGENES/DinoAmarilloSprite.png",
    "../RECURSOS/IMAGENES/DinoNaranjaSprite.png",
    "../RECURSOS/IMAGENES/DinoVerdeSprite.png",
    "../RECURSOS/IMAGENES/DinoVioletaSprite.png"
  ];

  // --- Mano por ronda (6 por jugador), se reparte al inicio de las rondas 1 y 7 ---
  const manoPorJugador = Array.from({ length: maxJugadores }, () => []);
  
  // Sistema de puntajes
  let puntajes = Array.from({ length: maxJugadores }, () => 0);
  
  function repartirManosRonda(cantidad) {
    for (let j = 0; j < maxJugadores; j++) {
      const nuevaMano = [];
      for (let i = 0; i < cantidad; i++) {
        const imgSrc = imagenesDinos[Math.floor(Math.random() * imagenesDinos.length)];
        nuevaMano.push(imgSrc);
      }
      manoPorJugador[j] = nuevaMano;
    }
  }

  const limitePorZona = {
    "region region-top-left dropzone": 6,
    "region region-top-right dropzone": 1,
    "region region-middle-left dropzone": 3,
    "region region-middle-right dropzone": 6,
    "region region-bottom-left dropzone": 12,
    "region region-bottom-right dropzone": 1,
    "region region-center dropzone": 60
  };

  function agregarEventosArrastre(elem) {
    elem.addEventListener("dragstart", (e) => {
      if (dinoColocado) { e.preventDefault(); return; }
      e.dataTransfer.setData("text/html", elem.outerHTML);
      e.dataTransfer.effectAllowed = "move";
      elem.classList.add("drag-source");
    });
    elem.addEventListener("dragend", () => {
      elem.classList.remove("drag-source");
    });
    
    // Click derecho para quitar dinosaurio del tablero y devolverlo a la mano
    elem.addEventListener("contextmenu", (e) => {
      e.preventDefault();
      // Solo permitir quitar si está en el tablero (no en la zona de mano)
      if (elem.closest('.dropzone')) {
        const imgSrc = elem.querySelector('img').src;
        const mano = manoPorJugador[jugadorActual - 1];
        if (mano) {
          mano.push(imgSrc); // Devolver a la mano
          elem.remove(); // Quitar del tablero
          dinoColocado = false; // Permitir colocar otro
          generarDinos(); // Refrescar la vista de la mano
          // Actualizar puntajes después de quitar un dinosaurio
          recalcularTodosLosPuntajes();
        }
      }
    });
  }

  function generarDinos() {
    dinosContainer.innerHTML = "";
    const manoActual = manoPorJugador[jugadorActual - 1] || [];
    // Mostrar hasta 6 dinos de la mano persistente (sin re-randomizar)
    const cantidadAMostrar = Math.min(6, manoActual.length);
    for (let i = 0; i < cantidadAMostrar; i++) {
      const imgSrc = manoActual[i];
      const dinoDiv = document.createElement("div");
      dinoDiv.classList.add("draggable");
      dinoDiv.draggable = true;
      // Guardar el índice de la mano para poder "gastar" el dino al colocarlo
      dinoDiv.dataset.manoIndex = String(i);
      const img = document.createElement("img");
      img.src = imgSrc;
      img.alt = "Dino";
      dinoDiv.appendChild(img);
      dinosContainer.appendChild(dinoDiv);
      agregarEventosArrastre(dinoDiv);
    }
    dinoColocado = false;
  }

  function guardarTablero(jugador) {
    document.querySelectorAll(".dropzone").forEach(zone => {
      const id = Array.from(zone.classList).find(c => c.startsWith("region-"));
      const dinos = [];
      zone.querySelectorAll("img").forEach(img => dinos.push(img.src));
      tableros[jugador - 1][id] = dinos;
    });
  }

  function cargarTablero(jugador) {
    document.querySelectorAll(".dropzone").forEach(zone => {
      const id = Array.from(zone.classList).find(c => c.startsWith("region-"));
      zone.innerHTML = "";
      tableros[jugador - 1][id].forEach(src => {
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

  // === NUEVAS restricciones del dado ===
  const restriccionesDado = [
    "Solo en los recintos de la derecha",
    "Solo en los recintos de la izquierda",
    "Solo en los recintos de la zona boscosa",
    "Solo en los recintos de la zona rocosa",
    "No poder colocar donde haya un T-Rex",
    "Solo en recintos que estén vacíos"
  ];
  let restriccionActual = null;
  const restriccionDadoDiv = document.getElementById("restriccion-dado");
  // Contador de colocaciones en la ronda actual (por jugador)
  let colocacionesEnRonda = 0;

  const validadores = {
    "Solo en los recintos de la derecha": (zona, imgs) =>
      zona === "region-center" ? true : ["region-top-right","region-middle-right","region-bottom-right"].includes(zona),
    "Solo en los recintos de la izquierda": (zona, imgs) =>
      zona === "region-center" ? true : ["region-top-left","region-middle-left","region-bottom-left"].includes(zona),
    "Solo en los recintos de la zona boscosa": (zona, imgs) =>
      zona === "region-center" ? true : ["region-top-left","region-top-right","region-middle-left"].includes(zona),
    "Solo en los recintos de la zona rocosa": (zona, imgs) =>
      zona === "region-center" ? true : ["region-bottom-left","region-bottom-right","region-middle-right"].includes(zona),
    "No poder colocar donde haya un T-Rex": (zona, imgs) =>
      zona === "region-center" ? true : !imgs.some(img => img.src.includes("DinoRojoSprite.png")),
    "Solo en recintos que estén vacíos": (zona, imgs) =>
      zona === "region-center" ? true : imgs.length === 0
  };

  function tirarDado() {
    const randomIndex = Math.floor(Math.random() * restriccionesDado.length);
    restriccionActual = restriccionesDado[randomIndex];
    const nombreConDado = nombresJugadores[jugadorConDado - 1] || `Jugador ${jugadorConDado}`;
    restriccionDadoDiv.textContent = `Restricción del turno: ${restriccionActual} (${nombreConDado} lanzó el dado)`;
  }

  // Función para obtener nombre del dino desde la ruta
  const getNombre = (src) => src.split("/").pop().replace("Sprite.png", "").replace("Dino", "");

  // Cálculo de puntos según las reglas
  function calcularPuntaje(jugador) {
    const tablero = tableros[jugador - 1];
    let puntos = 0;

    // Regla region-top-left (Bosque de la semejanza)
    const topLeft = tablero["region-top-left"].length;
    const puntosTopLeft = [0, 2, 4, 8, 12, 18, 24];
    puntos += puntosTopLeft[topLeft] || 0;

    // Regla region-middle-left (3 dinos = 7 puntos)
    if (tablero["region-middle-left"].length === 3) puntos += 7;

    // Regla region-bottom-left (Parejas = 5 puntos cada una)
    const pares = Math.floor(tablero["region-bottom-left"].length / 2);
    puntos += pares * 5;

    // Regla region-center (1 punto por dino)
    puntos += tablero["region-center"].length;

    // Regla region-top-right (Rey - Mayoría entre todos los jugadores)
    const dinoTopRight = tablero["region-top-right"][0];
    if (dinoTopRight) {
      const nombre = getNombre(dinoTopRight);
      // Contar TODOS los dinosaurios de esta especie en el tablero del jugador
      const totalJugador = Object.values(tablero).flat().filter((src) => getNombre(src) === nombre).length;

      // Verificar si este jugador tiene la mayoría o empate de este dinosaurio
      let tieneMayoria = true;
      for (let i = 0; i < maxJugadores; i++) {
        if (i === jugador - 1) continue;
        const totalOtro = Object.values(tableros[i]).flat().filter((src) => getNombre(src) === nombre).length;
        if (totalOtro > totalJugador) {
          tieneMayoria = false;
          break;
        }
      }
      
      if (tieneMayoria && totalJugador > 0) {
        puntos += 7;
      }
    }

    // Regla region-middle-right (El prado de la diferencia)
    const midRight = tablero["region-middle-right"].length;
    const puntosMidRight = [0, 1, 3, 6, 10, 15, 21];
    puntos += puntosMidRight[midRight] || 0;

    // Regla region-bottom-right (Dinosaurio único)
    const dinoBottomRight = tablero["region-bottom-right"][0];
    if (dinoBottomRight) {
      const nombreBottomRight = getNombre(dinoBottomRight);
      const aparicionesEnTablero = Object.values(tablero).flat().filter((src) => getNombre(src) === nombreBottomRight).length;
      if (aparicionesEnTablero === 1) {
        puntos += 7;
      }
    }
    
    // Regla T-Rex bonus (1 punto por cada T-Rex)
    const todos = Object.values(tablero).flat().map(getNombre);
    puntos += todos.filter((n) => n === "Rojo").length;

    return puntos;
  }

  // Función para actualizar la visualización de puntajes
  function actualizarPuntajes() {
    const scoresContainer = document.getElementById("scores-container");
    const leaderDisplay = document.getElementById("leader-name");
    
    scoresContainer.innerHTML = "";
    
    let maxPuntaje = Math.max(...puntajes);
    let lideres = [];
    
    puntajes.forEach((puntaje, index) => {
      const playerDiv = document.createElement("div");
      playerDiv.className = "player-score";
      
      if (puntaje === maxPuntaje && maxPuntaje > 0) {
        playerDiv.classList.add("leader");
        const nombre = nombresJugadores[index] || `Jugador ${index + 1}`;
        lideres.push(nombre);
      }
      
      const nombre = nombresJugadores[index] || `Jugador ${index + 1}`;
      playerDiv.textContent = `${nombre}: ${puntaje}`;
      
      scoresContainer.appendChild(playerDiv);
    });
    
    // Actualizar el líder
    if (lideres.length === 0) {
      leaderDisplay.textContent = "Ninguno";
    } else if (lideres.length === 1) {
      leaderDisplay.textContent = lideres[0];
    } else {
      leaderDisplay.textContent = `Empate: ${lideres.join(", ")}`;
    }
  }

  // Función para recalcular todos los puntajes
  function recalcularTodosLosPuntajes() {
    for (let i = 0; i < maxJugadores; i++) {
      const tieneDinos = Object.values(tableros[i]).flat().length > 0;
      if (tieneDinos) {
        puntajes[i] = calcularPuntaje(i + 1);
      }
    }
    actualizarPuntajes();
  }

  // Función para guardar el resultado de la partida en la base de datos
  async function guardarResultadoPartida(idPartida, ganador) {
    try {
      const response = await fetch('../BACK/guardar_resultado_partida.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          id_partida: idPartida,
          ganador: ganador
        })
      });

      const data = await response.json();
      
      if (data.success) {
        console.log('Resultado guardado exitosamente:', data.message);
      } else {
        console.error('Error al guardar resultado:', data.error);
      }
    } catch (error) {
      console.error('Error en la petición:', error);
    }
  }

  // === EVENTOS DE DROP ===
  document.querySelectorAll(".dropzone").forEach(zone => {
    zone.addEventListener("dragover", e => {
      e.preventDefault();
      if (!dinoColocado) zone.style.backgroundColor = "rgba(255,255,255,0.1)";
    });
    zone.addEventListener("dragleave", () => {
      zone.style.backgroundColor = "transparent";
    });
    zone.addEventListener("drop", e => {
      e.preventDefault();
      zone.style.backgroundColor = "transparent";

      const source = document.querySelector(".drag-source");
      if (!source || dinoColocado) return;

      const idZona = Array.from(zone.classList).find(c => c.startsWith("region-"));
      const imgs   = Array.from(zone.querySelectorAll("img"));
      const nuevoSrc = source.querySelector("img").src;

      // --- Validación del dado ---
      if (restriccionActual && jugadorActual !== jugadorConDado) {
        const valido = validadores[restriccionActual](idZona, imgs);
        if (!valido) {
          alert("No puedes colocar aquí: " + restriccionActual);
          return;
        }
      }

      // Reglas adicionales
      if (idZona === "region-top-left" && imgs.length > 0) {
        if (nuevoSrc !== imgs[0].src) {
          alert("Solo dinos del mismo tipo en esta zona.");
          return;
        }
      }
      if (idZona === "region-middle-right") {
        if (imgs.some(img => img.src === nuevoSrc)) {
          alert("Solo dinos diferentes en esta zona.");
          return;
        }
      }

      const limite = limitePorZona[zone.className] || 99;
      if (imgs.length >= limite) {
        alert("Este recinto alcanzó el límite de dinosaurios admitidos");
        return;
      }

      source.classList.remove("drag-source");
      zone.appendChild(source);
      dinoColocado = true;
      // Consumir el dinosaurio de la mano del jugador actual
      const idx = parseInt(source.dataset.manoIndex || "-1", 10);
      const mano = manoPorJugador[jugadorActual - 1];
      if (!Number.isNaN(idx) && mano && idx >= 0 && idx < mano.length) {
        mano.splice(idx, 1);
      }
      // NO refrescar la mano aquí para evitar que se puedan arrastrar más dinos
      // La mano se refrescará al cambiar de turno
      // Actualizar puntajes después de colocar un dinosaurio
      recalcularTodosLosPuntajes();
      // El dado NO cambia aquí, solo el cambio de turno
    });
  });

  // === Cambio de turno ===
  btnCambiarTurno.addEventListener("click", () => {
    // Solo permitir cambio si se colocó un dinosaurio
    if (!dinoColocado) {
      alert("Debes colocar un dinosaurio antes de pasar de turno");
      return;
    }
    guardarTablero(jugadorActual);

    // Pasar al siguiente jugador
    if (jugadorActual < maxJugadores) {
      jugadorActual++;
    } else {
      // Si ya jugó el último jugador, reiniciamos al primero
      // y aumentamos el número de ronda global
      jugadorActual = 1;
      turnoActual++;
        // Rotar manos a la "izquierda" (ej: 1->3->2->1 para 3 jugadores)
        // Solo rotar si NO es inicio de nueva ronda de reparto (turno 7)
        if (turnoActual !== 7 && turnoActual <= 12) {
          const manosPrevias = manoPorJugador.map(m => m.slice());
          for (let k = 0; k < maxJugadores; k++) {
            const receptor = (k - 1 + maxJugadores) % maxJugadores; // izquierda
            manoPorJugador[receptor] = manosPrevias[k];
          }
          // Pasar el dado al jugador de la derecha
          jugadorConDado = (jugadorConDado % maxJugadores) + 1;
        }
      // Repartir nueva mano al inicio de la ronda 2 (turno 7)
      if (turnoActual === 7) {
        repartirManosRonda(6);
      }
      if (turnoActual <= 12) {
        tirarDado(); // Solo tirar dado si no terminó el juego
      }
    }

    // Si ya se completaron 12 rondas, terminar partida
    if (turnoActual > 12) {
      // Calcular puntajes finales
      recalcularTodosLosPuntajes();
      
      // Mostrar resultados finales
      let mensajeFinal = "¡Fin de la partida!\n\nPuntajes finales:\n";
      puntajes.forEach((puntaje, index) => {
        const nombre = nombresJugadores[index] || `Jugador ${index + 1}`;
        mensajeFinal += `${nombre}: ${puntaje} puntos\n`;
      });
      
      const maxPuntaje = Math.max(...puntajes);
      const ganadores = [];
      puntajes.forEach((puntaje, index) => {
        if (puntaje === maxPuntaje) {
          const nombre = nombresJugadores[index] || `Jugador ${index + 1}`;
          ganadores.push(nombre);
        }
      });
      
      let textoGanador = "";
      if (ganadores.length === 1) {
        mensajeFinal += `\n¡${ganadores[0]} es el ganador!`;
        textoGanador = ganadores[0];
      } else {
        mensajeFinal += `\n¡Empate entre: ${ganadores.join(", ")}!`;
        textoGanador = "Empate: " + ganadores.join(", ");
      }
      
      alert(mensajeFinal);
      turnoInfo.textContent = "Fin de la partida. ¡Gracias por jugar!";
      btnCambiarTurno.disabled = true;
      
      // Enviar resultado a la base de datos solo si hay ID de partida
      if (window.idPartida && window.idPartida !== null) {
        guardarResultadoPartida(window.idPartida, textoGanador);
      }
      
      return;
    }

    // Mostrar nombre y turno
    const nombre = nombresJugadores[jugadorActual - 1] || `Jugador ${jugadorActual}`;
    turnoInfo.textContent = `Turno: ${turnoActual} - ${nombre}`;
    cargarTablero(jugadorActual);
    generarDinos();
    // Resetear el estado de colocación para el nuevo jugador
    dinoColocado = false;
    // Actualizar puntajes al cambiar de turno
    recalcularTodosLosPuntajes();
  });

  // Inicialización
  // Mostrar nombre correcto en el primer turno
  turnoInfo.textContent = `Turno: 1 - ${nombresJugadores[0] || "Jugador 1"}`;
  // Repartir mano inicial para la ronda 1
  repartirManosRonda(6);
  generarDinos();
  tirarDado(); // Solo al inicio
  // Inicializar el sistema de puntajes
  actualizarPuntajes();
});
</script>

</body>
</html>