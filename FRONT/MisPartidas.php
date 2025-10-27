<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../RECURSOS/CSS/style_REGISTRO.css">
    <title>Mis Partidas - Draftosaurus</title>
       
    <style>
        body {
            background-image: url('../RECURSOS/IMAGENES/fondoInicio.png');
            background-size: cover;
            background-repeat: no-repeat; 
            background-attachment: fixed; 
            background-position: center;
        }
        
        .partidas-container {
            display: flex;
            flex-direction: column;
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 3%;
            margin-top: 3%;
            margin-left: auto;
            margin-right: auto;
            width: 80%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            align-items: center;
            font-family: 'Ubuntu', sans-serif;
            border: 1px solid rgba(255, 255, 255, 0.3); 
        }
        
        .partidas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            width: 100%;
            margin-top: 20px;
        }
        
        .partida-item {
            background: rgba(248, 249, 250, 0.7);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 2px solid rgba(233, 236, 239, 0.5);
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: fit-content;
        }
        
        .partida-item:hover {
            border-color: #007bff;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }
        
        .partida-header {
            margin-bottom: 15px;
        }
        
        .partida-id {
            font-weight: bold;
            color: #007bff;
            font-size: 1.2em;
        }
        
        .partida-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }
        
        .detail-item {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        
        .detail-label {
            font-weight: bold;
            color: #495057;
            font-size: 0.9em;
        }
        
        .detail-value {
            color: #212529;
            margin-top: 5px;
        }
         
        .no-partidas {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }
        
        .no-partidas h3 {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    
    // Verificar que el usuario esté logueado
    if (!isset($_SESSION["ID"]) || !isset($_SESSION["Nombre"])) {
        header("Location: ../FRONT/RegistroPartidas.php");
        exit();
    }
    
    // Configuración de la base de datos
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "draftosaurus";
    
    try {
        $conn = new mysqli($hostname, $username, $password, $database);
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        // Obtener las partidas del usuario
        $stmt = $conn->prepare("SELECT * FROM partida_draftosaurus WHERE id_creador = ? ORDER BY ID_Partida DESC");
        $stmt->bind_param("i", $_SESSION["ID"]);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $partidas = [];
        while ($fila = $resultado->fetch_assoc()) {
            $partidas[] = $fila;
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        $error = "Error al cargar las partidas: " . $e->getMessage();
    }
    ?>
    
    <div class="partidas-container">
        <h1 style="text-align: center; margin-bottom: 30px; color: #333;">
            Partidas pasadas de: <?php echo htmlspecialchars($_SESSION["Nombre"]); ?>
        </h1>
        
        <?php if (isset($error)): ?>
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($partidas)): ?>
            <div class="no-partidas">
                <h3>No tienes partidas registradas</h3>
                <p>No se encontraron partidas para este usuario.</p>
            </div>
        <?php else: ?>
            <div class="partidas-grid">
            <?php foreach ($partidas as $partida): ?>
                <div class="partida-item">
                    <div class="partida-header">
                        <span class="partida-id">Partida #<?php echo $partida['ID_Partida']; ?></span>
                    </div>
                    
                    <div class="partida-details">
                        <div class="detail-item">
                            <div class="detail-label">Número de Jugadores</div>
                            <div class="detail-value"><?php echo $partida['numero_jugadores']; ?> jugadores</div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Jugador Ganador</div>
                            <div class="detail-value">
                                <?php 
                                if ($partida['jugador_ganador']) {
                                    echo htmlspecialchars($partida['jugador_ganador']);
                                } else {
                                    echo "Sin determinar";
                                }
                                ?>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-label">Jugadores Participantes</div>
                            <div class="detail-value">
                                <?php
                                $jugadores = [];
                                for ($i = 1; $i <= 5; $i++) {
                                    $player = "Player" . $i;
                                    if (!empty($partida[$player])) {
                                        $jugadores[] = htmlspecialchars($partida[$player]);
                                    }
                                }
                                echo implode(', ', $jugadores);
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px;">
            <input class="botonsInicio" type="button" value="Regresar al inicio" onclick="window.location.href='../index.php'">
            <input class="botonsInicio" type="button" value="Cerrar Sesión" onclick="window.location.href='../BACK/logout.php'">
        </div>
    </div>
</body>
</html>
