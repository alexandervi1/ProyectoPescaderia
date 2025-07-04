<?php
require_once __DIR__ . '/controller/UsuarioController.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - PG4</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="top-bar">ADMINISTRADOR</div>
        <div class="header-content">
            <div class="logo">
                <img src="public\img\Pescaderia Don Walter logo.png" alt="Logo Marianita">
            </div>
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
            <div>
            <a class="btnHe w-90 align-items-center" href="index.html">
    <img src="public/img/clob.png" alt="Cerrar sesión">
</a>
            </div>
        </div>
    </header>

    <div class="linea-debajo-header"></div>
    <br><br><br>

    <main class="body-central">
        <div class="container mt-4">
            <div class="row">
                <div title="Listado de productos, opciones de Filtrado Edición Eliminación" class="col-md-3 mb-3">
                    <a class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height" href="./controller/adminControlador.php?opcion=1">
                        <img src="public/img/icons/icoGestProd.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Gestionar Productos
                    </a>
                </div>
                <div title="Registrar Nuevos Productos en inventario" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=2" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="public/img/icons/icoGestProd.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Gestionar Productos
                    </a>
                </div>
                <div title="Control Ventas Eliminación" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=3" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="public/img/icons/icoReport.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Reportes
                    </a>
                </div>
                <div title="Listado de productos por abastecer" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=4" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="public/img/icons/icoFacturas.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Facturas
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
        </div>
    </footer>
</body>
</html>
