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

if (!$producto_id) {
    echo json_encode(['status' => 'error', 'message' => 'ID de producto faltante.']);
    exit;
}

$query = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $usuario_id, $producto_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Producto eliminado del carrito.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el producto.']);
}

$stmt->close();
$conn->close();
?>