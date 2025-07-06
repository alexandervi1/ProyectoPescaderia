<?php
// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

// =========================================================================
// LÓGICA DE BÚSQUEDA Y REDIRECCIÓN
// =========================================================================

// Verificar si se ha proporcionado un ID de producto en la URL y no está vacío
if (isset($_GET['producto_id']) && !empty($_GET['producto_id'])) {
    // Sanitizar y validar el ID del producto para seguridad
    $producto_id = intval($_GET['producto_id']); // Convierte a entero

    // Preparar la consulta para buscar el producto de forma segura
    // Solo necesitamos el producto_id para verificar si existe
    $stmt = mysqli_prepare($conn, "SELECT producto_id FROM producto WHERE producto_id = ?");
    
    // Si la preparación de la sentencia falla, mostrar error
    if ($stmt === false) {
        echo "Error al preparar la consulta: " . mysqli_error($conn);
        exit();
    }

    // Vincular el parámetro del ID ( 'i' indica que es un entero)
    mysqli_stmt_bind_param($stmt, "i", $producto_id); 
    
    // Ejecutar la consulta preparada
    mysqli_stmt_execute($stmt);
    
    // Almacenar el resultado para poder verificar el número de filas
    mysqli_stmt_store_result($stmt); 

    // Verificar si se encontró al menos un registro
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Si el producto se encontró, redirigir a la página de edición
        // Usamos 'producto_id' en la URL, consistente con el formulario de edición.
        header("Location: ../view/editar.php?producto_id=" . $producto_id);
        exit(); // Es fundamental llamar a exit() después de un header()
    } else {
        // Si no se encontró el registro
        echo "No se encontró el registro correspondiente para el ID: " . htmlspecialchars($producto_id) . ".";
    }
    
    // Cerrar la sentencia preparada
    mysqli_stmt_close($stmt); 
} else {
    // Si no se proporcionó un ID de producto válido o está vacío
    echo "Error: No se proporcionó un ID de producto válido.";
}

// Cierre de la conexión a la base de datos
mysqli_close($conn);
?>