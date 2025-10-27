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


-- CREATE TABLE administrador(
--     ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
--     ID_UsuarioAdmin INT NOT NULL,
--     FOREIGN KEY (ID_UsuarioAdmin) REFERENCES usuario (ID_Usuario) 
-- );

-- CREATE TABLE partida_draftosaurus (
--     ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
--     ID_JugadorPartida INT NOT NULL,
--     jugador_ganador INT,
--     numero_jugadores INT NOT NULL,
--     estado VARCHAR(20) NOT NULL DEFAULT 'pendiente',
--     FOREIGN KEY (ID_JugadorPartida) REFERENCES usuario(ID_Usuario),
--     FOREIGN KEY (jugador_ganador) REFERENCES jugador (ID_Jugador)
-- );

CREATE TABLE partida_draftosaurus (
    ID_Partida INT AUTO_INCREMENT PRIMARY KEY,
    Player1 VARCHAR(30),
    Player2 VARCHAR(30),
    Player3 VARCHAR(30),
    Player4 VARCHAR(30),
    Player5 VARCHAR(30),
    jugador_ganador VARCHAR(30),
    numero_jugadores INT NOT NULL,
    id_creador INT,
    estado VARCHAR(50) NOT NULL DEFAULT 'pendiente',
    FOREIGN KEY (id_creador) REFERENCES usuario (ID_Usuario) ON DELETE CASCADE
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

INSERT INTO usuario (nombre, password) VALUES
('I.Grassi','$2y$10$M6/7E1fVbYgVbT.csmJjruuV6zF7Q02uZgByU2NfP3n9B8rQ7L5v2'),
('J.Rios','$2y$10$U4BB8xWfA7Hn16TknQdQwOs2sN6xPzXMTL.tTQgwJzj0hPQ0hB0Lu'),
('F.Sclavi','$2y$10$M6/7E1fVbYgVbT.csmJjruuV6zF7Q02uZgByU2NfP3n9B8rQ7L5v2'),
('R.Pelaez','$2y$10$M6/7E1fVbYgVbT.csmJjruuV6zF7Q02uZgByU2NfP3n9B8rQ7L5v2');

INSERT INTO jugador (ID_UsuarioJugador)
VALUES
(1),(2),(3),(4);

INSERT INTO administrador (Nombre, Password) 
VALUES ('BrontoADMINISTRADOR', 'SecureADMINbgs2025');


INSERT INTO partida_draftosaurus (Player1, Player2, Player3, Player4, jugador_ganador, numero_jugadores, estado)
VALUES
(1, 2, 3, 4, 2, 4, 'Completado');

INSERT INTO tablero (ID_PartidaTablero, ID_JugadorTablero)
VALUES
(1,1),(1,2),(1,3),(1,4);

INSERT INTO recintos (ID_TableroRecinto)
VALUES
(1),(1),(1),(1),(1),(1),(1);

INSERT INTO dado (CaraDado, ID_JugadorDado, ID_PartidaDado)
VALUES
('Zona izquierda del parque', 1, 1),
('Recinto vacío', 2, 1),
('Zona derecha del parque', 3, 1),
('Zona de bosque', 4, 1),
('Zona de rocas', 1, 1),
('Recinto sin REX', 2, 1),
('Zona izquierda del parque', 3, 1),
('Zona de bosque', 4, 1),
('Recinto vacío', 1, 1),
('Zona derecha del parque', 2, 1),
('Zona de rocas', 3, 1),
('Recinto sin REX', 4, 1);


INSERT INTO ronda (ID_PartidaRonda, NumRonda)
VALUES
(1, 1),(1, 2);

INSERT INTO turnos (ID_JugadorTurnos)
VALUES
(1),(2),(3),(4);

INSERT INTO turnos (ID_JugadorTurnos)
VALUES
(1),(2),(3),(4),(1),(2),(3),(4);

INSERT INTO dinosaurios (ID_JugadorDinosaurio, ID_RecintoDinosaurio, Especie, TREX)
VALUES
-- Ronda 1
(1,4,'TREX',TRUE),
(2,2,'Triceratops',FALSE),
(3,1,'Stegosaurus',FALSE),
(4,3,'Parasaurolophus',FALSE),

(1,6,'Parasaurolophus',FALSE),
(2,5,'TREX',TRUE),
(3,7,'Brachiosaurus',FALSE),
(4,2,'Triceratops',FALSE),

(1,6,'Triceratops',FALSE),
(2,7,'Velociraptor',FALSE),
(3,2,'TREX',TRUE),
(4,5,'Stegosaurus',FALSE),

(1,7,'Parasaurolophus',FALSE),
(2,6,'Triceratops',FALSE),
(3,4,'Velociraptor',FALSE),
(4,1,'TREX',TRUE),

(1,4,'Parasaurolophus',FALSE),
(2,5,'Parasaurolophus',FALSE),
(3,4,'Triceratops',FALSE),
(4,5,'Stegosaurus',FALSE),

(1,2,'Triceratops',FALSE),
(2,7,'Parasaurolophus',FALSE),
(3,6,'Brachiosaurus',FALSE),
(4,3,'Velociraptor',FALSE),

-- Ronda 2
(1,1,'TREX',TRUE),
(2,2,'Stegosaurus',FALSE),
(3,6,'Parasaurolophus',FALSE),
(4,3,'Brachiosaurus',FALSE),

(1,7,'Triceratops',FALSE),
(2,6,'Velociraptor',FALSE),
(3,7,'Parasaurolophus',FALSE),
(4,2,'TREX',TRUE),

(1,5,'Parasaurolophus',FALSE),
(2,3,'Triceratops',FALSE),
(3,1,'Stegosaurus',FALSE),
(4,4,'Velociraptor',FALSE),

(1,6,'Parasaurolophus',FALSE),
(2,4,'TREX',TRUE),
(3,5,'Parasaurolophus',FALSE),
(4,7,'Stegosaurus',FALSE),

(1,4,'Velociraptor',FALSE),
(2,5,'Parasaurolophus',FALSE),
(3,2,'Stegosaurus',FALSE),
(4,4,'Parasaurolophus',FALSE),

(1,3,'Stegosaurus',FALSE),
(2,1,'Parasaurolophus',FALSE),
(3,7,'Velociraptor',FALSE),
(4,6,'Brachiosaurus',FALSE);