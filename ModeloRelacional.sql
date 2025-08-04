CREATE DATABASE Draftosaurus;
USE Draftosaurus;
CREATE TABLE USUARIO(
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    password VARCHAR(70) NOT NULL
);

CREATE TABLE partida_draftosaurus (
  id_partida INT AUTO_INCREMENT PRIMARY KEY,
  ID_Usuario INT NOT NULL REFERENCES USUARIO(ID_Usuario),
  numero_jugadores INT NOT NULL,
  estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
  puntuacion_ganador_partida INT DEFAULT 0
  jugador_ganador INT REFERENCES JUGADOR (ID_Jugador)
);

CREATE TABLE JUGADOR(
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Puntuacion_total_jugador INT NOT NULL,
    id_partida INT REFERENCES partida_draftosaurus (id_partida)
);

CREATE TABLE Dinosaurios(
    ID_Dinosaurios INT AUTO_INCREMENT PRIMARY KEY,
    Raza VARCHAR(30) NOT NULL
);

CREATE TABLE mano_Dinosaurios(
    id_mano INT AUTO_INCREMENT PRIMARY KEY,
    ID_Dinosaurios INT REFERENCES Dinosaurios(ID_Dinosaurios),
    ID_Jugador INT REFERENCES JUGADOR(ID_Jugador)
);

CREATE TABLE Dado(
    Cara INT AUTO_INCREMENT PRIMARY KEY,
    Restriccion VARCHAR(20) NOT NULL
);

CREATE TABLE Turnos(
    ID_Turno INT AUTO_INCREMENT PRIMARY KEY,
    NumeroDeTurno INT NOT NULL,
    NumeroDeRonda INT NOT NULL,
    Cara_Dado INT REFERENCES Dado(Cara),
    ID_Partida INT REFERENCES partida_drafotsaurus (id_partida)
);

CREATE TABLE Tablero(
    id_tablero INT AUTO_INCREMENT PRIMARY KEY,
    id_partida REFERENCES partida_drafotsaurus (id_partida),
    ID_Jugador REFERENCES JUGADOR (ID_Jugador),
    puntuacion_total INT DEFAULT 0
);

CREATE TABLE Region(
    ID_Region INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Region VARCHAR(50) NOT NULL,
    Puntos INT NOT NULL DEFAULT 0,
    id_tablero REFERENCES Tablero (id_tablero),
    Cantidad_Dinosaurios INT NOT NULL,
    Restricciones_Puntaje VARCHAR(100) NOT NULL
);

CREATE TABLE dino_region(
    ID_Region REFERENCES Region (ID_Region),
    ID_Dinosaurios REFERENCES Dinosaurios (ID_Dinosaurios)
);
