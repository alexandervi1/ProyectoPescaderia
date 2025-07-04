<?php
    include '../config/confConexion.php';

    // Verificar si ya existe un administrador
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM usuario WHERE rol_id = 1");
    $checkStmt->execute();
    $checkStmt->bind_result($adminCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($adminCount == 0) { // Solo insertamos si no hay administradores
        $admin_usuario = "admin123";
        $admin_nombre = "Marizta Rosero";
        $admin_password = password_hash("Mrosero", PASSWORD_BCRYPT); // Encripta la contraseña
        $admin_rol = 1;

        $stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, nombre_completo, contraseña, rol_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $admin_usuario, $admin_nombre, $admin_password, $admin_rol);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Administrador registrado correctamente.";
        } else {
            echo "Error al registrar administrador.";
        }
        $stmt->close();
    } else {
        echo "Ya existe un administrador registrado.";
    }

    $conn->close();
?>
