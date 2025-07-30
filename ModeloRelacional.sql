CREATE DATABASE Draftosaurus;

CREATE TABLE JUGADOR(
    ID_Jugador INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Puntuacion_total_jugador INT NOT NULL 
);

CREATE TABLE Partida_Draftosaurus(
    ID_Partida INT PRIMARY KEY,
    Numero_Jugadores INT NOT NULL,
    Estado VARCHAR(20) NOT NULL,
    Puntuacion_total_partida INT NOT NULL,
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