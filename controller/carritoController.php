<?php
session_start(); // Inicia la sesión al principio de todo
header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

require_once '../config/database.php'; // Asegúrate de que esta ruta a tu archivo de conexión sea correcta

// Habilitar reporte de errores para depuración (quitar en producción)
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Verificar la conexión a la base de datos inmediatamente
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos: ' . $conn->connect_error]);
    exit;
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Manejar solicitudes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verificar si se solicita una acción específica (aunque en GET solo esperamos 'obtener')
    $accion = $_GET['accion'] ?? '';

    if ($accion === 'obtener') {
        // Incluir p.imagen_url para que el frontend pueda mostrar las imágenes
        $sql = "SELECT c.carrito_id, c.usuario_id, c.producto_id, c.cantidad, 
                       p.nombre, p.precio, p.imagen_url 
                FROM carrito c
                JOIN producto p ON c.producto_id = p.producto_id
                WHERE c.usuario_id = ?";

        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta GET: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            // Asegurarse de que la imagen_url sea una ruta válida o un placeholder
            $row['imagen_url'] = $row['imagen_url'] ?? 'https://placehold.co/80x80?text=Producto';
            $productos[] = $row;
        }

        // Si el carrito está vacío, se devuelve un status 'success' con un array vacío
        echo json_encode(['status' => 'success', 'productos' => $productos]);
        $stmt->close();
        $conn->close();
        exit;
    } else {
        // Acción GET inválida
        echo json_encode(['status' => 'error', 'message' => 'Acción GET inválida.']);
        $conn->close();
        exit;
    }
}

// Manejar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;

    if ($producto_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'ID de producto inválido.']);
        $conn->close();
        exit;
    }

    switch ($accion) {
        case 'eliminar':
            $sql = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta DELETE: ' . $conn->error]);
                exit;
            }

            $stmt->bind_param("ii", $usuario_id, $producto_id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Producto eliminado del carrito.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el producto: ' . $stmt->error]);
            }
            break;

        case 'actualizar':
            $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

            if ($cantidad <= 0) {
                // Si la cantidad es 0 o menos, eliminar el producto del carrito
                $sql = "DELETE FROM carrito WHERE usuario_id = ? AND producto_id = ?";
                $stmt = $conn->prepare($sql);
                
                if ($stmt === false) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta DELETE (actualizar): ' . $conn->error]);
                    exit;
                }

                $stmt->bind_param("ii", $usuario_id, $producto_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Producto eliminado del carrito por cantidad cero.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo eliminar el producto por cantidad cero: ' . $stmt->error]);
                }
            } else {
                // Actualizar la cantidad del producto en el carrito
                $sql = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
                $stmt = $conn->prepare($sql);
                
                if ($stmt === false) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta UPDATE: ' . $conn->error]);
                    exit;
                }

                $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Cantidad del producto actualizada.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la cantidad: ' . $stmt->error]);
                }
            }
            break;

        case 'agregar': // Añadir acción para agregar productos (si tu frontend la usa)
            $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 1; // Cantidad por defecto 1

            // Primero, verificar si el producto ya está en el carrito
            $sql_check = "SELECT cantidad FROM carrito WHERE usuario_id = ? AND producto_id = ?";
            $stmt_check = $conn->prepare($sql_check);
            if ($stmt_check === false) {
                echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de verificación: ' . $conn->error]);
                exit;
            }
            $stmt_check->bind_param("ii", $usuario_id, $producto_id);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if ($row_check = $result_check->fetch_assoc()) {
                // El producto ya existe, actualizar la cantidad
                $nueva_cantidad = $row_check['cantidad'] + $cantidad;
                $sql_update = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
                $stmt_update = $conn->prepare($sql_update);
                if ($stmt_update === false) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de actualización (agregar): ' . $conn->error]);
                    exit;
                }
                $stmt_update->bind_param("iii", $nueva_cantidad, $usuario_id, $producto_id);
                if ($stmt_update->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Cantidad del producto actualizada en el carrito.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo actualizar la cantidad al agregar: ' . $stmt_update->error]);
                }
                $stmt_update->close();
            } else {
                // El producto no existe, insertarlo
                $sql_insert = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                if ($stmt_insert === false) {
                    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta de inserción: ' . $conn->error]);
                    exit;
                }
                $stmt_insert->bind_param("iii", $usuario_id, $producto_id, $cantidad);
                if ($stmt_insert->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Producto agregado al carrito.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se pudo agregar el producto al carrito: ' . $stmt_insert->error]);
                }
                $stmt_insert->close();
            }
            $stmt_check->close();
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Acción POST inválida.']);
            break;
    }
    $stmt->close(); // Cerrar el statement si se usó en el switch
    $conn->close();
    exit;
}

// Respuesta por defecto si no se reconoce la solicitud
echo json_encode(['status' => 'error', 'message' => 'Solicitud no reconocida.']);
$conn->close();
?>
