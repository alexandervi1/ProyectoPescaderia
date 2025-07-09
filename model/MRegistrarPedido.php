<?php
session_start();
require_once '../config/confConexion.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener los productos del carrito
$query = "SELECT producto_id, cantidad FROM carrito WHERE usuario_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$productos = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $productos[] = $row;

    // Obtener el precio de cada producto para calcular el total
    $precioQuery = $conn->prepare("SELECT precio FROM producto WHERE producto_id = ?");
    $precioQuery->bind_param("i", $row['producto_id']);
    $precioQuery->execute();
    $precioResult = $precioQuery->get_result();
    $precioRow = $precioResult->fetch_assoc();
    $total += $row['cantidad'] * $precioRow['precio'];
}

if (count($productos) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Carrito vacío']);
    exit;
}

// Insertar en la tabla pedido
$insertPedido = $conn->prepare("INSERT INTO pedido (usuario_id, total) VALUES (?, ?)");
$insertPedido->bind_param("id", $usuario_id, $total);
$insertPedido->execute();

$pedido_id = $insertPedido->insert_id;

// Insertar en la tabla pedidoproducto
$insertDetalle = $conn->prepare("INSERT INTO pedidoproducto (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");

foreach ($productos as $prod) {
    $insertDetalle->bind_param("iid", $pedido_id, $prod['producto_id'], $prod['cantidad']);
    $insertDetalle->execute();
}

// Vaciar carrito
$conn->prepare("DELETE FROM carrito WHERE usuario_id = ?")->bind_param("i", $usuario_id)->execute();

echo json_encode(['status' => 'success', 'message' => 'Pedido registrado correctamente']);
?>
