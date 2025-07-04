<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Marianita</title>
    <!-- Bootstrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="public/css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Modal de Login -->
    <div id="login-modal" class="modal">
        <div class="modal-content">
            <button class="close-modal" id="close-login-modal">&times;</button>
            <!-- 🔹 Botón de cierre -->
            <center><img src="./public/img/Logo.png" alt="Logo" class="logo" width="200px"></center>
            <hr>
            <h3>Iniciar Sesión</h3>
            <hr>
            <br>
            <form id="login-form">
                <label for="login-usuario">Nombre de Usuario:</label>
                <input type="text" id="login-usuario" placeholder="Tu nombre de usuario" required style="width: 300px;">

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" placeholder="Tu contraseña" required style="width: 300px;">

                <button type="submit" id="login-btn">Ingresar</button>
                <center>
                    <p id="register-link">¿No tienes cuenta? <a href="#" id="show-register">Regístrate</a></p>
                </center>
            </form>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div id="register-modal" class="modal">
        <div class="modal-content">
            <button class="close-modal" id="close-register-modal">&times;</button>
            <h3>Registro</h3>
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


    <!-- Modal de Login para Administrador -->
    <div id="admin-login-modal" class="modal">
        <div class="modal-content">
            <button class="close-modal" id="close-admin-modal">&times;</button>
            <center><img src="./public/img/Logo.png" alt="Logo" class="logo" width="200px"></center>
            <hr>
            <h3>Acceso Administrador</h3>
            <hr>
            <br>
            <form id="admin-login-form">
                <label for="admin-usuario">Usuario Administrador:</label>
                <input type="text" id="admin-usuario" placeholder="Usuario" required style="width: 300px;">

                <label for="admin-password">Contraseña:</label>
                <input type="password" id="admin-password" placeholder="Contraseña" required style="width: 300px;">

                <button type="submit" id="admin-login-btn">Ingresar</button>
            </form>
        </div>
    </div>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="#">
                <img src="public/img/Logo.png" alt="Logo Juguetería Marianita" width="200" height="64">
            </a>

            <!-- Barra de búsqueda -->
            <form class="d-flex mx-auto search-bar">
                <input class="form-control me-2" type="search" placeholder="Filtrar">
                <button class="btn btn-outline-light" type="submit">
                <i class="bi bi-search"></i>
                </button>
            </form>

            <!-- Opciones después de iniciar sesión -->
            <div id="user-options" style="display: none;">
                <span id="user-name">Nombre Cliente Apellido Cliente</span>
                <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                <a href="controller/logout.php" class="btn btn-link text-danger">Cerrar Sesión</a>
                <i class="bi bi-power" style="font-size: 1.5rem;"></i>
            </div>
        </div>
    </nav>


    <!-- Main Content -->
    <div>
        
        <!--PRODUCTOS PRINCIPALES (MÁS VENDIDOS)-->
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-4">Nuestros Productos</h2>
                </div>
                <!-- Placeholder for products -->
                <div class="col-12">
                    <div class="row" id="product-list">
                        <!-- Add your products dynamically or statically here -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 1" data-producto-id="1">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 1</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 2" data-producto-id="2">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 2</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 3" data-producto-id="3">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 3</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--PRODUCTOS CON PROMOCIÓN-->
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-4">usa el chat para no dañar nada de aqui</h2>
                </div>
                <!-- Placeholder for products -->
                <div class="col-12">
                    <div class="row" id="product-list">
                        <!-- Add your products dynamically or statically here -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 1" data-producto-id="35">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 1</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 2">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 2</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Producto 3" data-producto-id="39">
                                <div class="card-body">
                                    <h5 class="card-title">Producto 3</h5>
                                    <p class="card-text">Descripción breve del producto.</p>
                                    <a href="#" class="btn btn-primary">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--CATEGORÍAS-->
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-4">CATEGORÍAS</h2>
                </div>
                <!-- Placeholder for products -->
                <div class="col-12">
                    <div class="row" id="product-list">
                        <!-- Add your products dynamically or statically here -->
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Categoria Jugueteria" data-producto-id="22">
                                <div class="card-body">
                                    <h5 class="card-title">Juguetería</h5>
                                    <p class="card-text">Descripción de Categoría</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Categoría Fiesta" data-producto-id="47">
                                <div class="card-body">
                                    <h5 class="card-title">Fiestas</h5>
                                    <p class="card-text">Descripción de Categoría</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img class="card-img-top" alt="Categoria Confiteria" data-producto-id="10">
                                <div class="card-body">
                                    <h5 class="card-title">Confitería</h5>
                                    <p class="card-text">Descripción de Categoría</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <p>© 2025 Juguetería & Novedades Marianita. Variedad al alcance de su bolsillo.</p>
            <div class="footer-icons">
                <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script type="module" src="./public/js/cargarImagen.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="public/js/index.js"></script>
    <script src="public/js/app.js"></script>

</body>

</html>