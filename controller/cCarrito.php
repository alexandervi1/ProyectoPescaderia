<?php
// Iniciar la sesión si aún no está iniciada. Esto es crucial para el carrito.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir la configuración de la conexión a la base de datos (si fuera necesario para futuras funcionalidades del carrito)
// require_once '../config/confConexion.php';
// require_once '../model/mObtDatosProducto.php'; // Si necesitas más datos del producto al agregarlo

// Establecer el tipo de contenido de la respuesta a JSON
header('Content-Type: application/json');

$respuesta = ['exito' => false, 'mensaje' => ''];

// Verificar si la petición es POST y si la acción es 'agregar'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;

    // Validar los datos recibidos
    if ($producto_id > 0 && $cantidad > 0) {
        // Inicializar el carrito en la sesión si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Si el producto ya está en el carrito, actualizar la cantidad
        if (isset($_SESSION['carrito'][$producto_id])) {
            $_SESSION['carrito'][$producto_id]['cantidad'] += $cantidad;
            $respuesta['mensaje'] = 'Cantidad de producto actualizada en el carrito.';
        } else {
            // Si el producto no está, agregarlo
            // Opcional: Podrías buscar el nombre y precio del producto aquí desde la DB
            // Si necesitaras estos datos en el carrito más adelante sin otra consulta.
            // Por ahora, solo guardaremos ID y cantidad.
            $_SESSION['carrito'][$producto_id] = [
                'producto_id' => $producto_id,
                'cantidad' => $cantidad
                // Aquí podrías añadir más detalles si los obtienes de la DB, ej:
                // 'nombre' => $producto['nombre'],
                // 'precio' => $producto['precio']
            ];
            $respuesta['mensaje'] = 'Producto agregado al carrito.';
        }
        $respuesta['exito'] = true;
    } else {
        $respuesta['mensaje'] = 'Datos de producto o cantidad inválidos.';
    }
} else {
    $respuesta['mensaje'] = 'Petición no válida.';
}

// Enviar la respuesta JSON al cliente
echo json_encode($respuesta);

// Para depuración:
// echo '<pre>';
// print_r($_SESSION['carrito']);
// echo '</pre>';