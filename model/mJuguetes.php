<?php
include("../config/confConexion.php");

function obtenerJuguetesPorCategoria($categoria) {
    global $conn;

    $sql = "SELECT * FROM Producto WHERE categoria_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoria);
    
    if (!$stmt->execute()) {
        error_log("Error al ejecutar la consulta: " . $stmt->error);
        return [];
    }

    $resultado = $stmt->get_result();
    $juguetes = $resultado->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
    return $juguetes;
}
?>