<?php
include("../config/confConexion.php");

$idProducto = $_GET['producto_id'];

 // Validar que el parámetro no esté vacío
if (!empty($idProducto)) {
            $deleteSql = "DELETE FROM producto WHERE producto_id = '$idProducto'";
            if (mysqli_query($conn, $deleteSql)) {
                echo "Registro eliminado correctamente.";
            } else {
                echo "Error al eliminar el registro: " . mysqli_error($conn);
            }
        } else {
            echo "identificador de producto no válido.";
        }
?>