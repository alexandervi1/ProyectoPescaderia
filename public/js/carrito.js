function cambiarCantidad(cambio) {
    let cantidadInput = document.getElementById('cantidad');
    let cantidadActual = parseInt(cantidadInput.value);
    let nuevaCantidad = cantidadActual + cambio;

    if (nuevaCantidad >= 1) { // Asegura que la cantidad no sea menor a 1
        cantidadInput.value = nuevaCantidad;
    }
}

// Función para agregar al carrito
function agregarAlCarrito(productoId, cantidad) {
    cantidad = parseInt(cantidad);

    if (isNaN(cantidad) || cantidad <= 0) {
        mostrarModal("Por favor, ingrese una cantidad válida.");
        return;
    }

    // AQUI LA RUTA ES CLAVE: Desde public/js/ hacia controller/carritoController.php
    // Si tu estructura es:
    // tu_proyecto/
    // ├── public/
    // │   └── js/
    // │       ├── producto.js
    // │       └── carrito.js <--- ESTE ARCHIVO
    // └── controller/
    //     └── carritoController.php
    // Entonces, de public/js/ debes salir a public/ (../) y luego entrar a controller/
    // Por lo tanto, la ruta es: ../controller/carritoController.php
    fetch('../controller/carritoController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'accion=agregar&producto_id=' + productoId + '&cantidad=' + cantidad
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.exito) { // Cambié de 'status' a 'exito' para coincidir con mi PHP de ejemplo
            mostrarModal('Producto agregado al carrito: ' + data.mensaje);
        } else {
            mostrarModal('Error al agregar al carrito: ' + data.mensaje);
        }
    })
    .catch(error => {
        console.error('Error al agregar al carrito:', error);
        mostrarModal("Ocurrió un error al intentar agregar el producto.");
    });
}

// Esta función mostrarModal debe estar accesible.
// Si tu producto.js y carrito.js están en el mismo nivel y producto.js se carga primero,
// mostrarModal puede estar en producto.js. Si no, debería estar aquí o en un tercer archivo compartido.
// Para simplificar, la dejaré aquí por ahora si el otro script no la necesita directamente.
function mostrarModal(mensaje) {
    const modal = document.getElementById('modal');
    const modalMensaje = document.getElementById('modal-mensaje');
    
    if (modal && modalMensaje) { // Asegúrate de que los elementos existan
        modalMensaje.textContent = mensaje;
        modal.style.display = 'flex'; // Usamos 'flex' para centrar, como habíamos discutido
        modal.style.opacity = '1';

        setTimeout(() => {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 500); // Espera a que la transición de opacidad termine
        }, 3000); // Modal visible por 3 segundos
    } else {
        console.error("Elementos del modal no encontrados.");
        alert(mensaje); // Fallback si el modal no se encuentra
    }
}

// Asegurarse de que el modal se pueda cerrar haciendo clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (modal && event.target == modal) {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 500);
    }
}