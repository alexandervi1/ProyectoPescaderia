<?php
include("../config/confConexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombreProducto'];
    $descripcion = $_POST['descripcionProducto'];
    $precio = $_POST['precioProducto'];
    $stock = $_POST['cantidadProducto'];
    // La columna 'descuento' no existe en la tabla 'producto', por lo tanto, se ha eliminado.
    $categoria_id = $_POST['categoriaProducto'];
    $unidad_compra_id = $_POST['unidadCompraProducto']; // Asumiendo que viene del formulario
    $unidad_venta_id = $_POST['unidadVentaProducto'];   // Asumiendo que viene del formulario

    // Validaciones del lado del servidor
    // Se ha eliminado la validación de descuento ya que la columna no existe.
    if ($precio < 0 || $stock < 0) {
        header("Location: ../view/viewIngreso.php?status=error&message=Valores negativos no permitidos para precio o stock.");
        exit;
    }

    // Manejo de la subida de la imagen
    $imagen_url = NULL; // Inicializar a NULL por si no se sube imagen
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
        // Si no se sube una imagen o hay un error, se puede dejar imagen_url como NULL (si la columna lo permite)
        // o manejarlo según tu lógica de negocio.
        // header("Location: ../view/viewIngreso.php?status=error&message=Hubo un error en la subida del archivo o no se seleccionó ninguno.");
        // exit; // Descomentar si la imagen es obligatoria
    }

    // Inserción de datos en la base de datos
    // Se han añadido unidad_compra_id y unidad_venta_id, y se ha eliminado descuento.
    $query = "INSERT INTO producto (nombre, descripcion, precio, stock, imagen_url, categoria_id, unidad_compra_id, unidad_venta_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    // s: nombre (string)
    // s: descripcion (string)
    // d: precio (decimal)
    // d: stock (decimal)
    // s: imagen_url (string)
    // i: categoria_id (integer)
    // i: unidad_compra_id (integer)
    // i: unidad_venta_id (integer)
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssddisii", $nombre, $descripcion, $precio, $stock, $imagen_url, $categoria_id, $unidad_compra_id, $unidad_venta_id);

    if ($stmt->execute()) {
        header("Location: ../view/viewIngreso.php?status=success&message=Producto ingresado exitosamente.");
    } else {
        // Se añade $stmt->error para depuración
        header("Location: ../view/viewIngreso.php?status=error&message=Hubo un error al ingresar el producto en la base de datos: " . $stmt->error);
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
