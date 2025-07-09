<?php
require_once '../config/confConexion.php';
require_once '../model/mObtDatosProducto.php';

// Obtener el ID del producto desde la URL
if (!isset($_GET['id'])) {
    die('Error: ID de producto no especificado.');
}
$producto_id = $_GET['id'];

// Obtener los datos del producto desde la base de datos
$producto = obtenerDatosProducto($producto_id);
if (!$producto) {
    die('Error: Producto no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descripción del producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/producto.css">
    <style>
        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar el modal por defecto */
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease-in-out;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" width="200" height="64">
            </a>
          
            <div id="guest-options">
                <a href="../controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style="color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a href="#" class="btn btn-primary" id="open-register-modal">Registrarse</a>
            </div>
            <div id="user-options">
                <i class="bi bi-person-circle" style="color: white; font-size: 1.5rem;"></i>
                <span id="user-name" class="user-info" style="color: white;"></span>
                <a href="carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <a href="controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
                    <i class="bi bi-power" style="font-size: 2.0rem;"></i>
                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action" onclick="cambiarImagen('../<?php echo $producto['imagen_url']; ?>')">
                        <img src="../<?php echo $producto['imagen_url']; ?>" alt="Miniatura" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <img id="imagenAmpliada" src="../<?php echo $producto['imagen_url']; ?>" alt="Imagen Ampliada" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-bold"><?php echo $producto['nombre']; ?></h2>
                <span>$<?php echo number_format($producto['precio'], 2); ?></span>
                <p><?php echo $producto['descripcion']; ?></p>
                <div class="d-flex justify-content-center mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(-1)">-</button>
                        </div>
                        <input type="text" class="form-control text-center" id="cantidad" value="1" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" onclick="agregarAlCarrito(<?php echo $producto_id; ?>, document.getElementById('cantidad').value)">
                        Agregar al Carrito
                    </button>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Contacto: 09924700553-0982744920</p>
            <p>Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y - Riobamba</p>
            <div class="footer-icons">
            <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="modal-mensaje"></span>
        </div>
    </div>
    <script src="../public/js/producto.js?v=<?= time() ?>"></script>
    <script src="/public/js/index.js"></script>
    <script src="/public/js/app.js"></script>
</body>
</html>