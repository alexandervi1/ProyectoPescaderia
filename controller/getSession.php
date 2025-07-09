<?php
// controller/getSession.php

session_start(); // Siempre inicia la sesión al principio

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

$response = [
    'usuario_id' => null,
    'nombre_usuario' => null,
    'nombre_completo' => null,
    'rol_id' => null
];

// Verifica si 'usuario_id' está configurado en la sesión
if (isset($_SESSION['usuario_id'])) {
    // Si usuario_id existe, entonces el usuario está logueado
    $response['usuario_id'] = $_SESSION['usuario_id'];
    $response['nombre_usuario'] = $_SESSION['nombre_usuario'];
    $response['nombre_completo'] = $_SESSION['nombre_completo'];
    $response['rol_id'] = $_SESSION['rol_id'];
} else {
    // Si no hay usuario_id en la sesión, el usuario NO está logueado.
    // Simplemente devuelve nulls para indicar que no hay sesión activa.
    // No necesitamos codificar un "ID de visitante" aquí.
    $response['usuario_id'] = null;
    $response['nombre_usuario'] = null;
    $response['nombre_completo'] = null;
    $response['rol_id'] = null;
}

echo json_encode($response);
exit; // Termina el script
?>