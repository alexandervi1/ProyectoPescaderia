<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: ../index.html"); // O a tu página de login
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Enlaces a tus archivos CSS (rutas relativas desde view/carrito.php) -->
    <link href="../public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/carrito.css"> <!-- Archivo CSS específico para el carrito -->
    
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
    <!-- Navbar (Copiado de index.html para consistencia) -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" width="200" height="64">
            </a>

            <!-- BUSQUEDA campo de entrada (Opcional en carrito, puedes quitarlo si no lo necesitas aquí) -->
            <!-- <form class="d-flex mx-auto search-bar" id="search-form">
                <input class="form-control me-2" type="search" id="search-input" placeholder="Filtrar...">     
                <button class="btn btn-outline-light" type="button" id="search-button"> 
                    <i class="bi bi-search"></i>
                </button>
                <div id="search-suggestions" class="search-suggestions"></div>
            </form> -->

            <!-- Opciones antes de iniciar sesión -->
            <div id="guest-options" style="display: none;"> <!-- Ocultar si el usuario está logueado -->
                <a href="../controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style=" color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a class="btn btn-primary" href="../controller/usercontrolador.php?accion=registro" id="open-register-modal">Registrarse</a>
                <a href="../controller/usercontrolador.php?accion=ayuda" id="btn-ayuda" class="btn btn-link text-light" style="color: white;">
                    <i class="bi bi-question-circle"></i> Ayuda
                </a>
            </div>

            <!-- Opciones después de iniciar sesión (mostrar si el usuario está logueado) -->
            <div id="user-options">
                <a href="#" class="d-flex align-items-center text-decoration-none" style="color: white;">
                    <i class="bi bi-person-circle" style="font-size: 1.5rem; margin-right: 5px;"></i>
                    <span id="user-name" class="user-info">Usuario</span> <!-- Placeholder para el nombre de usuario -->
                </a>
                <a href="carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <a href="../controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
                    <i class="bi bi-power" style="font-size: 2.0rem;"></i>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Carrito de Compras</h2>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-striped" id="carrito-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los productos se cargarán aquí mediante JavaScript -->
                        <tr><td colspan="5">Cargando carrito...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="cart-summary">
                    <h4>Resumen del Carrito</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Subtotal: <span id="cart-subtotal">$0.00</span>
                        </li>
                        <li class="list-group-item">
                            Envío: <span>$0.00</span> <!-- Puedes implementar lógica de envío aquí -->
                        </li>
                        <li class="list-group-item">
                            Total: <span id="cart-total">$0.00</span>
                        </li>
                    </ul>
                    <div class="checkout-btn-container">
                        <button class="btn btn-primary btn-lg w-100" id="proceed-to-checkout">Proceder al Pago</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de mensajes (reutilizado para confirmación y errores) -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="messageModalLabel">Mensaje</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <i id="message-icon" style="font-size: 2rem;"></i>
                    <p id="message-text" class="mt-2"></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Instancia del modal de mensajes
        const messageModal = new bootstrap.Modal(document.getElementById('messageModal'));
        const messageModalLabel = document.getElementById('messageModalLabel');
        const messageIcon = document.getElementById('message-icon');
        const messageText = document.getElementById('message-text');
        const messageModalContent = document.querySelector('#messageModal .modal-content');

        /**
         * Muestra un modal de mensaje personalizado.
         * @param {string} title - Título del modal.
         * @param {string} message - Mensaje a mostrar.
         * @param {string} type - Tipo de mensaje ('success', 'error', 'info').
         */
        function showCustomModal(title, message, type) {
            messageModalLabel.textContent = title;
            messageText.textContent = message;

            // Limpiar clases de color previas
            messageModalContent.classList.remove('bg-success', 'bg-danger', 'bg-info', 'text-white');
            messageIcon.className = ''; // Limpiar iconos previos

            if (type === 'success') {
                messageModalContent.classList.add('bg-success', 'text-white');
                messageIcon.classList.add('bi', 'bi-check-circle');
            } else if (type === 'error') {
                messageModalContent.classList.add('bg-danger', 'text-white');
                messageIcon.classList.add('bi', 'bi-x-circle');
            } else { // info
                messageModalContent.classList.add('bg-info', 'text-white');
                messageIcon.classList.add('bi', 'bi-info-circle');
            }
            messageModal.show();
        }

        function obtenerProductosCarrito() {
            fetch('../controller/carritoController.php?accion=obtener')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log("Datos recibidos:", data); // ✅ Verificar en consola

                const tbody = document.querySelector('#carrito-table tbody');
                tbody.innerHTML = '';
                let subtotal = 0;

                if (!data.productos || data.productos.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5">El carrito está vacío.</td></tr>';
                } else {
                    data.productos.forEach(producto => {
                        const precio = parseFloat(producto.precio);
                        const cantidad = parseInt(producto.cantidad);
                        const totalProducto = precio * cantidad;
                        subtotal += totalProducto;

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>
                                <img src="${producto.imagen_url || 'https://placehold.co/80x80?text=Producto'}" alt="${producto.nombre}" class="me-2">
                                ${producto.nombre}
                            </td>
                            <td>$${precio.toFixed(2)}</td>
                            <td>
                                <div class="input-group input-group-sm justify-content-center">
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidadCarrito(${producto.producto_id}, ${cantidad - 1})">-</button>
                                    <input type="text" class="form-control text-center" value="${cantidad}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="actualizarCantidadCarrito(${producto.producto_id}, ${cantidad + 1})">+</button>
                                </div>
                            </td>
                            <td>$${totalProducto.toFixed(2)}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(${producto.producto_id})">Eliminar</button>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                }
                // Actualizar totales
                document.getElementById('cart-subtotal').textContent = `$${subtotal.toFixed(2)}`;
                // Si tienes lógica de envío, agrégala aquí
                document.getElementById('cart-total').textContent = `$${subtotal.toFixed(2)}`; // Por ahora, total = subtotal
            })
            .catch(error => {
                console.error('Error al obtener productos del carrito:', error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-danger">Error al cargar el carrito. Intente de nuevo.</td></tr>';
                showCustomModal('Error', 'No se pudieron cargar los productos del carrito. Por favor, intente de nuevo.', 'error');
            });
        }

        /**
         * Actualiza la cantidad de un producto en el carrito.
         * @param {number} producto_id - ID del producto.
         * @param {number} nueva_cantidad - La nueva cantidad deseada.
         */
        window.actualizarCantidadCarrito = function(producto_id, nueva_cantidad) {
            if (nueva_cantidad < 1) {
                // Si la cantidad es 0 o menos, preguntar si desea eliminar
                if (confirm('¿Desea eliminar este producto del carrito?')) {
                    eliminarDelCarrito(producto_id);
                }
                return;
            }

            fetch('../controller/carritoController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `accion=actualizar&producto_id=${producto_id}&cantidad=${nueva_cantidad}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    obtenerProductosCarrito(); // Recargar el carrito para ver los cambios
                    showCustomModal('Éxito', 'Cantidad actualizada correctamente.', 'success');
                } else {
                    showCustomModal('Error', 'Error al actualizar la cantidad: ' + (data.message || 'Error desconocido.'), 'error');
                }
            })
            .catch(error => {
                console.error('Error al actualizar cantidad:', error);
                showCustomModal('Error', 'Error de conexión al actualizar la cantidad.', 'error');
            });
        };

        /**
         * Elimina un producto del carrito.
         * @param {number} producto_id - ID del producto a eliminar.
         */
        window.eliminarDelCarrito = function(producto_id) {
            fetch('../controller/carritoController.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'accion=eliminar&producto_id=' + producto_id
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    obtenerProductosCarrito(); // Recargar el carrito
                    showCustomModal('Éxito', 'Producto eliminado del carrito.', 'success');
                } else {
                    showCustomModal('Error', 'Error al eliminar el producto: ' + (data.message || 'Error desconocido.'), 'error');
                }
            })
            .catch(error => {
                console.error('Error al eliminar:', error);
                showCustomModal('Error', 'Error de conexión al eliminar el producto.', 'error');
            });
        };

        // Evento para el botón de proceder al pago
        document.getElementById('proceed-to-checkout').addEventListener('click', function() {
            // Aquí iría la lógica para redirigir al proceso de pago
            showCustomModal('Información', 'Funcionalidad de pago no implementada aún.', 'info');
            // window.location.href = 'checkout.php'; // Redirigir a la página de checkout
        });

        // Inicializar la carga del carrito al cargar la página
        obtenerProductosCarrito();
    });
    </script>
    <!-- Tus scripts JS originales (si los tienes en archivos separados) -->
    <!-- <script src="../public/js/producto.js"></script> -->
    <!-- <script src="../public/js/index.js"></script> -->
    <!-- <script src="../public/js/app.js"></script> -->
</body>
</html>
