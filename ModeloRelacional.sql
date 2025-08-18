CREATE DATABASE Draftosaurus;
USE Draftosaurus;

CREATE TABLE Usuario(
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    password VARCHAR(70) NOT NULL
);

CREATE TABLE Jugador(
    ID_Jugador INT AUTO_INCREMENT PRIMARY KEY,
    ID_UsuarioJugador INT NOT NULL,
    FOREIGN KEY (ID_UsuarioJugador) REFERENCES Usuario (ID_Usuario)
);

CREATE TABLE Administrador(
    ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
    ID_UsuarioAdmin INT NOT NULL,
    FOREIGN KEY (ID_UsuarioAdmin) REFERENCES Usuario (ID_Usuario) 
);

CREATE TABLE Partida_Draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorPartida INT NOT NULL,
    jugador_ganador INT,
    numero_jugadores INT NOT NULL,
    estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
    FOREIGN KEY (ID_JugadorPartida) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (jugador_ganador) REFERENCES Jugador (ID_Jugador)
);

CREATE TABLE Dado(
    ID_Dado INT AUTO_INCREMENT PRIMARY KEY,
    CaraDado VARCHAR(20),
    ID_JugadorDado INT NOT NULL,
    ID_PartidaDado INT NOT NULL,
    FOREIGN KEY (ID_JugadorDado) REFERENCES Jugador (ID_Jugador),
    FOREIGN KEY (ID_PartidaDado) REFERENCES Partida_Draftosaurus (ID_Partida)
);

CREATE TABLE Ronda(
    ID_Ronda INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaRonda INT NOT NULL,
    NumRonda INT, 
    FOREIGN KEY (ID_PartidaRonda) REFERENCES Partida_Draftosaurus (ID_Partida)
);

CREATE TABLE Turnos(
    ID_Turnos INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorTurnos INT NOT NULL,
    FOREIGN KEY (ID_JugadorTurnos) REFERENCES Jugador (ID_Jugador)
);

CREATE TABLE Tablero(
    ID_Tablero INT AUTO_INCREMENT PRIMARY KEY,
    ID_PartidaTablero INT NOT NULL,
    ID_JugadorTablero INT NOT NULL,
    FOREIGN KEY (ID_PartidaTablero) REFERENCES Partida_Draftosaurus (ID_Partida),
    FOREIGN KEY (ID_JugadorTablero) REFERENCES Jugador (ID_Jugador)
);

CREATE TABLE Recintos(
    ID_Recinto INT AUTO_INCREMENT PRIMARY KEY,
    ID_TableroRecinto INT NOT NULL,
    FOREIGN KEY (ID_TableroRecinto) REFERENCES Tablero (ID_Tablero)
);

CREATE TABLE Dinosaurios(
    ID_Dinosaurio INT AUTO_INCREMENT PRIMARY KEY,
    ID_JugadorDinosaurio INT NOT NULL,
    ID_RecintoDinosaurio INT NOT NULL,
    Especie VARCHAR(10),
    TREX BOOLEAN,
    FOREIGN KEY (ID_JugadorDinosaurio) REFERENCES Jugador (ID_Jugador),
    FOREIGN KEY (ID_RecintoDinosaurio) REFERENCES Recintos (ID_Recinto)
);
