<?php
session_start();
// Configura MySQLi para reportar errores. Esto es muy útil para depurar.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once '../config/confConexion.php'; // Asegúrate de que esta ruta sea correcta

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

// Array para depuración (eliminar en producción)
$debug = ['paso' => 'Inicio de mAgregarAlCarrito.php'];

try {
    // 1. Validar sesión del usuario
    if (!isset($_SESSION['usuario_id'])) {
        http_response_code(401); // No autorizado
        echo json_encode([
            'status' => 'error',
            'message' => 'Necesitas iniciar sesión para agregar productos al carrito.',
            'debug_message' => 'Fallo: sesión no iniciada'
        ]);
        exit;
    }

    $usuario_id = intval($_SESSION['usuario_id']); // Asegurar que es un entero

    // 2. Obtener y validar datos POST
    // Usar intval() para asegurar que son enteros y evitar inyecciones no SQL
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1;

    $debug['usuario_id'] = $usuario_id;
    $debug['producto_id'] = $producto_id;
    $debug['cantidad'] = $cantidad;

    if ($producto_id <= 0 || $cantidad <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de producto o cantidad inválida.',
            'debug_message' => 'Fallo: producto_id o cantidad no válidos',
            'debug' => $debug
        ]);
        exit;
    }

    // 3. Verificar si el producto ya está en el carrito
    $query_select = "SELECT cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?";
    $stmt_select = $conn->prepare($query_select);

    if (!$stmt_select) {
        // En un entorno de producción, no mostrar $conn->error directamente
        throw new Exception("Error al preparar la consulta de selección: " . $conn->error);
    }

    $stmt_select->bind_param("ii", $usuario_id, $producto_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($row = $result->fetch_assoc()) {
        // 4. Si el producto ya existe, actualizar la cantidad
        $nuevaCantidad = $row['cantidad'] + $cantidad;

        $query_update = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
        $stmt_update = $conn->prepare($query_update);

        if (!$stmt_update) {
            throw new Exception("Error al preparar la consulta de actualización: " . $conn->error);
        }

        $stmt_update->bind_param("iii", $nuevaCantidad, $usuario_id, $producto_id);
        $stmt_update->execute();

        if ($stmt_update->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Cantidad actualizada en el carrito.',
                'nueva_cantidad' => $nuevaCantidad, // Útil para el frontend si necesitas saber la nueva cantidad
                'debug_message' => 'Producto ya existía, cantidad actualizada',
                'debug' => $debug
            ]);
        } else {
            // Esto podría ocurrir si la nueva cantidad es igual a la anterior, o si hubo un problema
            echo json_encode([
                'status' => 'info', // Usar 'info' o 'warning' si no es un error crítico
                'message' => 'La cantidad del producto no cambió o ya era la misma.',
                'debug_message' => 'UPDATE no afectó filas o cantidad ya era la misma',
                'debug' => $debug
            ]);
        }
        $stmt_update->close();
    } else {
        // 5. Si el producto no existe, insertarlo en el carrito
        $query_insert = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($query_insert);

        if (!$stmt_insert) {
            throw new Exception("Error al preparar la consulta de inserción: " . $conn->error);
        }

        $stmt_insert->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        $stmt_insert->execute();

        if ($stmt_insert->affected_rows > 0) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Producto agregado al carrito.',
                'debug_message' => 'Producto insertado en carrito',
                'debug' => $debug
            ]);
        } else {
            throw new Exception("No se insertó ningún registro en el carrito.");
        }
        $stmt_insert->close();
    }

    $stmt_select->close(); // Cerrar el statement de selección

} catch (Exception $e) {
    // Captura cualquier excepción lanzada en el bloque try
    http_response_code(500); // Error interno del servidor
    echo json_encode([
        'status' => 'error',
        'message' => 'Error del servidor: ' . $e->getMessage(),
        'debug_message' => 'Excepción capturada',
        'debug' => $debug
    ]);
} finally {
    // Asegurarse de que la conexión a la base de datos se cierre
    if (isset($conn) && $conn) {
        $conn->close();
    }
}
?>