INSERT INTO usuario (nombre, password)
VALUES
('I.Grassi','1234'),('J.Rios','1434'),('F.Sclavi','1234'),('R.Pelaez','1234');

INSERT INTO jugador (ID_UsuarioJugador)
VALUES
(1),(2),(3),(4);

INSERT INTO administrador (ID_UsuarioAdmin)
VALUES
(1),(2);

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
