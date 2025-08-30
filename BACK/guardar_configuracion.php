<?php
include '../SEGURIDAD/proteccion.php';
session_start();

// Conexión a la BD
$servername = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['cantidadJugadores'])) {
    $num_jugadores = intval($_POST['cantidadJugadores']);

    // Jugador que crea la partida
    $player1 = $_SESSION['ID_Jugador']; 

    // Inicializamos los demás jugadores como NULL
    $player2 = $player3 = $player4 = $player5 = NULL;

    // Llenamos los players según la cantidad de jugadores
    // Solo Player1 ya está definido, los demás quedan NULL por ahora
    // Player2 hasta Player5 se irán actualizando cuando los jugadores se unan

    $sql = "INSERT INTO partida_draftosaurus 
            (Player1, Player2, Player3, Player4, Player5, numero_jugadores) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiii", $player1, $player2, $player3, $player4, $player5, $num_jugadores);

    if ($stmt->execute()) {
        $id_partida = $stmt->insert_id; // ID de la nueva partida
        header("Location: ../FRONT/Juego.php?id_partida=" . $id_partida);
        exit;
    } else {
        echo "Error al guardar la configuración: " . $stmt->error;
    }
}
?>
