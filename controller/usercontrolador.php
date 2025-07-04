<?php
session_start();

if (!isset($_GET['accion'])) {
    header("Location: ../index.html");
    exit;
}

$accion = $_GET['accion'];

switch ($accion) {
    case "quienes_somos":
        header("Location: ../view/quienes_somos.php");
        break;
    case "ayuda":
            header("Location: ../view/ayuda.php");
            break;

    case "login":
        echo json_encode(["modal" => "login"]); 
        exit;

    case "registro":
        echo json_encode(["modal" => "registro"]); 
        exit;
    exit;
    case "volver":
        header("Location: ../index.html");
        break;
    default:
        header("Location: ../index.html");
        break;
}
exit;
?>
