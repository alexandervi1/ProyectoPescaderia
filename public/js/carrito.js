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
    // ========== CARGAR PRODUCTOS DEL CARRITO ==========
});

function cargarProductosCarrito() {
    fetch('../model/mObtCarrito.php') // Asegúrate de que esta ruta sea la correcta a tu script PHP
        .then(res => {
            // Manejo de respuestas HTTP que no sean OK (ej. 401, 404, 500)
            if (!res.ok) {
                // Intentamos leer la respuesta como JSON para obtener un mensaje de error del servidor
                return res.json().then(errorData => {
                    // Si el servidor envió un JSON con un mensaje de error, lo usamos
                    throw new Error(errorData.message || `Error HTTP: ${res.status}`);
                }).catch(() => {
                    // Si la respuesta no es JSON (ej. HTML de error 404/500), lanzamos un error genérico
                    throw new Error(`Error HTTP: ${res.status} al obtener el carrito.`);
                });
            }
            return res.json(); // Si la respuesta es OK, la parseamos como JSON
        })
        .then(data => {
            const tbody = document.getElementById("cart-items-body");
            const totalElem = document.getElementById("cart-total");

            if (data.status === 'success') {
                tbody.innerHTML = ''; // Limpiamos la tabla antes de añadir los productos
                
                // Usamos el total calculado por el backend para mayor precisión. 
                // Aseguramos que sea un número antes de usar toFixed().
                let totalCarritoBackend = parseFloat(data.total || 0);

                if (isNaN(totalCarritoBackend)) {
                    console.warn("Advertencia: El total del carrito del backend no es un número válido. Calculando en frontend.");
                    totalCarritoBackend = 0; // Si no es válido, inicializamos a 0
                }

                if (data.productos && data.productos.length > 0) {
                    data.productos.forEach(p => {
                        // Convertir a número con parseFloat() antes de cualquier operación matemática o toFixed()
                        const precioProducto = parseFloat(p.precio);
                        const cantidadProducto = parseInt(p.cantidad);
                        const subtotalProducto = parseFloat(p.subtotal); // Usamos el subtotal que viene del backend

                        // Validación básica para asegurar que los valores son números
                        if (isNaN(precioProducto) || isNaN(cantidadProducto) || isNaN(subtotalProducto)) {
                            console.error("Error: Datos de producto inválidos recibidos:", p);
                            // Omitir esta fila o mostrar un error para ella
                            return; // Pasa a la siguiente iteración del bucle
                        }

                        const fila = `
                            <tr>
                                <td><img src="../${p.imagen_url}" class="img-fluid" style="max-width: 80px;"></td>
                                <td>${p.nombre_producto}</td>
                                <td>$${precioProducto.toFixed(2)}</td>
                                <td>
                                    <div class="input-group input-group-sm justify-content-center">
                                        <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${p.producto_id}, -1)">-</button>
                                        <input type="text" id="cantidad-${p.producto_id}" value="${cantidadProducto}" class="form-control form-control-sm text-center" readonly>
                                        <button class="btn btn-outline-secondary" onclick="cambiarCantidad(${p.producto_id}, 1)">+</button>
                                    </div>
                                </td>
                                <td>$${subtotalProducto.toFixed(2)}</td>
                                <td><button class="btn btn-danger btn-sm" onclick="eliminarProducto(${p.producto_id})"><i class="bi bi-trash"></i></button></td>
                            </tr>
                        `;
                        tbody.innerHTML += fila;
                    });
                    totalElem.textContent = `$${totalCarritoBackend.toFixed(2)}`; // Muestra el total del backend
                } else {
                    // Carrito vacío
                    tbody.innerHTML = `<tr><td colspan="6">Tu carrito está vacío.</td></tr>`;
                    totalElem.textContent = "$0.00";
                }
            } else {
                // Si el backend devuelve status: 'error' (ej. "Usuario no autenticado")
                tbody.innerHTML = `<tr><td colspan="6">${data.message || 'Error desconocido al cargar el carrito.'}</td></tr>`;
                totalElem.textContent = "$0.00";
            }
        })
        .catch(error => {
            console.error("Error en la petición de carga del carrito:", error);
            const tbody = document.getElementById("cart-items-body");
            const totalElem = document.getElementById("cart-total");

            // Personaliza el mensaje de error para el usuario basado en el tipo de error
            if (error.message.includes("401")) { // Si el error es por HTTP 401 (Usuario no autenticado)
                tbody.innerHTML = '<tr><td colspan="6">Por favor, <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">inicia sesión</a> para ver tu carrito.</td></tr>';
            } else if (error.message.includes("Unexpected token '<'")) { // Si hay un error de JSON inválido (ej. HTML)
                 tbody.innerHTML = '<tr><td colspan="6">Error de formato en la respuesta del servidor.</td></tr>';
            } else {
                tbody.innerHTML = `<tr><td colspan="6">Error al cargar el carrito: ${error.message}. Por favor, inténtalo de nuevo más tarde.</td></tr>`;
            }
            totalElem.textContent = "$0.00";
        });
}