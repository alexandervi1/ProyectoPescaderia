<?php
include("../config/confConexion.php");

// Asegúrate de que la conexión a la base de datos sea exitosa
if ($conn->connect_error) {
    header("Location: ../view/ListaProductos.php?status=error&message=" . urlencode("Error de conexión a la base de datos: " . $conn->connect_error));
    exit;
}

// Verifica si todos los datos necesarios han sido enviados mediante POST
if (isset($_POST['producto_id'], $_POST['nombre'], $_POST['categoria_id'], $_POST['descripcion'],
           $_POST['precio'], $_POST['stock'], $_POST['unidad_compra_id'], $_POST['unidad_venta_id'])) {
    
    // Recuperar y sanitizar los datos
    $producto_id        = $_POST['producto_id'];
    $nombre             = $_POST['nombre'];
    $categoria_id       = $_POST['categoria_id'];
    $descripcion        = $_POST['descripcion'];
    $precio             = $_POST['precio'];
    $stock              = $_POST['stock'];
    $unidad_compra_id   = $_POST['unidad_compra_id'];
    $unidad_venta_id    = $_POST['unidad_venta_id'];

    // --- Lógica para manejar la imagen_url ---
    $imagen_url_to_save = null; // Valor por defecto

    // Si se envió un campo 'imagen_url' y NO está vacío, usa ese valor
    // Esto es para el caso de que el formulario tenga un campo de texto para URL de imagen
    if (isset($_POST['imagen_url']) && !empty($_POST['imagen_url'])) {
        $imagen_url_to_save = $_POST['imagen_url'];
    } else {
        // Si no se envió una nueva URL o está vacía,
        // recupera la URL existente de la base de datos para no perderla.
        $sql_get_current_image = "SELECT imagen_url FROM producto WHERE producto_id = ?";
        if ($stmt_get = $conn->prepare($sql_get_current_image)) {
            $stmt_get->bind_param("i", $producto_id);
            $stmt_get->execute();
            $stmt_get->bind_result($existing_image_url);
            $stmt_get->fetch();
            $stmt_get->close();
            $imagen_url_to_save = $existing_image_url; // Usa la URL existente
        } else {
            // Manejar error si no se pudo obtener la imagen actual
            header("Location: ../view/ListaProductos.php?status=error&message=" . urlencode("Error al obtener la imagen actual del producto: " . $conn->error));
            exit();
        }
    }
    // --- Fin lógica imagen_url ---

    // Consulta SQL para actualizar el producto usando placeholders (?)
    $sql = "UPDATE producto SET
                nombre = ?,
                categoria_id = ?,
                descripcion = ?,
                imagen_url = ?,
                precio = ?,
                stock = ?,
                unidad_compra_id = ?,
                unidad_venta_id = ?
            WHERE producto_id = ?";

    // Preparar la sentencia
    if ($stmt = $conn->prepare($sql)) {
        // Vincular parámetros a la sentencia preparada
        // 's' para string, 'i' para integer, 'd' para double (float)
        $stmt->bind_param("sisddiiii",
            $nombre,
            $categoria_id,
            $descripcion,
            $imagen_url_to_save, // <-- ¡Aquí usamos la URL que decidimos guardar!
            $precio,
            $stock,
            $unidad_compra_id,
            $unidad_venta_id,
            $producto_id
        );

        // Ejecutar la sentencia
        if ($stmt->execute()) {
            // Éxito: Redirigir al usuario
            header("Location: ../view/ListaProductos.php?status=success&message=" . urlencode("Registro actualizado correctamente."));
            exit(); // Es importante usar exit() después de un header()
        } else {
            // Error en la ejecución
            header("Location: ../view/ListaProductos.productos?status=error&message=" . urlencode("Error al actualizar el registro: " . $stmt->error));
            exit();
        }

        // Cerrar la sentencia preparada
        $stmt->close();
    } else {
        // Error en la preparación de la sentencia
        header("Location: ../view/ListaProductos.php?status=error&message=" . urlencode("Error al preparar la consulta de actualización: " . $conn->error));
        exit();
    }

} else {
    // Faltan datos POST
    header("Location: ../view/ListaProductos.php?status=error&message=" . urlencode("Faltan datos para actualizar el registro."));
    exit();
}

// Cerrar la conexión a la base de datos (si no se cerró antes en el flujo de errores)
$conn->close();
?>