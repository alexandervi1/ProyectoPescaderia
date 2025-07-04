<?php
include("../config/confConexion.php");

$query = "SELECT p.producto_id, p.nombre, p.descripcion, p.precio, p.stock, p.descuento, p.imagen_url, c.nombre AS categoria
          FROM Producto p
          JOIN Categoria c ON p.categoria_id = c.categoria_id
          WHERE p.stock < 6";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['producto_id'] . "</td>";
        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
        echo "<td>" . htmlspecialchars($row['descuento']) . "%</td>";
        echo "<td>" . htmlspecialchars($row['categoria']) . "</td>";
        echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
        echo "<td>$" . number_format($row['precio'], 2) . "</td>";
        echo "<td>" . $row['stock'] . "</td>";
        echo "<td><button class='btn btn-warning btn-edit bi bi-pencil-fill' data-id='" . $row['producto_id'] . "' data-nombre='" . htmlspecialchars($row['nombre']) . "' data-descuento='" . htmlspecialchars($row['descuento']) . "' data-categoria='" . htmlspecialchars($row['categoria']) . "' data-descripcion='" . htmlspecialchars($row['descripcion']) . "' data-precio='" . htmlspecialchars($row['precio']) . "' data-stock='" . $row['stock'] . "'> </button></td>";
        echo "</tr>";
    } 

} else {
    echo "<tr><td colspan='9'>No hay productos con stock menor a 6.</td></tr>";
}

$conn->close();
?>