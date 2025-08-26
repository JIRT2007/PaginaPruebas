INSERT INTO usuario (nombre, password)
VALUES
('I.Grassi',1234),('J.Rios',1434),('F.Sclavi',1234),('R.Pelaez',1234);

INSERT INTO jugador (ID_UsuarioJugador)
VALUES
(1),(2),(3),(4);

INSERT INTO administrador (ID_UsuarioAdmin)
VALUES
(1),(2);

INSERT INTO partida_draftosaurus (Player1, Player2, Player3, Player4, jugador_ganador, numero_jugadores, estado)
VALUES
(1, 2, 3, 4, 2, 4, 'Completado');

INSERT INTO dado (CaraDado, ID_JugadorDado, ID_PartidaDado)
VALUES
-- Jugador 1
('Zona izquierda del parque', 1, 1),
('Zona de bosque', 1, 1),

-- Jugador 2
('Recinto vacio', 2, 1),
('Zona de rocas', 2, 1),

-- Jugador 3
('Zona derecha del parque', 3, 1),
('Recinto sin REX', 3, 1),

-- Jugador 4
('Zona de bosque', 4, 1),
('Zona izquierda del parque', 4, 1);

INSERT INTO ronda (ID_PartidaRonda, NumRonda)
VALUES
(1, 1),(1, 2);

INSERT INTO turnos (ID_JugadorTurnos)
VALUES
(1),(2),(3),(4);

INSERT INTO turnos (ID_JugadorTurnos)
VALUES
(1),(2),(3),(4);

INSERT INTO recintos (ID_TableroRecinto)
VALUES
(1),(2),(3),(4),(5),(6),(7);

INSERT INTO dinosaurios (ID_JugadorDinosaurio, ID_RecintoDinosaurio, Especie, TREX)
VALUES

--Ronda 1
(1, 4, 'TREX', TRUE),
(1, 2, 'Triceratops', FALSE),
(1, 2, 'Stegosaurus', FALSE),
(2, 6, 'Parasaurolophus', FALSE),
(2, 2, 'Brachiosaurus', FALSE),
(2, 3, 'Velociraptor', FALSE),
--Ronda 2
(1, 4, 'TREX', TRUE),
(1, 2, 'Triceratops', FALSE),
(1, 2, 'Stegosaurus', FALSE),
(2, 1, 'Parasaurolophus', FALSE),
(2, 2, 'Brachiosaurus', FALSE),
(2, 3, 'Velociraptor', FALSE):

