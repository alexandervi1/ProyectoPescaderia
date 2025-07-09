<?php
session_start();
require_once '../config/confConexion.php';

// Confirmar llegada al archivo
$debug = ['paso' => 'Llegué a MAgregarAlCarrito.php'];

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Usuario no autenticado',
        'debug_message' => 'Fallo: sesión no iniciada'
    ]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_POST['producto_id'] ?? null;
$cantidad = $_POST['cantidad'] ?? 1;

// Verificar llegada de datos POST
$debug['usuario_id'] = $usuario_id;
$debug['producto_id'] = $producto_id;
$debug['cantidad'] = $cantidad;

if (!$producto_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID de producto faltante',
        'debug_message' => 'Fallo: producto_id no recibido',
        'debug' => $debug
    ]);
    exit;
}

// Verificar si el producto ya está en el carrito
$query = "SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al preparar SELECT',
        'debug_message' => 'MySQL error en prepare (SELECT)',
        'debug' => $debug
    ]);
    exit;
}

$stmt->bind_param("ii", $usuario_id, $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Ya existe, actualizar cantidad
    $nuevaCantidad = $row['cantidad'] + $cantidad;
    $update = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
    $stmtUpdate = $conn->prepare($update);

    if (!$stmtUpdate) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al preparar UPDATE',
            'debug_message' => 'MySQL error en prepare (UPDATE)',
            'debug' => $debug
        ]);
        exit;
    }

    $stmtUpdate->bind_param("iii", $nuevaCantidad, $usuario_id, $producto_id);
    $stmtUpdate->execute();

    $row['cantidad'] = $nuevaCantidad;
    echo json_encode([
        'status' => 'success',
        'producto' => $row,
        'debug_message' => 'Producto ya existía, cantidad actualizada',
        'debug' => $debug
    ]);
} else {
    // Insertar nuevo registro
    $insert = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($insert);

    if (!$stmtInsert) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al preparar INSERT',
            'debug_message' => 'MySQL error en prepare (INSERT)',
            'debug' => $debug
        ]);
        exit;
    }

    $stmtInsert->bind_param("iii", $usuario_id, $producto_id, $cantidad);
    $stmtInsert->execute();

    // Verificar si se insertó
    if ($stmtInsert->affected_rows > 0) {
        $row = [
            'usuario_id' => $usuario_id,
            'producto_id' => $producto_id,
            'cantidad' => $cantidad
        ];
        echo json_encode([
            'status' => 'success',
            'producto' => $row,
            'debug_message' => 'Producto insertado en carrito',
            'debug' => $debug
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se insertó ningún registro',
            'debug_message' => 'Falló el INSERT',
            'debug' => $debug
        ]);
    }
}
?>
