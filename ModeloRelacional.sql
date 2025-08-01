CREATE DATABASE Draftosaurus;

CREATE TABLE JUGADOR(
    ID_Jugador INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Puntuacion_total_jugador INT NOT NULL 
);

CREATE TABLE partida_draftosaurus (
  id_partida INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT,
  numero_jugadores INT NOT NULL,
  estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
  puntuacion_total_partida INT DEFAULT NULL
);


CREATE TABLE Calculo_Puntaje(
    ID_Jugador INT REFERENCES JUGADOR(ID_Jugador)
);

CREATE TABLE Turnos(
    ID_Turno INT PRIMARY KEY,
    NumeroDeTurno INT NOT NULL
);

CREATE TABLE Dinosaurios(
    ID_Dinosaurios INT  PRIMARY KEY,
    ID_Jugador INT REFERENCES JUGADOR(ID_Jugador)
);

CREATE TABLE Dado(
    ID_Dado INT PRIMARY KEY,
    Caras_Posibles VARCHAR(20) NOT NULL,
    Cara_Actual VARCHAR(20) NOT NULL
);

CREATE TABLE Restricciones_Dado(
    ID_Restriccion INT PRIMARY KEY,
    Descripcion VARCHAR(100) NOT NULL
);

CREATE TABLE Region(
    ID_Region INT PRIMARY KEY,
    Nombre_Region VARCHAR(50) NOT NULL,
    Puntos INT NOT NULL,
    Cantidad_Dinosaurios INT NOT NULL,
    Restricciones_Puntaje VARCHAR(100) NOT NULL
);
