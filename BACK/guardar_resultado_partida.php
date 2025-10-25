<?php
include '../SEGURIDAD/proteccion.php';
session_start();

header('Content-Type: application/json');

// Conexión a la BD
$hostname = "localhost";
$username = "root";
$password = "";
$database = "draftosaurus";

/*
$hostname = "192.168.1.50";
$username = "bd-manager";
$password = "mBdi4#32";
$database = "draftosaurus";
*/

$conn = new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error) {
    die(json_encode(["success" => false, "error" => "Conexión fallida: " . $conn->connect_error]));
}

// Obtener datos del POST
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['id_partida']) || !isset($input['ganador'])) {
    echo json_encode(["success" => false, "error" => "Faltan datos requeridos"]);
    exit;
}

$id_partida = intval($input['id_partida']);
$ganador = $conn->real_escape_string($input['ganador']);
$estado = 'Completado';

// Actualizar la partida con el ganador y estado
$sql = "UPDATE partida_draftosaurus SET jugador_ganador = ?, estado = ? WHERE ID_Partida = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $ganador, $estado, $id_partida);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Partida guardada correctamente"]);
} else {
    echo json_encode(["success" => false, "error" => "Error al guardar: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
