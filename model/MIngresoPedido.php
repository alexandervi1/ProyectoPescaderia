<?php
session_start();
require_once '../config/confConexion.php';
 
header('Content-Type: application/json');
 
$input = json_decode(file_get_contents("php://input"), true);
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}
 
$usuario_id = $_SESSION['usuario_id'];
 
if ($input['accion'] === 'registrar_pedido') {
    try {
        $conn->begin_transaction();
 
        // 1. Crear pedido
        $stmt = $conn->prepare("INSERT INTO pedido (usuario_id) VALUES (?)");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $pedido_id = $stmt->insert_id;
 
        // 2. Obtener productos del carrito
        $query = "SELECT producto_id, cantidad FROM carrito WHERE usuario_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
 
        if ($result->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'El carrito está vacío']);
            $conn->rollback();
            exit;
        }
 
        $productos = $result->fetch_all(MYSQLI_ASSOC);
 
        // 3. Insertar en pedidoproducto
       // 3. Insertar en pedidoproducto y actualizar stock
$stmtInsert = $conn->prepare("INSERT INTO pedidoproducto (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)");
$stmtStock = $conn->prepare("UPDATE producto SET stock = stock - ? WHERE producto_id = ?");
 
foreach ($productos as $prod) {
    $producto_id = $prod['producto_id'];
    $cantidad_vendida = $prod['cantidad'];
 
    // Obtener unidad_compra, unidad_venta y factor_conversion
    $stmtInfo = $conn->prepare("SELECT unidad_compra_id, unidad_venta_id, factor_conversion FROM producto WHERE producto_id = ?");
    $stmtInfo->bind_param("i", $producto_id);
    $stmtInfo->execute();
    $info = $stmtInfo->get_result()->fetch_assoc();
 
    $unidad_compra = $info['unidad_compra_id'];
    $unidad_venta = $info['unidad_venta_id'];
    $factor = floatval($info['factor_conversion']);
 
    // Determinar cuánto descontar
    if ($unidad_compra == 1 && $unidad_venta == 2) {
        // Tonelada a libra
        $cantidad_convertida = $cantidad_vendida / $factor;
    } elseif ($unidad_compra == 3 && $unidad_venta == 3) {
        // Unidad a unidad
        $cantidad_convertida = $cantidad_vendida;
    } else {
        // Cualquier otra combinación
        $cantidad_convertida = $cantidad_vendida / max($factor, 1);
    }
 
    // Insertar en pedidoproducto
    $stmtInsert->bind_param("iid", $pedido_id, $producto_id, $cantidad_vendida);
    $stmtInsert->execute();
 
    // Actualizar stock
    $stmtStock->bind_param("di", $cantidad_convertida, $producto_id);
    $stmtStock->execute();
}
 
 
        // 4. Vaciar el carrito
        $stmt = $conn->prepare("DELETE FROM carrito WHERE usuario_id = ?");
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
 
        $conn->commit();
        echo json_encode(['success' => true, 'pedido_id' => $pedido_id]);
 
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error al registrar pedido: ' . $e->getMessage()]);
    }
}
?>
 