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
        $admin_direccion = "Dirección por defecto"; // Valor por defecto para dirección
        $admin_correo = "admin@ejemplo.com";   // Valor por defecto para correo
        $admin_telefono = "0987654321";      // Valor por defecto para teléfono

        // Modificado para incluir direccion, correo y telefono
        $stmt = $conn->prepare("INSERT INTO usuario (nombre_usuario, nombre_completo, contraseña, rol_id, direccion, correo, telefono) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssisss", $admin_usuario, $admin_nombre, $admin_password, $admin_rol, $admin_direccion, $admin_correo, $admin_telefono);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Administrador registrado correctamente.";
        } else {
            echo "Error al registrar administrador: " . $stmt->error; // Añadido para depuración
        }
        $stmt->close();
    } else {
        echo "Ya existe un administrador registrado.";
    }

    $conn->close();
?>
