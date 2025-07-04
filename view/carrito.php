<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    die("Error: Usuario no autenticado.");
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
    <link href="/public/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/carrito.css">
</head>
<body>

<div class="container mt-5">
    <h2>Carrito de Compras</h2>
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
        </tbody>
    </table>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmacionModal" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-success text-white">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="confirmacionModalLabel">Confirmación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-check-circle" style="font-size: 2rem;"></i>
                <p>Enviado al carrito</p>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    function obtenerProductosCarrito() {
        fetch('../controller/carritoController.php')
        .then(response => response.json())
        .then(data => {
            console.log("Datos recibidos:", data); // ✅ Verificar en consola

            const tbody = document.querySelector('#carrito-table tbody');
            tbody.innerHTML = '';

            if (data.productos.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5">El carrito está vacío.</td></tr>';
            } else {
                data.productos.forEach(producto => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${producto.nombre}</td>
                        <td>$${parseFloat(producto.precio).toFixed(2)}</td>
                        <td>${parseInt(producto.cantidad)}</td>
                        <td>$${(parseFloat(producto.precio) * parseInt(producto.cantidad)).toFixed(2)}</td>
                        <td>
                            <button class="btn btn-danger" onclick="eliminarDelCarrito(${producto.producto_id})">Eliminar</button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function eliminarDelCarrito(producto_id) {
        fetch('../controller/carritoController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'accion=eliminar&producto_id=' + producto_id
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == 'success') {
                obtenerProductosCarrito();
                mostrarConfirmacionModal();
            } else {
                alert('Error al eliminar el producto del carrito: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function mostrarConfirmacionModal() {
        var confirmacionModal = new bootstrap.Modal(document.getElementById('confirmacionModal'));
        confirmacionModal.show();
    }

    obtenerProductosCarrito();
});
</script>

</body>
</html>