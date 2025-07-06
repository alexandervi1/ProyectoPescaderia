<?php
// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recuperar y sanitizar/validar los datos del POST
    $usuario_id = intval($_POST['usuario_id'] ?? 0);
    $nombreCompleto = trim($_POST['nombre_completo'] ?? '');
    $nombreUsuario = trim($_POST['nombre_usuario'] ?? ''); // Opcional, si el nombre de usuario es editable
    $direccion = trim($_POST['direccion'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    // La contraseña no se edita directamente aquí a menos que tengas un campo específico para ello.
    // Si no se envía, no se actualiza. Si se envía, debes hashearla.

    // 2. Validar que los campos obligatorios no estén vacíos y que el ID sea válido
    if ($usuario_id <= 0 || empty($nombreCompleto) || empty($nombreUsuario) || empty($direccion) || empty(trim($correo))) {
        header("Location: ../view/ListarClientes.php?error=invalid_data");
        exit();
    }

    // Opcional: Validación básica de formato de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../view/ListarClientes.php?error=invalid_email");
        exit();
    }

    // 3. Preparar la consulta SQL para actualizar el usuario
    $stmt = $conn->prepare("UPDATE usuario SET nombre_completo = ?, nombre_usuario = ?, direccion = ?, correo = ?, telefono = ? WHERE usuario_id = ? AND rol_id = 2");
    // Asumiendo que el nombre_usuario también se puede editar. Si no, quítalo del UPDATE.

    if (!$stmt) {
        header("Location: ../view/ListarClientes.php?error=prepare_failed");
        exit();
    }

    $stmt->bind_param("sssssi", $nombreCompleto, $nombreUsuario, $direccion, $correo, $telefono, $usuario_id);

    if ($stmt->execute()) {
        header("Location: ../view/ListarClientes.php?success=updated");
    } else {
        header("Location: ../view/ListarClientes.php?error=update_failed");
    }

    $stmt->close();
} else {
    // Si la solicitud no es POST, redirigir
    header("Location: ../view/ListarClientes.php?error=method_not_allowed");
}

$conn->close();
exit();
?>