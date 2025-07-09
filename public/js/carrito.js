document.addEventListener("DOMContentLoaded", function () {
    cargarProductosCarrito();

    // ========== CAMBIAR CANTIDAD ==========
    window.cambiarCantidad = function(producto_id, delta) {
        const inputCantidad = document.getElementById(`cantidad-${producto_id}`);
        let cantidadActual = parseInt(inputCantidad.value);
        let nuevaCantidad = cantidadActual + delta;
        if (nuevaCantidad < 1) nuevaCantidad = 1;
        inputCantidad.value = nuevaCantidad;

        fetch('../model/mActualizarCarrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `producto_id=${producto_id}&cantidad=${nuevaCantidad}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                cargarProductosCarrito();
            } else {
                alert(data.message || 'Error al actualizar la cantidad.');
            }
        })
        .catch(error => console.error('Error al actualizar cantidad:', error));
    };

    // ========== ELIMINAR PRODUCTO ==========
    window.eliminarProducto = function(producto_id) {
        if (!confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) return;

        fetch('../model/mEliminarDelCarrito.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `producto_id=${producto_id}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                cargarProductosCarrito();
            } else {
                alert(data.message || 'Error al eliminar el producto.');
            }
        })
        .catch(error => console.error('Error al eliminar producto:', error));
    };

    // ========== PROCEDER AL PAGO ==========
    const btnPagar = document.querySelector(".checkout-btn-container button");
    if (btnPagar) {
        btnPagar.addEventListener("click", function () {
            fetch('../model/MRegistrarPedido.php', {
                method: 'POST'
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // o redirigir a página de gracias
                } else {
                    alert("Error: " + data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert("Error al procesar el pedido.");
            });
        });
    }
});
