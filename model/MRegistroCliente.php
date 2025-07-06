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
    if (empty($nombreCompleto) || empty($usuario) || empty($password) || empty($direccion) || empty(trim($correo))) {
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
        // --- PARTE HTML MEJORADA PARA REGISTRO EXITOSO CON EL COLOR #1A519D ---
        header('Content-Type: text/html; charset=utf-8');
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Registro Exitoso - Pescadería Don Walter</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
            <style>
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                    /* Fondo con el color #1A519D */
                    background: linear-gradient(to right, #1A519D, #3A6CA8); 
                    font-family: 'Roboto', sans-serif;
                }
                .success-card {
                    background-color: #ffffff;
                    padding: 50px;
                    border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                    text-align: center;
                    max-width: 500px;
                    width: 90%;
                    animation: fadeIn 1s ease-out;
                }
                .success-card .icon {
                    font-size: 5rem;
                    color: #28a745; /* Verde de éxito para el icono */
                    margin-bottom: 25px;
                    animation: bounceIn 1s;
                }
                .success-card h1 {
                    color: #1A519D; /* Título con el color #1A519D */
                    margin-bottom: 15px;
                    font-size: 2.5em;
                    font-weight: bold;
                }
                .success-card p {
                    color: #6c757d;
                    font-size: 1.1em;
                    margin-bottom: 40px;
                    line-height: 1.6;
                }
                .success-card .btn-primary {
                    background-color: #1A519D; /* Botón con el color #1A519D */
                    border-color: #1A519D;
                    padding: 12px 30px;
                    font-size: 1.1em;
                    border-radius: 8px;
                    transition: background-color 0.3s ease, transform 0.3s ease;
                }
                .success-card .btn-primary:hover {
                    background-color: #164282; /* Tono más oscuro para el hover */
                    border-color: #164282;
                    transform: translateY(-2px);
                }

                /* Animaciones */
                @keyframes fadeIn {
                    from { opacity: 0; transform: scale(0.9); }
                    to { opacity: 1; transform: scale(1); }
                }
                @keyframes bounceIn {
                    0%, 20%, 40%, 60%, 80%, 100% {
                        -webkit-transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                        transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                    }
                    0% {
                        opacity: 0;
                        -webkit-transform: scale3d(.3, .3, .3);
                        transform: scale3d(.3, .3, .3);
                    }
                    20% {
                        -webkit-transform: scale3d(1.1, 1.1, 1.1);
                        transform: scale3d(1.1, 1.1, 1.1);
                    }
                    40% {
                        -webkit-transform: scale3d(.9, .9, .9);
                        transform: scale3d(.9, .9, .9);
                    }
                    60% {
                        opacity: 1;
                        -webkit-transform: scale3d(1.03, 1.03, 1.03);
                        transform: scale3d(1.03, 1.03, 1.03);
                    }
                    80% {
                        -webkit-transform: scale3d(.97, .97, .97);
                        transform: scale3d(.97, .97, .97);
                    }
                    100% {
                        opacity: 1;
                        -webkit-transform: scale3d(1, 1, 1);
                        transform: scale3d(1, 1, 1);
                    }
                }
            </style>
        </head>
        <body>
            <div class="success-card">
                <div class="icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h1>¡Registro Exitoso!</h1>
                <p>Tu cuenta en Pescadería Don Walter ha sido creada satisfactoriamente. Ahora puedes iniciar sesión para explorar nuestros productos frescos.</p>
                <a href="../index.html" class="btn btn-primary">Ir a la página principal</a>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>
        <?php
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