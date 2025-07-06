<?php
// model/mObtDatosProducto.php
include '../config/confConexion.php';

function obtenerDatosProducto($producto_id) {
    global $conn;
    $consulta = "SELECT * FROM producto WHERE producto_id = ?";
    $stmt = $conn->prepare($consulta);
    if ($stmt) {
        $stmt->bind_param("i", $producto_id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        if ($resultado && $resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            $stmt->close();
            return $fila;
        } else {
            $stmt->close();
            return null;
        }
    } else {
        return null;
    }
}