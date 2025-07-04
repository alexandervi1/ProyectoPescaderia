<?php
include("../config/confConexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descuento = $_POST['descuento'];
    $categoria_id = $_POST['categoria'];

    // Validaciones del lado del servidor
    if (empty($producto_id) || empty($nombre) || empty($descripcion) || empty($precio) || empty($stock) || empty($descuento) || empty($categoria_id)) {
        header("Location: ../view/viewAdquisiciones.php?status=error&message=Faltan datos para actualizar el registro.");
        exit;
    }

    if ($descuento < 0 || $precio < 0 || $stock < 0) {
        header("Location: ../view/viewAdquisiciones.php?status=error&message=Valores negativos no permitidos.");
        exit;
    }

    // Actualización de datos en la base de datos
    $query = "UPDATE producto SET nombre=?, descripcion=?, precio=?, stock=?, descuento=?, categoria_id=? WHERE producto_id=?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        header("Location: ../view/viewAdquisiciones.php?status=error&message=Error en la preparación de la consulta.");
        exit;
    }
    $stmt->bind_param("ssdiisi", $nombre, $descripcion, $precio, $stock, $descuento, $categoria_id, $producto_id);

    if ($stmt->execute()) {
        header("Location: ../view/viewAdquisiciones.php?status=success&message=Producto actualizado exitosamente.");
    } else {
        header("Location: ../view/viewAdquisiciones.php?status=error&message=Hubo un error al actualizar el producto en la base de datos.");
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>