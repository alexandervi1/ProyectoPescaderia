<?php
include("../config/confConexion.php");

$query = "
    SELECT p.pedido_id, p.fecha_pedido, p.total, u.nombre_completo, pp.producto_id, pr.nombre AS producto_nombre, pp.cantidad, pp.precio_unitario
    FROM Pedido p
    JOIN Usuario u ON p.usuario_id = u.usuario_id
    JOIN PedidoProducto pp ON p.pedido_id = pp.pedido_id
    JOIN Producto pr ON pp.producto_id = pr.producto_id
    ORDER BY p.fecha_pedido DESC
";

$result = $conn->query($query);

$ventas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ventas[] = $row;
    }
}

$conn->close();
?>