<?php

session_start(); 

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../public/css/style.css" rel="stylesheet">
    <style>
        /* Estilos específicos para esta página (pueden ir en carrito.css) */
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, .05);
        }
        .table-striped tbody tr:hover {
            background-color: rgba(0, 0, 0, .075);
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table img {
            max-width: 80px;
            height: auto;
            border-radius: 5px;
        }
        .input-group-sm .form-control {
            max-width: 60px; /* Ancho para el input de cantidad */
            text-align: center;
        }
        .cart-summary {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .cart-summary h4 {
            color: #1A519D;
            margin-bottom: 15px;
        }
        .cart-summary .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border: none;
            border-bottom: 1px solid #eee;
        }
        .cart-summary .list-group-item:last-child {
            border-bottom: none;
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
        }
        .checkout-btn-container {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" width="200" height="64">
            </a>
            <div id="guest-options" style="display: none;"> <a href="../controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style="color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a href="#" class="btn btn-primary" id="open-register-modal">Registrarse</a>
            </div>
            <div id="user-options" style="display: none;"> <i class="bi bi-person-circle" style="color: white; font-size: 1.5rem;"></i>
                <span id="user-name" class="user-info" style="color: white;"></span>
                <a href="carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <a href="../controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
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
        <h2 class="mb-4">Tu Carrito de Compras</h2>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cart-items-body">
                        <tr><td colspan="6">Cargando carrito...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="cart-summary">
                    <h4>Resumen del Pedido</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <span>Total:</span>
                            <span id="cart-total">$0.00</span>
                        </li>
                    </ul>
                    <div class="checkout-btn-container">
                        <button class="btn btn-primary btn-lg w-100">Proceder al Pago</button>
                    </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/index.js"></script> <script src="../public/js/app.js"></script>
    <script src="../public/js/carrito.js"></script> </body>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/app copy.js"></script>
</html>