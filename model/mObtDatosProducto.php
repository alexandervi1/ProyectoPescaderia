<?php
// model/mObtDatosProducto.php
include '../config/confConexion.php';

function obtenerDatosProducto($producto_id) {
    global $conn;
    $consulta = "SELECT * FROM producto WHERE producto_id = ?";

    if ($stmt = $conn->prepare($consulta)) {
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            return $resultado->fetch_assoc();
        } else {
            return null;
        }

        $stmt->close();
    } else {
        return null;
    }
}
?>