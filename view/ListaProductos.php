<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Productos</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
<header class="header">
        <div class="top-bar">LISTA DE PRODUCTOS</div>
        <div class="header-content">
            <div class="logo">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Don Walter">
            </div>
            <input type="text" id="buscador" class="form-control w-25 d-block" placeholder="Buscar producto...">
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
            
        </div>
    </header>

    <div class="linea-debajo-header"></div>
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>

    <main class="body-central">
        <div class="container mt-4">
            <table class="table table-bordered text-center" id="tablaProductos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Imagen URL</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Unidad de Compra</th>
                        <th>Unidad de Venta</th>
                        <th>Edición</th>
                        <th>Eliminación</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se insertarán los datos dinámicamente -->
                    <?php include("../model/MListarProductos.php"); ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="text-center my-3">
    <a href="../model/MReporteListaProductos.php" class="btn btn-pdf">Generar Documento PDF</a>
    <a href="../controller/adminControlador.php?opcion=2" class="btn-ingreso">Ingresar Nuevo Producto</a>
    <a href="../Administrador.php" class="btn btn-warning">Regresar</a>
</div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Contacto: 09924700553-0982744920</p>
            <p>Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y   - Riobamba</p>
            <div class="footer-icons">
            <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tablaProductos tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
</body>
</html>


