<?php
session_start();
require_once '../config/confConexion.php';

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_POST['producto_id'] ?? null;
$cantidad = $_POST['cantidad'] ?? null;

if (!$producto_id || $cantidad === null || $cantidad < 1) {
    echo json_encode(['status' => 'error', 'message' => 'Datos inválidos.']);
    exit;
}

$query = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Cantidad actualizada.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la cantidad.']);
}

$stmt->close();
$conn->close();
?>