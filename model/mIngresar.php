<?php
include("../config/confConexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcionProducto'];
    $precio = $_POST['precioProducto'];
    $stock = $_POST['cantidadProducto'];
    $descuento = $_POST['descuentoProducto'];
    $categoria_id = $_POST['categoriaProducto'];

    // Validaciones del lado del servidor
    if ($descuento < 0 || $precio < 0 || $stock < 0) {
        header("Location: ../view/viewIngreso.php?status=error&message=Valores negativos no permitidos.");
        exit;
    }

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagenProducto']['tmp_name'];
        $fileName = $_FILES['imagenProducto']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Permitir solo ciertas extensiones de archivo
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Directorio donde se guardará el archivo subido
            $uploadFileDir = './img/';
            $dest_path = $uploadFileDir . $fileName;

            // Verificar si el directorio existe, si no, crearlo
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen_url = $dest_path;
            } else {
                header("Location: ../view/viewIngreso.php?status=error&message=Hubo un error al mover el archivo subido.");
                exit;
            }
        } else {
            header("Location: ../view/viewIngreso.php?status=error&message=Tipo de archivo no permitido.");
            exit;
        }
    } else {
        header("Location: ../view/viewIngreso.php?status=error&message=Hubo un error en la subida del archivo.");
        exit;
    }

    // Inserción de datos en la base de datos
    $query = "INSERT INTO producto (nombre, descripcion, precio, stock, descuento, imagen_url, categoria_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiiss", $nombre, $descripcion, $precio, $stock, $descuento, $imagen_url, $categoria_id);

    if ($stmt->execute()) {
        header("Location: ../view/viewIngreso.php?status=success&message=Producto ingresado exitosamente.");
    } else {
        header("Location: ../view/viewIngreso.php?status=error&message=Hubo un error al ingresar el producto en la base de datos.");
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>