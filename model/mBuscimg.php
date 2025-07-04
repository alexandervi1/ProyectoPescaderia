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

    // Consulta para obtener la URL de la imagen
    $sql = "SELECT imagen_url FROM Producto WHERE producto_id = $RecogeOpcion";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $relativePath = trim($row["imagen_url"]); // Ruta en BD (Ej: "./img/1mani.jpg")

        ob_end_clean();
        echo $relativePath; // Devolver URL completa
        exit;
    } else {
        ob_end_clean();
        echo "IMG_NOT_FOUND";
        exit;
    }
} else {
    ob_end_clean();
    echo "ID_NOT_PROVIDED";
    exit;
}
?>




