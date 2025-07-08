<?php

require_once __DIR__ . '/../controller/UsuarioController.php'; // Ruta corregida

// Si UsuarioController.php no define $nombreAdministrador, puedes usar un placeholder:
$nombreAdministrador = $_SESSION['nombre_usuario'] ?? "Administrador"; // O cualquier otra lógica para obtener el nombre

// Opcional: Redirigir si el usuario no tiene el rol de administrador (ej. rol_id = 1)
// if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] != 1) {
//     header("Location: ../index.html"); // Redirigir a la página principal o de login
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Comercial de Mariscos Don Walter</title> <!-- Título de la página actualizado -->
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap ICONS (si los usas en algún lugar de esta página) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS para estilos específicos de administrador -->
    <!-- RUTA CORREGIDA: Ajustada para ser relativa desde Reportes/ a public/css/ -->
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link rel="stylesheet" href="/public/css/style.css">
    
    </head>
<body>
    <header class="header">
        <div class="top-bar">REPORTES</div> <!-- Actualizado a REPORTES -->
        <div class="header-content">
            <div class="logo">
                <!-- RUTA CORREGIDA: Ajustada para ser relativa desde Reportes/ a public/img/ -->
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter">
            </div>
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1> <!-- Actualizado a Reportes -->
            <div>
                <!-- Botón de cerrar sesión -->
                <!-- RUTA CORREGIDA: Ajustada para ser relativa desde Reportes/ a index.html y public/img/ -->
                <a class="btnHe w-90 align-items-center" href="../index.html">
                    <img src="../public/img/clob.png" alt="Cerrar sesión">
                </a>
            </div>
        </div>
    </header>

    <!-- Botón "Volver" en la esquina superior izquierda -->
    

    <div class="linea-debajo-header"></div>
    <br><br><br>
<div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
    <main class="body-central">
        <div class="container mt-4">
            <div class="row justify-content-center"> <!-- Centrar los botones de reporte -->
                <!-- Reporte de Ventas por Período -->
                <div title="Generar reporte de ventas por un período específico" class="col-md-3 mb-3">
                    <a class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height" href="../controller/reportesControlador.php?tipo=ventas"> <!-- Ruta corregida -->
                        <!-- Icono de Ventas -->
                        <img src="../public/img/icons/icoReport.png" alt="Reporte de Ventas" class="img-fluid mb-2 custom-img">
                        Reporte de Ventas <!-- Muestra idcliente,fechaCompra,totalCompra,totalConiva -->
                    </a>
                </div>
                <!-- Reporte de Productos Más Vendidos -->
                <div title="Ver los productos más vendidos" class="col-md-3 mb-3">
                    <a href="../controller/reportesControlador.php?tipo=mas_vendidos" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height"> <!-- Ruta corregida -->
                        <!-- Icono de Productos Más Vendidos -->
                        <img src="../public/img/icons/icoReport.png" alt="Productos Más Vendidos" class="img-fluid mb-2 custom-img">
                        Productos Más Vendidos <!-- Idprducto,nombreProducto,cantidadVendida-->
                    </a>
                </div>
                <!-- Reporte de Stock Bajo -->
                <div title="Listado de productos con stock bajo" class="col-md-3 mb-3">
                    <a href="../controller/reportesControlador.php?tipo=stock_bajo" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height"> <!-- Ruta corregida -->
                        <!-- Icono de Stock Bajo -->
                        <img src="../public/img/icons/icoReport.png" alt="Stock Bajo" class="img-fluid mb-2 custom-img">
                        Reporte de facturacion <!--  -->
                    </a>
                </div>
                <!-- Reporte de Clientes (ej. Top Clientes) -->
                <div title="Ver reporte de clientes (ej. top compradores)" class="col-md-3 mb-3">
                    <a href="../controller/reportesControlador.php?tipo=clientes" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height"> <!-- Ruta corregida -->
                        <!-- Icono de Clientes -->
                        <img src="../public/img/icons/icoReport.png" alt="Reporte de Clientes" class="img-fluid mb-2 custom-img">
                        Reporte de Clientes <!-- Texto del botón actualizado -->
                    </a>
                </div>
            </div>
        </div>
    </main>
    <br><br><br>
    <br><br><br>
    <br><br><br>
    <br><br><br>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Soporte: 0992714396</p>
        </div>
        </footer>
    <!-- Bootstrap JS (si es necesario para algún componente en el futuro) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
