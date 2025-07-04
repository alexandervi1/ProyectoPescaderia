<?php
include("../config/confConexion.php");

header('Content-Type: application/json');

if (isset($_POST['nombre'], $_POST['descuento'], $_POST['categoria'], $_POST['descripcion'], 
          $_POST['imagen_url'], $_POST['precio'], $_POST['stock'], $_POST['producto_id'])
) {
    $producto_id = mysqli_real_escape_string($conn, $_POST['producto_id']);
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descuento = mysqli_real_escape_string($conn, $_POST['descuento']);
    $categoria = mysqli_real_escape_string($conn, $_POST['categoria']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $imagen_url = mysqli_real_escape_string($conn, $_POST['imagen_url']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);

    // Actualizar el registro en la tabla producto
    $sql = "UPDATE producto SET 
                nombre='$nombre', 
                descuento='$descuento', 
                categoria_id='$categoria', 
                descripcion='$descripcion', 
                imagen_url='$imagen_url', 
                precio='$precio', 
                stock='$stock' 
            WHERE producto_id='$producto_id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Registro actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al actualizar el registro: " . mysqli_error($conn)]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Faltan datos para actualizar el registro."]);
}
?>