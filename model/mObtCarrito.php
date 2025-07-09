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

// Consulta para obtener los productos del carrito con sus detalles
$query = "
    SELECT 
        c.producto_id,
        p.nombre AS nombre_producto,
        p.precio,
        c.cantidad,
        p.imagen_url,
        (p.precio * c.cantidad) AS subtotal
    FROM 
        carrito c
    JOIN 
        producto p ON c.producto_id = p.producto_id
    WHERE 
        c.usuario_id = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$productos_carrito = [];
$total_carrito = 0;

while ($row = $result->fetch_assoc()) {
    $productos_carrito[] = $row;
    $total_carrito += $row['subtotal'];
}

echo json_encode([
    'status' => 'success',
    'productos' => $productos_carrito,
    'total' => $total_carrito
]);

$stmt->close();
$conn->close();
?>