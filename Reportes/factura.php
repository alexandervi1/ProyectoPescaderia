<?php
include("conexion.php"); // tu archivo de conexión

$pedido_id = $_GET['pedido_id'];

$sql = "SELECT 
    p.pedido_id,
    u.nombre_completo AS cliente,
    p.fecha_pedido,
    pr.nombre AS producto,
    pp.cantidad,
    pr.precio,
    (pp.cantidad * pr.precio) AS subtotal
FROM pedido p
JOIN usuario u ON u.usuario_id = p.usuario_id
JOIN pedidoproducto pp ON pp.pedido_id = p.pedido_id
JOIN producto pr ON pr.producto_id = pp.producto_id
WHERE p.pedido_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$result = $stmt->get_result();

$datos = [];
while($row = $result->fetch_assoc()) {
    $datos[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura</title>
  <style>
    body { font-family: Arial; }
    .factura { max-width: 700px; margin: auto; border: 1px solid #ccc; padding: 20px; }
    .factura h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    .totales { text-align: right; margin-top: 15px; }
    .btn-imprimir { margin-top: 20px; display: block; text-align: center; }
  </style>
</head>
<body>
<div class="factura">
  <h2>Factura</h2>
  <p><strong>Cliente:</strong> <?= $datos[0]['cliente'] ?></p>
  <p><strong>Pedido Nº:</strong> <?= $datos[0]['pedido_id'] ?></p>
  <p><strong>Fecha:</strong> <?= $datos[0]['fecha_pedido'] ?></p>

  <table>
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $total = 0;
        foreach ($datos as $item) {
          $total += $item['subtotal'];
          echo "<tr>
                  <td>{$item['producto']}</td>
                  <td>{$item['cantidad']}</td>
                  <td>$ {$item['precio']}</td>
                  <td>$ {$item['subtotal']}</td>
                </tr>";
        }
      ?>
    </tbody>
  </table>

  <div class="totales">
    <p><strong>Total: $<?= number_format($total, 2) ?></strong></p>
  </div>

  <div class="btn-imprimir">
    <button onclick="window.print()">Imprimir</button>
  </div>
</div>
</body>
</html>
