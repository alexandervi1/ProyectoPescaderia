<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Marianita - Juguetes</title>
    <!-- Bootstrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../public/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../public/img/Logo.png" alt="Logo Juguetería Marianita" width="200" height="64">
            </a>

            <form class="d-flex mx-auto search-bar">
                <input class="form-control me-2" type="search" placeholder="Filtrar">
                <button class="btn btn-outline-light" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <div id="guest-options">
                <a href="../controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style="color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a href="#" class="btn btn-primary" id="open-register-modal">Registrarse</a>
            </div>

            <div id="user-options">
                <i class="bi bi-person-circle" style="color: white; font-size: 1.5rem;"></i>
                <span id="user-name" class="user-info" style="color: white;"></span>
                <a href="../view/carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <a href="../controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
                    <i class="bi bi-power" style="font-size: 2.0rem;"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="mb-4">Juguetes</h2>
                </div>
                <div class="col-12">
                    <div class="row" id="product-list">
                        <?php if (!empty($juguetes)): ?>
                            <?php foreach ($juguetes as $juguete): ?>
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <img class="card-img-top" src="<?php echo $juguete['imagen_url']; ?>" alt="<?php echo $juguete['nombre']; ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $juguete['nombre']; ?></h5>
                                            <p class="card-text"><?php echo $juguete['descripcion']; ?></p>
                                            <p class="product-price">$<?php echo number_format($juguete['precio'], 2); ?></p>
                                            <p class="product-discount">Descuento: <?php echo number_format($juguete['descuento'], 2); ?>%</p>
                                            <a href="../view/producto.php?id=<?php echo $juguete['producto_id']; ?>" class="btn btn-primary">Comprar</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No hay juguetes disponibles en esta categoría.</p>
                        <?php endif; ?>
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
                <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script src="../public/js/index.js"></script>
    <script src="../public/js/app.js"></script>
</body>
</html>