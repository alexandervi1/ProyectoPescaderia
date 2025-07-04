<?php
session_start();
include '../config/confConexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreCompleto = trim($_POST['nombreCompleto']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $rol_id = 2; // ✅ Por defecto, los nuevos registros son clientes

    if (!empty($nombreCompleto) && !empty($usuario) && !empty($password)) {
        // ✅ Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT usuario_id FROM usuario WHERE nombre_usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo json_encode(["success" => false, "message" => "El usuario ya existe"]);
            exit;
        }

        // ✅ Encriptar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // ✅ Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, nombre_completo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $usuario, $nombreCompleto, $hashedPassword, $rol_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registro exitoso"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al registrar usuario"]);
        }
        exit;
    }
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
}
?>
