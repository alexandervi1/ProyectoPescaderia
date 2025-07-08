<?php
// Incluir el controlador de Usuario. Es buena práctica verificar si la sesión ya está iniciada.

require_once __DIR__ . '/../controller/UsuarioController.php';

// Verificar si el usuario está logueado y es administrador
// Se asume que UsuarioController tiene un método para verificar el rol o que la sesión contiene el rol.
// Si no hay sesión o el rol no es administrador (rol_id = 1), redirige.
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] !== 1) {
    header("Location: ../index.html"); // O la página de login si prefieres
    exit();
}

// Obtener el nombre del administrador de la sesión
$nombreAdministrador = $_SESSION['nombre_usuario'] ?? 'Administrador'; // Usar un valor predeterminado si no está en sesión

// El MListarProductos.php será incluido en el body, lo cual es funcional pero no ideal para la lógica pura.
// Para este caso, lo mantendremos así ya que tu diseño lo espera dentro del <tbody>.
// Idealmente, los datos se cargarían aquí y luego se pasarían al HTML.
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Productos - Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        /* Estilos adicionales si fueran necesarios, aunque preferiblemente en Administrador.css */
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Espacia los elementos */
            padding: 10px 20px; /* Ajusta el padding según sea necesario */
            flex-wrap: wrap; /* Permite que los elementos se envuelvan en pantallas pequeñas */
        }

        .header-content .logo {
            flex-shrink: 0; /* Evita que el logo se encoja */
        }

        .header-content .form-control {
            margin: 0 15px; /* Espacio alrededor del buscador */
            flex-grow: 1; /* Permite que el buscador crezca */
            max-width: 300px; /* Limita el ancho máximo del buscador */
        }
        
        .header-content .title {
            margin: 0;
            flex-shrink: 0; /* Evita que el título se encoja */
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            .header-content .form-control {
                margin: 10px 0;
                width: 80% !important; /* Ajusta el ancho para móviles */
                max-width: unset; /* Quita el max-width en móviles */
            }
            .header-content .title {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-bar">LISTA DE PRODUCTOS</div>
        <div class="header-content">
            <div class="logo">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Don Walter">
            </div>
            <input type="text" id="buscador" class="form-control" placeholder="Buscar producto...">
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
        </div>
    </header>

    <div class="linea-debajo-header"></div>
    <div class="container mt-3">
        <a href="../Administrador.php" class="btn btn-outline-secondary">
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
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Unidad de Compra</th>
                        <th>Unidad de Venta</th>
                        <th>Eliminación</th>
                        <th>Edición</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Incluir el archivo que trae los datos de los productos y los muestra en filas HTML.
                    // Asegúrate de que MListarProductos.php genera el HTML de las <tr> y <td>.
                    include("../model/MListarProductos.php"); 
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="text-center my-3">
        <a href="../model/MReporteListaProductos.php" class="btn btn-primary btn-pdf me-2">Generar Documento PDF</a>
        <a href="../view/viewIngreso.php" class="btn btn-success btn-ingreso me-2">Ingresar Nuevo Producto</a>
        <a href="../view/viewEditarIVA.php" class="btn btn-danger">Modificar IVA</a>
        <a href="../Administrador.php" class="btn btn-warning">Regresar</a>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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