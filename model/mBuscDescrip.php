<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/confConexion.php");

// Asegurar que no haya salida previa
ob_start();
header('Content-Type: text/plain'); // Devolver solo texto plano

// Verificar conexión a la base de datos
if (!$conn) {
    ob_end_clean();
    echo "ERROR_CONEXION";
    exit;
}

// Verificar si se recibió un ID
if (isset($_GET["id"])) {
    $RecogeOpcion = intval($_GET["id"]); // Convertir a número

    // Consulta para obtener la descripción del producto
    $sql = "SELECT descripcion FROM Producto WHERE producto_id = $RecogeOpcion";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $descripcionProducto = trim($row["descripcion"]); // Descripción del producto

        ob_end_clean();
        echo $descripcionProducto; // Devolver la descripción del producto
        exit;
    } else {
        ob_end_clean();
        echo "PRODUCTO_NO_ENCONTRADO"; // Si no se encuentra el producto
        exit;
    }
} else {
    ob_end_clean();
    echo "ID_NOT_PROVIDED"; // Si no se proporciona el ID
    exit;
}
?>
