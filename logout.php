<?php
session_start();
if (isset($_SESSION['usuario'])) {
    $_SESSION['usuario']->cerrarSesion();
}
session_destroy();
header("Location: index.php"); // Redirigir a la página principal
exit;
?>