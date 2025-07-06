<?php
session_start();
include '../config/confConexion.php'; // Asegúrate de que esta ruta sea correcta

// Asegúrate de que la conexión a la base de datos sea exitosa
if ($conn->connect_error) {
    // Si la conexión falla, respondemos con JSON para que el frontend pueda capturarlo
    echo json_encode(["success" => false, "message" => "Error de conexión a la base de datos: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recuperar y sanitizar/validar los datos del POST
    $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';
    $direccion = trim($_POST['direccion'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $rol_id = 2; // Por defecto, los nuevos registros son clientes

    // 2. Validar que los campos obligatorios no estén vacíos
    if (empty($nombreCompleto) || empty($usuario) || empty($password) || empty($direccion) || empty(trim($correo))) { // Añadido trim para correo
        echo json_encode(["success" => false, "message" => "Por favor, complete todos los campos obligatorios."]);
        exit;
    }

    // Opcional: Validación básica de formato de correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "El formato del correo electrónico no es válido."]);
        exit;
    }

    // 3. Verificar si el usuario ya existe
    $stmt_check_user = $conn->prepare("SELECT usuario_id FROM usuario WHERE nombre_usuario = ?");
    if (!$stmt_check_user) {
        echo json_encode(["success" => false, "message" => "Error interno al verificar usuario. Por favor, intente de nuevo más tarde."]);
        exit;
    }
    $stmt_check_user->bind_param("s", $usuario);
    $stmt_check_user->execute();
    $stmt_check_user->store_result();

    if ($stmt_check_user->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El nombre de usuario ya está en uso. Por favor, elija otro."]);
        $stmt_check_user->close();
        exit;
    }
    $stmt_check_user->close();

    // 4. Encriptar la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 5. Insertar nuevo usuario
    $stmt_insert_user = $conn->prepare("INSERT INTO usuario (nombre_usuario, nombre_completo, contraseña, rol_id, direccion, correo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt_insert_user) {
        echo json_encode(["success" => false, "message" => "Error interno al registrar usuario. Por favor, intente de nuevo más tarde."]);
        exit;
    }
    $stmt_insert_user->bind_param("sssisss", $usuario, $nombreCompleto, $hashedPassword, $rol_id, $direccion, $correo, $telefono);

    if ($stmt_insert_user->execute()) {
        // --- ¡CAMBIO CLAVE AQUÍ! ---
        // Si el registro es exitoso, redirige directamente a una página de éxito (o genera HTML aquí mismo)
        // Para simplicidad, generaremos HTML directamente aquí.
        // Establece el encabezado de tipo de contenido a HTML.
        header('Content-Type: text/html; charset=utf-8');

        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '    <meta charset="UTF-8">';
        echo '    <meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '    <title>Registro Exitoso</title>';
        echo '    <link rel="stylesheet" href="../css/bootstrap.min.css">'; // Asegúrate de que esta ruta sea correcta
        echo '    <style>';
        echo '        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f8f9fa; }';
        echo '        .container-message { text-align: center; background-color: #ffffff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }';
        echo '        .container-message h1 { color: #28a745; margin-bottom: 20px; }';
        echo '        .container-message p { font-size: 1.1em; margin-bottom: 30px; }';
        echo '        .container-message .btn { padding: 10px 25px; font-size: 1em; }';
        echo '    </style>';
        echo '</head>';
        echo '<body>';
        echo '    <div class="container-message">';
        echo '        <h1>¡Registro Exitoso!</h1>';
        echo '        <p>Tu cuenta ha sido creada satisfactoriamente. Ya puedes iniciar sesión.</p>';
        echo '        <a href="../index.html" class="btn btn-primary">Ir a la página principal</a>'; // Ruta correcta al index
        echo '    </div>';
        echo '</body>';
        echo '</html>';
        exit(); // Crucial para detener la ejecución después de enviar el HTML

    } else {
        // En caso de error, todavía respondemos con JSON para que el JS en el frontend lo maneje
        echo json_encode([
            "success" => false,
            "message" => "Error al registrar usuario: " . $stmt_insert_user->error
        ]);
        exit();
    }

    $stmt_insert_user->close();
    $conn->close();
} else {
    // Si la solicitud no es POST, redirigir o mostrar un error apropiado
    echo json_encode(["success" => false, "message" => "Método de solicitud no permitido."]);
    exit;
}
?>