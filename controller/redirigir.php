<?php
    //archivo para redirigir a la página correspondiente según el rol del usuario
    session_start();
    if (!isset($_SESSION['usuario_id'])) {
        $_SESSION['usuario_id'] = null;
        $_SESSION['nombre_usuario'] = "visitante";
        $_SESSION['nombre_completo'] = "visitante";
        $_SESSION['rol_id'] = 3;
    }
    // ✅ Redirección según el rol del usuario
    if ($_SESSION['rol_id'] == 2) {
        header("Location: ../view/quienes_somos.php"); // 🔹 Cliente
    } else {
        header("Location: ../index.html"); // 🔹 Visitante
    }
    exit;
?>
