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
                <img src="img/lg5.png" alt="Logo Marianita">
            </div>
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
            <div>
            <a class="btnHe w-90 align-items-center" href="index.html">
    <img src="img/clob.png" alt="Cerrar sesión">
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
                        <img src="img/inv.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Mostrar Productos                 
                    </a>
                </div>
                <div title="Registrar Nuevos Productos en inventario" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=2" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="img/agr.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Agregar Producto
                    </a>
                </div>
                <div title="Control Ventas Eliminación" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=3" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="img/ven.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Registro de Ventas
                    </a>
                </div>
                <div title="Listado de productos por abastecer" class="col-md-3 mb-3">
                    <a href="./controller/adminControlador.php?opcion=4" class="btnAd w-100 d-flex flex-column align-items-center btnAd-custom-height">
                        <img src="img/abs.png" alt="imagen no disponible" class="img-fluid mb-2 custom-img">
                        Adquisiciones
                    </a>
                </div>
            </div>
        </div>
    </main>
    <br><br><br>
    <br><br><br>
    <br><br><br>
    <br><br><br>

    <footer class="footer">
        <div class="footer-content">
            <p>Síguenos:</p>
            <div class="social-icons">
                <img src="img/fb.png" alt="Facebook">
                <img src="img/tk.png" alt="TikTok">
                <img src="img/ins.png" alt="Instagram">
                <img src="img/ws.png" alt="WhatsApp">
            </div>
            
            <p>Contactos: 0994745362</p>
            <p>Dirección: Argentinos y Nueva York - Riobamba</p>
        </div>
    </footer>
</body>
</html>
