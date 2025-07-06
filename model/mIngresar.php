<?php
include("../config/confConexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcionProducto'];
    $precio = $_POST['precioProducto'];
    $stock = $_POST['cantidadProducto'];
    $categoria_id = $_POST['categoriaProducto'];
    $unidad_compra_id = $_POST['unidadCompraProducto'];
    $unidad_venta_id = $_POST['unidadVentaProducto'];

    // Validación simple
    if ($precio < 0 || $stock < 0) {
        header("Location: ../view/viewIngreso.php?status=error&message=Valores negativos no permitidos.");
        exit;
    }

    // Manejo de imagen
    $imagen_url = NULL;
    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagenProducto']['tmp_name'];
        $fileName = $_FILES['imagenProducto']['name']; // Este es el nombre original del archivo
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Guardar imagen en carpeta accesible desde navegador
            $uploadFileDir = '../../img/'; // Subimos desde /model a raíz
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // CAMBIO AQUÍ: Usamos el nombre original del archivo para la ruta de destino.
            // Es crucial considerar que esto puede causar colisiones de nombres si dos usuarios suben archivos con el mismo nombre.
            // Una estrategia común es prefijar el nombre del archivo original con un timestamp o un identificador único.
            // Para tu solicitud actual de usar el nombre original directamente:
            $finalFileName = $fileName; // Usamos el nombre original del archivo
            $dest_path = $uploadFileDir . $finalFileName;

            // Opcional, pero recomendado para evitar sobrescribir si el archivo ya existe:
            // Si el nombre del archivo ya existe, puedes modificarlo (ej: añadir un sufijo _1, _2, etc.)
            // while (file_exists($dest_path)) {
            //     $finalFileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $fileExtension;
            //     $dest_path = $uploadFileDir . $finalFileName;
            // }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen_url = 'img/' . $finalFileName; // Solo se guarda ruta accesible
            } else {
                header("Location: ../view/viewIngreso.php?status=error&message=Error al guardar imagen.");
                exit;
            }
        } else {
            header("Location: ../view/viewIngreso.php?status=error&message=Extensión de imagen no permitida.");
            exit;
        }
    }

    // Insertar en la base de datos
    $query = "INSERT INTO producto (nombre, descripcion, precio, stock, imagen_url, categoria_id, unidad_compra_id, unidad_venta_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddsiii", $nombre, $descripcion, $precio, $stock, $imagen_url, $categoria_id, $unidad_compra_id, $unidad_venta_id);

    if ($stmt->execute()) {
        header("Location: ../view/viewIngreso.php?status=success&message=Producto ingresado correctamente.");
    } else {
        header("Location: ../view/viewIngreso.php?status=error&message=Error al ingresar producto: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
