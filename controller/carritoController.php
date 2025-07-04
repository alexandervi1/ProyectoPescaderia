<?php
session_start();
require_once '../config/database.php'; // Asegúrate de que la conexión a la base de datos es correcta

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
echo json_encode(['status' => 'debug', 'usuario_id' => $usuario_id]);
exit;

if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos']));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sql = "SELECT c.carrito_id, c.usuario_id, c.producto_id, c.cantidad, 
                   p.nombre, p.precio 
            FROM carrito c
            JOIN producto p ON c.producto_id = p.producto_id
            WHERE c.usuario_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }

    if (empty($productos)) {
        echo json_encode(['status' => 'error', 'message' => 'El carrito está vacío o no se encontraron productos para este usuario']);
        exit;
    }

    echo json_encode(['status' => 'success', 'productos' => $productos]);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
    if (!isset($_POST['producto_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'ID de producto faltante']);
        exit;
    }

    $producto_id = intval($_POST['producto_id']);
    $sql = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $producto_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Producto eliminado del carrito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el producto']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Solicitud inválida']);
$conn->close();
?>
