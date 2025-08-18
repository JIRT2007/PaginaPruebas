<?php include '../SEGURIDAD/proteccion.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../RECURSOS/CSS/style_juego.css">
  <title>Partida</title>

  <style>
    .tablero {
      background-image: url("../RECURSOS/IMAGENES/SpriteTablero.png");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      width: 65%;
      height: 79%;
      border: 7px solid rgba(255, 255, 255, 1);
      position: relative;
    }

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
  <div class="tablero" id="tablero">
    <div class="region region-top-left dropzone"></div>
    <div class="region region-top-right dropzone"></div>
    <div class="region region-middle-left dropzone"></div>
    <div class="region region-middle-right dropzone"></div>
    <div class="region region-bottom-left dropzone"></div>
    <div class="region region-bottom-right dropzone"></div>
    <div class="region region-center dropzone"></div>
  </div>

  <div class="tab" id="TomaDinosaurios">
    <div id="zona-dinos">
      <!-- Aquí se generarán los dinos -->
    </div>

    <br>

    <input class="BotonRedireccionInicio" type="button" value="Regresar" onclick="window.location.href='../BACK/logout.php'" />

    <input class="BotonRedireccionCambio" type="button" value="Cambiar de turno"/>

    <input id="btn-obtener-dinos" class="BotonRedireccionObtenerDinos" type="button" value="Obtener dinosauruios"/>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const btnObtener = document.getElementById('btn-obtener-dinos');
    const dinosContainer = document.getElementById('zona-dinos');

    const imagenesDinos = [
      "../RECURSOS/IMAGENES/DinoRojoSprite.png",
      "../RECURSOS/IMAGENES/DinoAzulSprite.png",
      "../RECURSOS/IMAGENES/DinoAmarilloSprite.png",
      "../RECURSOS/IMAGENES/DinoNaranjaSprite.png",
      "../RECURSOS/IMAGENES/DinoVerdeSprite.png",
      "../RECURSOS/IMAGENES/DinoVioletaSprite.png"
    ];

    function agregarEventosArrastre(elem) {
      elem.addEventListener("dragstart", e => {
        e.dataTransfer.setData("text/html", elem.outerHTML);
        e.dataTransfer.effectAllowed = "move";
        elem.classList.add("drag-source");
      });

      elem.addEventListener("dragend", () => {
        elem.classList.remove("drag-source");
      });
    }

    function generarDinos() {
      dinosContainer.innerHTML = ''; // Limpiar anteriores

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
    }

    btnObtener.addEventListener('click', generarDinos);

    // Hacer que las regiones acepten drops
    document.querySelectorAll(".dropzone").forEach(zone => {
      zone.addEventListener("dragover", e => {
        e.preventDefault();
        zone.style.backgroundColor = "rgba(255,255,255,0.1)";
      });

      zone.addEventListener("dragleave", () => {
        zone.style.backgroundColor = "transparent";
      });

      zone.addEventListener("drop", e => {
        e.preventDefault();
        zone.style.backgroundColor = "transparent";

        const source = document.querySelector(".drag-source");
        if (source && source.parentElement !== zone) {
          const clone = source.cloneNode(true);
          clone.classList.remove("drag-source");
          clone.draggable = true;
          agregarEventosArrastre(clone);
          zone.appendChild(clone);
        }
      });
    });

    // Generar los primeros dinos al cargar
    generarDinos();
  });
  </script>
</body>
</html>
