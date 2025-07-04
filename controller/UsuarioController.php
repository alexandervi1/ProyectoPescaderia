<?php
    //
    require_once __DIR__ . '/../model/MUsuario.php';
    require_once __DIR__ . '/../model/Usuario.php';

    $usuarioModel = new UsuarioModel($conn);
    $nombreAdministrador = $usuarioModel->obtenerNombreAdministrador();

    session_start();

    if (!isset($_SESSION['usuario'])) {
        $_SESSION['usuario'] = new Usuario();
    }

    $usuario = $_SESSION['usuario'];

    // Si estamos en la vista de administrador, asignamos el rol correspondiente
    if ($_SERVER['SCRIPT_NAME'] === "/Adminitrador.php") { 
        $usuario->iniciarSesionComoAdministrador();
    }
?>