document.addEventListener("DOMContentLoaded", function () {
    const botonPago = document.querySelector(".checkout-btn-container button");
    if (botonPago) {
        botonPago.addEventListener("click", function () {
            fetch('../model/MIngresoPedido.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ accion: 'registrar_pedido' })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Pedido registrado exitosamente.");
                    location.href = "factura.php?id=" + data.pedido_id; // o redirige donde necesites
                } else {
                    alert("Error al registrar pedido: " + data.message);
                }
            })
            .catch(error => {
                console.error("Error en la solicitud:", error);
                alert("Hubo un problema al registrar el pedido.");
            });
        });
    }
});
 