<?php
include '../SEGURIDAD/proteccion.php';
session_start();

// Conexión a la BD

/*
$hostname = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";
*/

$hostname = "192.168.1.50";
$username = "bd-manager";
$password = "mBdi4#32";
$database = "draftosaurus";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (
    isset($_POST['Player1']) && 
    isset($_POST['cantidadJugadores'])
) {
    $num_jugadores = intval($_POST['cantidadJugadores']);

    // Recibe los nombres de los jugadores del formulario
    $player1 = $_POST['Player1'];
    $player2 = !empty($_POST['Player2']) ? $_POST['Player2'] : null;
    $player3 = !empty($_POST['Player3']) ? $_POST['Player3'] : null;
    $player4 = !empty($_POST['Player4']) ? $_POST['Player4'] : null;
    $player5 = !empty($_POST['Player5']) ? $_POST['Player5'] : null;

    $sql = "INSERT INTO partida_draftosaurus 
            (Player1, Player2, Player3, Player4, Player5, numero_jugadores) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $player1, $player2, $player3, $player4, $player5, $num_jugadores);
    

    $_SESSION['jugadores'] = [
        $_POST['Player1'],
        $_POST['Player2'],
        $_POST['Player3'],
        $_POST['Player4'],
        $_POST['Player5']
    ];

    if ($stmt->execute()) {
        $id_partida = $stmt->insert_id; // ID de la nueva partida
        // Redirige a la página del juego con el id de la partida
        header("Location: ../FRONT/Juego.php?id_partida=" . $id_partida);
        exit;
    } else {
        echo "Error al guardar la configuración: " . $stmt->error;
    }
}else {
    echo "Faltan datos del formulario.";
}
?>