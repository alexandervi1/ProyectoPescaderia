<?php
include '../config/confConexion.php';    
header('Content-Type: application/json'); // Asegurar respuesta JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    
    // Asegúrate de que la tabla y el campo sean correctos en la BD
    $consulta = "SELECT rol_id FROM usuario WHERE nombre_usuario = ?";
    
    if ($stmt = $conn->prepare($consulta)) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            echo json_encode(['rol_id' => $fila['rol_id']]);
        } else {
            echo json_encode(['rol_id' => 3]); // Si no existe, es visitante
        }
        
        $stmt->close();
    } else {
        echo json_encode(['error' => 'Error en la consulta']);
    }
}

$conn->close();
exit;
?>
