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
            // **CAMBIO CRÍTICO AQUÍ:**
            // Ruta física ABSOLUTA en el servidor donde se guardará la imagen.
            // '__DIR__' es el directorio de mIngresar.php (que está en 'model/').
            // '../' sube un nivel (a la raíz de 'tu_proyecto/').
            // '/public/img/' entra a la nueva carpeta pública de imágenes.
            $uploadFileDir = __DIR__ . '/../public/img/';

            // **CAMBIO CRÍTICO AQUÍ:**
            // Ruta URL RELATIVA que el navegador usará para acceder a la imagen.
            // Esta es la URL que se guardará en tu base de datos y se enviará al JavaScript.
            $webPath = 'public/img/';

            // Crear carpeta si no existe
            if (!is_dir($uploadFileDir)) {
                // Asegúrate de que PHP tenga permisos para crear esta carpeta.
                // El 'true' en mkdir permite la creación recursiva de directorios.
                if (!mkdir($uploadFileDir, 0777, true)) { 
                    header("Location: ../view/viewIngreso.php?status=error&message=Error al crear la carpeta de imágenes.");
                    exit;
                }
            }

            $finalFileName = basename($fileName);
            $dest_path = $uploadFileDir . $finalFileName;

            // Verifica si ya existe un archivo con el mismo nombre
            if (file_exists($dest_path)) {
                header("Location: ../view/viewIngreso.php?status=error&message=Ya existe una imagen con ese nombre.");
                exit;
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen_url = $webPath . $finalFileName; // ¡Aquí se guarda la URL pública!
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
    // La $imagen_url ahora contendrá la ruta pública (ej: '/public/img/nombre.jpg')
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