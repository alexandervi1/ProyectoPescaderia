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
        $fileName = $_FILES['imagenProducto']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Ruta física del servidor donde se guardará la imagen
            $uploadFileDir = __DIR__ . '/../model/img/';
            $webPath = 'model/img/';

            // Crear carpeta si no existe
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            $finalFileName = basename($fileName);
            $dest_path = $uploadFileDir . $finalFileName;

            // Verifica si ya existe un archivo con el mismo nombre
            if (file_exists($dest_path)) {
                header("Location: ../view/viewIngreso.php?status=error&message=Ya existe una imagen con ese nombre.");
                exit;
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen_url = $webPath . $finalFileName;
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
