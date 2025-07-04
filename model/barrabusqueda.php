<?php
// Habilitar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/confConexion.php");

// Asegurar que no haya salida previa
ob_start();
header('Content-Type: application/json'); // Devolver JSON

// Verificar conexión a la base de datos
if (!$conn) {
    ob_end_clean();
    echo json_encode(["error" => "ERROR_CONEXION"]);
    exit;
}

// Verificar si se recibió una consulta
if (isset($_GET["query"])) {
    $query = $_GET["query"];
    $query = mysqli_real_escape_string($conn, $query); // Escapar la consulta para evitar inyecciones SQL

    // Consulta para obtener los nombres y IDs de los productos que coincidan con la consulta
    $sql = "SELECT nombre, producto_id FROM Producto WHERE nombre LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $productos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $productos[] = ["nombre" => trim($row["nombre"]), "producto_id" => $row["producto_id"]];
        }
        ob_end_clean();
        echo json_encode($productos); // Devolver los nombres e IDs de los productos en formato JSON
        exit;
    } else {
        ob_end_clean();
        echo json_encode(["error" => "PRODUCTOS_NO_ENCONTRADOS"]); // Si no se encuentran productos
        exit;
    }
} else {
    ob_end_clean();
    echo json_encode(["error" => "QUERY_NOT_PROVIDED"]); // Si no se proporciona la consulta
    exit;
}
?>
