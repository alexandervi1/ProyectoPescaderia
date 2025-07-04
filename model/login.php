<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include '../config/confConexion.php';

    // 🔹 Función para login de clientes
    function loginUsuario($usuario, $password, $conn) {
        $stmt = $conn->prepare("SELECT usuario_id, nombre_usuario, nombre_completo, contraseña, rol_id FROM usuario WHERE nombre_usuario = ? AND rol_id = 2");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['contraseña'])) {
                $_SESSION['usuario_id'] = $row['usuario_id'];
                $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                $_SESSION['nombre_completo'] = $row['nombre_completo'];
                $_SESSION['rol_id'] = $row['rol_id'];
                return ["success" => true, "redirect" => "controller/redirigir.php"];
            }
        }
        return ["success" => false, "message" => "Usuario o contraseña incorrectos"];
    }

    // 🔹 Función para login de administradores
    function loginAdmin($usuario, $password, $conn) {
        $stmt = $conn->prepare("SELECT usuario_id, nombre_usuario, nombre_completo, contraseña, rol_id FROM usuario WHERE nombre_usuario = ? AND rol_id = 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['contraseña'])) {
                $_SESSION['usuario_id'] = $row['usuario_id'];
                $_SESSION['nombre_usuario'] = $row['nombre_usuario'];
                $_SESSION['nombre_completo'] = $row['nombre_completo'];
                $_SESSION['rol_id'] = $row['rol_id'];
                return ["success" => true, "redirect" => "Administrador.php"];
            }
        }
        return ["success" => false, "message" => "Usuario o contraseña incorrectos"];
    }
?>