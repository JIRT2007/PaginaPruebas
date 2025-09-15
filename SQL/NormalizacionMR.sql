--Primera Forma Normalizada (FN1)-- -- Segunda Forma Normalizada (FN2)--

CREATE DATABASE draftosaurus;
USE draftosaurus;

CREATE TABLE usuario(
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    password VARCHAR(70) NOT NULL
);

CREATE TABLE jugador(
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    ID_UsuarioJugador INT NOT NULL,
    FOREIGN KEY (ID_UsuarioJugador) REFERENCES usuario (ID_Usuario)
);

CREATE TABLE administrador (
    ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(70) NOT NULL
);

CREATE TABLE partida_draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    numero_jugadores INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente'
);


CREATE TABLE partida_jugadores (
    ID_Partida INT NOT NULL,
    ID_Jugador INT NOT NULL,
    es_ganador BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (ID_Partida, ID_Jugador),
    FOREIGN KEY (ID_Partida) REFERENCES partida_draftosaurus(ID_Partida),
    FOREIGN KEY (ID_Jugador) REFERENCES jugador(ID_Jugador)
);

CREATE TABLE partida_draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    Player1 VARCHAR(30),
    Player2 VARCHAR(30),
    Player3 VARCHAR(30),
    Player4 VARCHAR(30),
    Player5 VARCHAR(30),
    jugador_ganador VARCHAR(30),
    numero_jugadores INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE tablero(
    ID_Tablero INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaTablero INT NOT NULL,
    ID_JugadorTablero INT NOT NULL,
    FOREIGN KEY (ID_PartidaTablero) REFERENCES partida_draftosaurus (ID_Partida),
    FOREIGN KEY (ID_JugadorTablero) REFERENCES jugador (ID_Jugador)
);

CREATE TABLE recintos(
    ID_Recinto INT AUTO_INCREMENT PRIMARY KEY,
    ID_TableroRecinto INT NOT NULL,
    FOREIGN KEY (ID_TableroRecinto) REFERENCES tablero (ID_Tablero)
);

CREATE TABLE dado(
    ID_Dado INT AUTO_INCREMENT PRIMARY KEY,
    CaraDado VARCHAR(50),
    ID_JugadorDado INT NOT NULL,
    ID_PartidaDado INT NOT NULL,
    FOREIGN KEY (ID_JugadorDado) REFERENCES jugador (ID_Jugador),
    FOREIGN KEY (ID_PartidaDado) REFERENCES partida_draftosaurus (ID_Partida)
);

CREATE TABLE ronda(
    ID_Ronda INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaRonda INT NOT NULL,
    NumRonda INT, 
    FOREIGN KEY (ID_PartidaRonda) REFERENCES partida_draftosaurus (ID_Partida)
);

CREATE TABLE turnos(
    ID_Turnos INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorTurnos INT NOT NULL,
    FOREIGN KEY (ID_JugadorTurnos) REFERENCES jugador (ID_Jugador)
);

CREATE TABLE dinosaurios(
    ID_Dinosaurio INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorDinosaurio INT NOT NULL,
    ID_RecintoDinosaurio INT NOT NULL,
    Especie VARCHAR(50),
    TREX BOOLEAN,
    FOREIGN KEY (ID_JugadorDinosaurio) REFERENCES jugador (ID_Jugador),
    FOREIGN KEY (ID_RecintoDinosaurio) REFERENCES recintos (ID_Recinto)
);

-- Tercera Forma Normalizada (FN3)--

CREATE DATABASE draftosaurus;
USE draftosaurus;

CREATE TABLE usuario(
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    password VARCHAR(70) NOT NULL
);

CREATE TABLE jugador(
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    ID_UsuarioJugador INT NOT NULL,
    FOREIGN KEY (ID_UsuarioJugador) REFERENCES usuario (ID_Usuario)
);

CREATE TABLE administrador (
    ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(70) NOT NULL
);

CREATE TABLE partida_draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    numero_jugadores INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente'
);


CREATE TABLE partida_jugadores (
    ID_Partida INT NOT NULL,
    ID_Jugador INT NOT NULL,
    es_ganador BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (ID_Partida, ID_Jugador),
    FOREIGN KEY (ID_Partida) REFERENCES partida_draftosaurus(ID_Partida),
    FOREIGN KEY (ID_Jugador) REFERENCES jugador(ID_Jugador)
);

CREATE TABLE partida_draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    Player1 VARCHAR(30),
    Player2 VARCHAR(30),
    Player3 VARCHAR(30),
    Player4 VARCHAR(30),
    Player5 VARCHAR(30),
    jugador_ganador VARCHAR(30),
    numero_jugadores INT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente'
);

CREATE TABLE tablero(
    ID_Tablero INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaTablero INT NOT NULL,
    ID_JugadorTablero INT NOT NULL,
    FOREIGN KEY (ID_PartidaTablero) REFERENCES partida_draftosaurus (ID_Partida),
    FOREIGN KEY (ID_JugadorTablero) REFERENCES jugador (ID_Jugador)
);

CREATE TABLE recintos(
    ID_Recinto INT AUTO_INCREMENT PRIMARY KEY,
    ID_TableroRecinto INT NOT NULL,
    FOREIGN KEY (ID_TableroRecinto) REFERENCES tablero (ID_Tablero)
);

CREATE TABLE dado(
    ID_Dado INT AUTO_INCREMENT PRIMARY KEY,
    CaraDado VARCHAR(50),
    ID_JugadorDado INT NOT NULL,
    ID_PartidaDado INT NOT NULL,
    FOREIGN KEY (ID_JugadorDado) REFERENCES jugador (ID_Jugador),
    FOREIGN KEY (ID_PartidaDado) REFERENCES partida_draftosaurus (ID_Partida)
);

CREATE TABLE ronda(
    ID_Ronda INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaRonda INT NOT NULL,
    NumRonda INT, 
    FOREIGN KEY (ID_PartidaRonda) REFERENCES partida_draftosaurus (ID_Partida)
);

CREATE TABLE turnos(
    ID_Turnos INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorTurnos INT NOT NULL,
    FOREIGN KEY (ID_JugadorTurnos) REFERENCES jugador (ID_Jugador)
);

CREATE TABLE especie (
    ID_Especie INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    es_trex BOOLEAN DEFAULT FALSE
);

CREATE TABLE dinosaurios(
    ID_Dinosaurio INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorDinosaurio INT NOT NULL,
    ID_RecintoDinosaurio INT NOT NULL,
    ID_Especie INT NOT NULL,
    FOREIGN KEY (ID_JugadorDinosaurio) REFERENCES jugador(ID_Jugador),
    FOREIGN KEY (ID_RecintoDinosaurio) REFERENCES recintos(ID_Recinto),
    FOREIGN KEY (ID_Especie) REFERENCES especie(ID_Especie)
);


