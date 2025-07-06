<?php
// Este archivo actúa como un puente si MSearchProducto_id.php solo redirige.
// Si MSearchProducto_id.php realiza alguna lógica compleja de búsqueda
// antes de mostrar el formulario, esa lógica debería replicarse aquí.

if (isset($_GET['usuario_id'])) {
    $usuario_id = htmlspecialchars($_GET['usuario_id']);
    // Simplemente redirigimos a la página de edición con el ID del usuario
    header("Location: ../view/editar_cliente.php?usuario_id=" . $usuario_id);
    exit();
} else {
    // Si no se proporciona un ID, redirigir a la lista de clientes o mostrar un error
    header("Location: ../view/ListaClientes.php?error=no_id_provided");
    exit();
}
?>