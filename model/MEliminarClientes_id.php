<?php
// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

if (isset($_GET['usuario_id'])) {
    $usuario_id = intval($_GET['usuario_id']); // Sanitizar a entero

    // Preparar la consulta para eliminar
    $stmt = $conn->prepare("DELETE FROM usuario WHERE usuario_id = ? AND rol_id = 2"); // Asegurarse de eliminar solo clientes
    $stmt->bind_param("i", $usuario_id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la lista de clientes con un mensaje de éxito
        header("Location: ../view/ListaClientes.php?success=deleted");
    } else {
        // Redirigir con un mensaje de error
        header("Location: ../view/ListaClientes.php?error=delete_failed");
    }

    $stmt->close();
} else {
    // Si no se proporcionó un ID, redirigir a la lista con un error
    header("Location: ../view/ListaClientes.php?error=no_id");
}

$conn->close();
exit(); // Es crucial salir después de un header()
?>