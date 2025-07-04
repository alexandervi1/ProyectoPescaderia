<?php
    session_start();
    header('Content-Type: application/json');

    if (isset($_SESSION['usuario_id'])) {
        echo json_encode([
            "usuario_id" => $_SESSION['usuario_id'],
            "nombre_usuario" => $_SESSION['nombre_usuario'],
            "nombre_completo" => $_SESSION['nombre_completo'],
            "rol_id" => $_SESSION['rol_id']
        ]);
    } else {
        echo json_encode([
            "usuario_id" => 2, 
            "nombre_usuario" => "visitante", 
            "nombre_completo" => "Visitante",
            "rol_id" => 3
        ]);
    }
?>

