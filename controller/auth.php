<?php
    //ARCHIVO PARA INICIO DE SESION DE USUARIO
    include '../model/login.php';
    include '../config/confConexion.php';

    header('Content-Type: application/json'); // Asegurar respuesta JSON
    ob_start(); // Previene espacios en blanco antes del JSON

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        if (!empty($usuario) && !empty($password)) {
            $response = loginUsuario($usuario, $password, $conn);
            ob_end_clean(); // Limpia cualquier salida antes del JSON
            echo json_encode($response);
            exit;
        }
    }
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "Error en la solicitud"]);
    exit;
?>
