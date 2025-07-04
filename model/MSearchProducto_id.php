<?php
include("../config/confConexion.php");

$producto_id = $_GET['producto_id'];
if (!empty($producto_id)) {
    $searchSql = "SELECT * FROM producto WHERE producto_id = '$producto_id'";
    $result = mysqli_query($conn, $searchSql);

if (mysqli_num_rows($result) > 0) {
    $registro = mysqli_fetch_assoc($result);
    echo "Registro encontrado: " . $registro['nombre'] . " " . $registro['descuento'] . " " . 
    $registro['categoria_id'] . " " .$registro['descripcion'] . " " .$registro['imagen_url'] . " " .
    $registro['precio'] . " " .$registro['stock'];
    header("Location: ../view/editar.php?id_producto=" . $producto_id);
}else{
    echo "No se encontró el registro correspondiente.";
}
} else {
    echo "Error: Clave no valida.";
}
?>