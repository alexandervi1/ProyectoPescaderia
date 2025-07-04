<?php
    include '../model/login.php';
    include '../config/confConexion.php';

    header('Content-Type: application/json');
    ob_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        if (!empty($usuario) && !empty($password)) {
            $response = loginAdmin($usuario, $password, $conn);
            ob_end_clean();
            echo json_encode($response);
            exit;
        }
    }
    ob_end_clean();
    echo json_encode(["success" => false, "message" => "Error en la solicitud"]);
    exit;
?>
