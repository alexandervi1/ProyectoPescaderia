<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Producto</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <header class="header">
        <div class="top-bar">INSERTAR PRODUCTO</div>
        <div class="header-content">
            <div class="logo">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescadería Don Walter" class="logo-img">
            </div>
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
        </div>
    </header>

    <div class="linea-debajo-header"></div>

    <main class="body-central">
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
        <div class="col-md-6">
            <div class="card bg-white text-purple border-dark p-4">
                <div class="card-body">
                    <h3 class="card-title">Insertar Producto</h3>
                    <form id="insertForm" method="POST" action="../model/mIngresar.php" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                        <div class="form-group mb-3">
                            <label for="nombreProducto">Nombre del Producto</label>
                            <input type="text" name="nombreProducto" id="nombreProducto" class="form-control bg-white text-purple" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descuentoProducto">Descuento</label>
                            <input type="number" name="descuentoProducto" id="descuentoProducto" class="form-control bg-white text-purple" min="0" max="100" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="categoriaProducto">Categoría</label>
                            <select name="categoriaProducto" id="categoriaProducto" class="form-control bg-white text-purple" required>
                                <option value="1">Categoría 1</option>
                                <option value="2">Categoría 2</option>
                                <option value="3">Categoría 3</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="descripcionProducto">Descripción</label>
                            <input type="text" name="descripcionProducto" id="descripcionProducto" class="form-control bg-white text-purple" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="precioProducto">Precio</label>
                            <input type="number" name="precioProducto" id="precioProducto" class="form-control bg-white text-purple" min="0" step="0.01" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="cantidadProducto">Cantidad</label>
                            <input type="number" name="cantidadProducto" id="cantidadProducto" class="form-control bg-white text-purple" min="0" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="imagenProducto">Imagen</label>
                            <input type="file" name="imagenProducto" id="imagenProducto" class="form-control bg-white text-purple" accept="image/*" required>
                        </div>
                        <button type="submit" class="btnInsert" value="Insertar">Insertar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <div class="text-center my-3">
        <a href="../Administrador.php" class="btn btn-danger">Regresar</a>
    </div>

    <!-- Modal de Bootstrap -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Estado de la Operación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="statusMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>Contactos: 0994745362</p>
            <p>Dirección: Argentinos y Nueva York - Riobamba</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validarFormulario() {
            const descuento = document.getElementById('descuentoProducto').value;
            const precio = document.getElementById('precioProducto').value;
            const cantidad = document.getElementById('cantidadProducto').value;

            if (descuento < 0) {
                alert('El descuento no puede ser negativo.');
                return false;
            }

            if (precio < 0) {
                alert('El precio no puede ser negativo.');
                return false;
            }

            if (cantidad < 0) {
                alert('La cantidad no puede ser negativa.');
                return false;
            }

            return true;
        }

        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');

            if (status && message) {
                const statusMessage = document.getElementById('statusMessage');
                statusMessage.textContent = message;

                const statusModal = new bootstrap.Modal(document.getElementById('statusModal'));
                statusModal.show();
            }
        });
    </script>
</body>
</html>