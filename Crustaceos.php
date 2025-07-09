<?php
session_start();
$usuarioLogueado = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Don Walter Pescaderia</title>
    <!-- Bootstrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="public/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Imagen como logo -->
            <a class="navbar-brand" href="#">
                <img src="public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" width="200" height="64">
            </a>

            <!-- Barra de búsqueda -->
            <form class="d-flex mx-auto search-bar" id="search-form">
                <input class="form-control me-2" type="search" placeholder="Filtrar" id="search-input">
                <button class="btn btn-outline-light" type="submit">
        <i class="bi bi-search"></i>
    </button>
                <div id="search-suggestions" class="search-suggestions"></div>
            </form>

            <!-- Opciones antes de iniciar sesión -->
           <div id="guest-options">
        
                <a href="./controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style=" color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a href="#" class="btn btn-primary" id="open-register-modal">Registrarse</a>
               
                <!--<a href="#" class="btn btn-link text-light" id="open-admin-modal">Administrador</a>-->
            </div>

            
           <!-- Opciones después de iniciar sesión -->
            <div id="user-options">
                <a href="#" class="d-flex align-items-center text-decoration-none" style="color: white;">
                    <i class="bi bi-person-circle" style="font-size: 1.5rem; margin-right: 5px;"></i>
                    <span id="user-name" class="user-info"></span>
                </a>
                <a href="view/carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <!--<i class="bi bi-cart3" style="font-size: 1.5rem;"></i>-->
                <!--<a href="controller/logout.php" class="bi bi-box-arrow-right">Cerrar Sesión</a>-->
                <a href="controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
                    <i class="bi bi-power" style="font-size: 2.0rem;"></i>
                </a>
            </div>
        </div>
    </nav>
            <!--<div class="collapse navbar-collapse" id="navbarContent">

                <div>
                    <a href="#" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                    <a href="#" aria-label="Cerrar sesión"><i class="bi bi-box-arrow-right"></i>Cerrar sesion</a>
                </div>
            </div>-->
        </div>
    </nav>


    <!-- Main Content -->
  <div class="container mt-4">
        <a href="index.html" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="mb-4">Crustaceos & Moluscos</h2>
            </div>
            <div class="col-12">
                <div class="row" id="product-list">
                    <!-- Tarjeta 1 -->
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 1" data-producto-id="4">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="4"></h5>
                                <p class="card-text" data-producto-id="4"></p>
                                <p class="product-price" data-producto-id="4"></p>
                                <a href="view/producto.php?id=4" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 2 -->
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 2" data-producto-id="8">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="8"></h5>
                                <p class="card-text" data-producto-id="8"></p>
                                <p class="product-price" data-producto-id="8"></p>
                                <a href="view/producto.php?id=8" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 3 -->
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 3" data-producto-id="10">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="10"></h5>
                                <p class="card-text" data-producto-id="10"></p>
                                <p class="product-price" data-producto-id="10"></p>
                                <a href="view/producto.php?id=10" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 4 -->
                     <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 4" data-producto-id="11">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="11"></h5>
                                <p class="card-text" data-producto-id="11"></p>
                                <p class="product-price" data-producto-id="11"></p>
                                <a href="view/producto.php?id=11" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 5 -->
                     <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 5" data-producto-id="12">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="12"></h5>
                                <p class="card-text" data-producto-id="12"></p>
                                <p class="product-price" data-producto-id="12"></p>
                                <a href="view/producto.php?id=12" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 6 -->
                     <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 6" data-producto-id="17">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="17"></h5>
                                <p class="card-text" data-producto-id="17"></p>
                                <p class="product-price" data-producto-id="17"></p>
                                <a href="view/producto.php?id=17" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta 7 -->
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img class="card-img-top" alt="Producto 7" data-producto-id="18">
                            <div class="card-body p-2">
                                <h5 class="card-title" data-producto-id="18"></h5>
                                <p class="card-text" data-producto-id="18"></p>
                                <p class="product-price" data-producto-id="18"></p>
                                <a href="view/producto.php?id=18" class="btn btn-primary btn-sm">Comprar</a>
                            </div>
                        </div>
                    </div>
                     
                    <!-- Agrega más tarjetas según sea necesario -->
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Contacto: 09924700553-0982744920</p>
            <p>Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y  - Riobamba</p>
            <div class="footer-icons">
            <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>
    <script type="module" src="./public/js/cargarImagen.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="../public/js/index.js"></script>
    <script src="../public/js/app copy.js"></script>
    <script src="/public/js/app.js"></script>
</body>

</html>

<!-- Modal de Login -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <button class="close-modal" id="close-login-modal" style="font-weight: bold;">&times;</button>
            <!-- Botón de cierre -->
            <center><img src="./public/img/Pescaderia Don Walter logo.png" alt="Logo" class="logo" width="200px"></center>
            <hr>
            <h3>Iniciar Sesión</h3>
            <hr>
            <br>
            <form id="login-form">
                <label for="login-usuario">Nombre de Usuario:</label>
                <input type="text" id="login-usuario" placeholder="Tu nombre de usuario" required style="width: 300px;">

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" placeholder="Tu contraseña" required style="width: 300px;">

                <button class= "btn_loguin" type="submit" id="login-btn">Ingresar</button>
                <center>
                    <p id="register-link">¿No tienes cuenta? <a href="#" id="show-register">Regístrate</a></p>
                </center>
            </form>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <button class="close-modal" id="close-register-modal" style="font-weight: bold;">&times;</button>
            <!-- Botón de cierre -->
            <center><img src="./public/img/Pescaderia Don Walter logo.png" alt="Logo" class="logo" width="200px"></center>
            <hr>

            <h3>Registro de Clientes</h3>
            <hr>
            <br>
            <form id="register-form">
                <label for="register-nombre">Nombre Completo:</label>
                <input type="text" id="register-nombre" placeholder="Tu nombre completo" required style="width: 300px;">

                <label for="register-usuario">Nombre de Usuario:</label>
                <input type="text" id="register-usuario" placeholder="Tu nombre de usuario" required style="width: 300px;">

                <label for="register-password">Contraseña:</label>
                <input type="password" id="register-password" placeholder="Tu contraseña" required style="width: 300px;">

                <button type="submit" id="register-btn">Registrarse</button>
            </form>
        </div>
    </div>