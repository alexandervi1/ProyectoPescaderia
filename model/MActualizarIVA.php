<?php
require_once __DIR__ . '/../config/confConexion.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevoIVA'])) {
    $nuevoIVA = floatval($_POST['nuevoIVA']);
 
    $sql = "UPDATE Configuracion SET valor = ? WHERE clave = 'iva_actual'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "d", $nuevoIVA);
    mysqli_stmt_execute($stmt);
 
    header("Location: ../view/ListaProductos.php");
    exit();
} else {
    echo "Datos no válidos.";
}