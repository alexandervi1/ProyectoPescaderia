<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Adquisiciones</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
<header class="header">
    <div class="top-bar">LISTA DE ADQUISICIONES</div>
    <div class="header-content">
        <div class="logo">
            <img src="../img/lg5.png" alt="Logo Marianita">
        </div>
        <input type="text" id="buscador" class="form-control w-25 d-block" placeholder="Buscar producto...">
        <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
       
    </div>
</header>

<div class="linea-debajo-header"></div>

<main class="body-central">
    <div class="container mt-4">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?php echo $_GET['status'] == 'success' ? 'success' : 'danger'; ?>">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        <table class="table table-bordered text-center" id="tablaProductos">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th>Descuento</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Edición</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se insertarán los datos dinámicamente -->
                <?php include("../model/mAdquisiciones.php"); ?>
            </tbody>
        </table>
    </div>
</main>

<div class="text-center my-3">
    <a href="../model/MReporteListaAdquisiciones.php" class="btn btn-primary">Generar Documento PDF</a>
    <a href="../Administrador.php" class="btn btn-danger">Regresar</a>
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

<!-- Modal de Bootstrap para editar producto -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="../model/mModificarAdqui.php">
                    <input type="hidden" name="producto_id" id="editProductoId">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescuento" class="form-label">Descuento (%)</label>
                        <input type="number" class="form-control" id="editDescuento" name="descuento" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="editCategoria" name="categoria" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editPrecio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="editPrecio" name="precio" min="0" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="editStock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="editStock" name="stock" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('buscador').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tablaProductos tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });

    // Función para abrir el modal y cargar los datos del producto
    function openEditModal(producto) {
        document.getElementById('editProductoId').value = producto.producto_id;
        document.getElementById('editNombre').value = producto.nombre;
        document.getElementById('editDescuento').value = producto.descuento;
        document.getElementById('editCategoria').value = producto.categoria;
        document.getElementById('editDescripcion').value = producto.descripcion;
        document.getElementById('editPrecio').value = producto.precio;
        document.getElementById('editStock').value = producto.stock;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    // Añadir evento a los botones de edición
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const producto = {
                producto_id: this.dataset.id,
                nombre: this.dataset.nombre,
                descuento: this.dataset.descuento,
                categoria: this.dataset.categoria,
                descripcion: this.dataset.descripcion,
                precio: this.dataset.precio,
                stock: this.dataset.stock
            };
            openEditModal(producto);
        });
    });
</script>
</body>
<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Adquisiciones</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

</head>
<body>
<header class="header">
        <div class="top-bar">LISTA DE ADQUISICIONES</div>
        <div class="header-content">
            <div class="logo">
                <img src="../img/lg5.png" alt="Logo Marianita">
            </div>
            <input type="text" id="buscador" class="form-control w-50 d-inline" placeholder="Buscar producto...">
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
            <div>
                <a class="btnHe w-90 align-items-center" href="index.html">
                    Cerrar Sesión
                    <img src="../img/clob.png" alt="Cerrar sesión">
                </a>
            </div>
        </div>
    </header>

    <div class="linea-debajo-header"></div>

    <main class="body-central">
        <div class="container mt-4">
            <table class="table table-bordered text-center" id="tablaProductos">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Descuento</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Edición</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se insertarán los datos dinámicamente -->
                    <?php include("../model/mAdquisiciones.php"); ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="text-center my-3">
    <a href="../model/MReporteListaAdquisiciones.php" class="btn btn-primary">Generar Documento PDF</a>
    
    <a href="../Administrador.php" class="btn btn-danger">Regresar</a>
</div>

    <footer class="footer">
        <div class="footer-content">
            <p>Contactos: 0994745362</p>
            <p>Dirección: Argentinos y Nueva York - Riobamba</p>
        </div>
    </footer>

    <!-- Modal de Bootstrap para editar producto -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="../model/mModificarAdqui.php">
                        <input type="hidden" name="producto_id" id="editProductoId">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescuento" class="form-label">Descuento (%)</label>
                            <input type="number" class="form-control" id="editDescuento" name="descuento" min="0" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoria" class="form-label">Categoría</label>
                            <input type="text" class="form-control" id="editCategoria" name="categoria" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="editPrecio" name="precio" min="0" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editStock" name="stock" min="0" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tablaProductos tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });

        // Función para abrir el modal y cargar los datos del producto
        function openEditModal(producto) {
            document.getElementById('editProductoId').value = producto.producto_id;
            document.getElementById('editNombre').value = producto.nombre;
            document.getElementById('editDescuento').value = producto.descuento;
            document.getElementById('editCategoria').value = producto.categoria;
            document.getElementById('editDescripcion').value = producto.descripcion;
            document.getElementById('editPrecio').value = producto.precio;
            document.getElementById('editStock').value = producto.stock;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }

        // Añadir evento a los botones de edición
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const producto = {
                    producto_id: this.dataset.id,
                    nombre: this.dataset.nombre,
                    descuento: this.dataset.descuento,
                    categoria: this.dataset.categoria,
                    descripcion: this.dataset.descripcion,
                    precio: this.dataset.precio,
                    stock: this.dataset.stock
                };
                openEditModal(producto);
            });
        });
    </script>
</body>
</html>