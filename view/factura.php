<?php
session_start();
require_once '../config/confConexion.php'; // Asegúrate de que esta ruta sea correcta

// Asumiendo que $conn es la variable de conexión a la base de datos
global $conn; 

if (!isset($_GET['id'])) {
    echo "<div class='container mt-5 alert alert-danger'>Error: Pedido no especificado.</div>";
    exit;
}

$pedido_id = intval($_GET['id']);

// Obtener datos del pedido
// Utiliza los nombres de columnas y tablas de tu código original: pedido, usuario
// NOTA: Tu tabla 'pedido' actual solo tiene 'total'. No tiene 'metodo_pago' o 'costo_envio'.
// Estoy asumiendo que el 'total' que tienes en la tabla 'pedido' ya incluye el costo de envío
// si es que lo manejas en algún otro lugar (por ejemplo, fijo en checkout).
// Si necesitas 'metodo_pago' o 'costo_envio', deberías añadirlos a la tabla 'pedido'.
$queryPedido = "SELECT p.pedido_id, p.fecha_pedido, p.total AS total_pedido_db, 
                       u.nombre_completo, u.direccion, u.correo, u.telefono
                FROM pedido p
                JOIN usuario u ON p.usuario_id = u.usuario_id
                WHERE p.pedido_id = ?";
$stmt = $conn->prepare($queryPedido);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$result = $stmt->get_result();
$pedido = $result->fetch_assoc();
$stmt->close();

if (!$pedido) {
    echo "<div class='container mt-5 alert alert-warning'>Pedido no encontrado.</div>";
    exit;
}

// Obtener productos del pedido
// Utiliza los nombres de columnas y tablas de tu código original: pedidoproducto, producto
$queryProductos = "SELECT pr.nombre, pp.cantidad, pr.precio, (pp.cantidad * pr.precio) AS subtotal_linea
                   FROM pedidoproducto pp
                   JOIN producto pr ON pp.producto_id = pr.producto_id
                   WHERE pp.pedido_id = ?";
$stmt = $conn->prepare($queryProductos);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$result = $stmt->get_result();
$productos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Obtener el valor del IVA de la tabla de configuración
$iva_porcentaje = 0; // Valor por defecto en caso de no encontrarlo
$queryIVA = "SELECT valor FROM configuracion WHERE clave = 'iva_actual'";
$resultIVA = $conn->query($queryIVA);
if ($resultIVA && $rowIVA = $resultIVA->fetch_assoc()) {
    $iva_porcentaje = floatval($rowIVA['valor']);
}

// Calcular totales
$subtotal_sin_iva = 0;
foreach ($productos as $prod) {
    $subtotal_sin_iva += $prod['subtotal_linea'];
}

// El costo de envío se establecerá fijo en 0.00 porque no está en tu DB actual.
// Si lo añades a la tabla 'pedido' en el futuro, cámbialo.
$costo_envio = 0.00;

$iva_monto = $subtotal_sin_iva * ($iva_porcentaje / 100);
$total_final = $subtotal_sin_iva + $iva_monto + $costo_envio;

// === Datos de la empresa (pueden ser fijos para el proyecto) ===
$nombre_empresa = "Pescadería Don Walter";
$direccion_empresa = "Av. Canonigo Ramos y Av.11 de Noviembre - Riobamba";
$telefono_empresa = "09924700553 / 0982744920";
$email_empresa = "info@pescaderiadonwalter.com";
$metodo_pago_simulado = "Pago Contra Entrega"; // Como no lo obtienes de DB, pon un valor fijo o una variable

// Formatear la fecha
$fecha_formato = (new DateTime($pedido['fecha_pedido']))->format('d/m/Y H:i:s');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Pedido #<?= htmlspecialchars($pedido_id) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../public/css/style.css"> 
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .invoice-container {
            max-width: 900px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .invoice-header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .invoice-header h1 {
            color: #007bff;
            font-weight: 700;
            margin: 0;
            font-size: 2.5rem;
        }
        .invoice-meta {
            text-align: right;
        }
        .invoice-meta p {
            margin-bottom: 5px;
            font-size: 0.95rem;
        }
        .invoice-meta strong {
            color: #555;
        }
        .section-title {
            color: #007bff;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .customer-info p, .company-info p {
            margin-bottom: 3px;
            font-size: 0.9rem;
        }
        .table th {
            background-color: #f2f7fc;
            color: #007bff;
            font-weight: 600;
            border-bottom: 1px solid #e0e6ed !important;
        }
        .table td {
            font-size: 0.9rem;
            vertical-align: middle;
        }
        .table tfoot td {
            border-top: 2px solid #007bff;
            font-weight: 700;
            font-size: 1rem;
        }
        .total-amount {
            font-size: 1.4rem;
            color: #dc3545; /* Rojo para el total, para que resalte */
        }
        .invoice-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #777;
            font-size: 0.85rem;
        }
        .logo {
            max-width: 180px;
            height: auto;
        }
        @media print {
            body {
                background-color: #fff;
            }
            .invoice-container {
                box-shadow: none;
                margin: 0;
                padding: 0;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container invoice-container">
        <div class="invoice-header">
            <div>
                <?php if (file_exists('../public/img/Pescaderia Don Walter logo.png')): ?>
                    <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Empresa" class="logo">
                <?php else: ?>
                    <h1 class="mb-0"><?= htmlspecialchars($nombre_empresa); ?></h1>
                <?php endif; ?>
                <p class="mt-2 mb-0"><strong><?= htmlspecialchars($direccion_empresa); ?></strong></p>
                <p>Tel: <?= htmlspecialchars($telefono_empresa); ?></p>
                <p>Email: <?= htmlspecialchars($email_empresa); ?></p>
            </div>
            <div class="invoice-meta">
                <h1>FACTURA</h1>
                <p><strong>Factura No:</strong> #<?= htmlspecialchars($pedido_id) ?></p>
                <p><strong>Fecha:</strong> <?= htmlspecialchars($fecha_formato) ?></p>
                <p><strong>Estado:</strong> <span class="badge bg-success">Completado</span></p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 customer-info">
                <h5 class="section-title">Facturado a:</h5>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($pedido['nombre_completo']) ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($pedido['direccion']) ?></p>
                <p><strong>Correo:</strong> <?= htmlspecialchars($pedido['correo']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($pedido['telefono']) ?></p>
            </div>
            <div class="col-md-6 company-info text-md-end">
                <h5 class="section-title">Detalles de Pago:</h5>
                <p><strong>Método:</strong> <?= htmlspecialchars($metodo_pago_simulado) ?></p>
                <p><strong>ID de Transacción:</strong> N/A</p>
                <p><strong>Fecha de Pago:</strong> <?= htmlspecialchars($fecha_formato) ?></p>
            </div>
        </div>

        <div class="item-details">
            <h5 class="section-title">Resumen de Productos</h5>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unitario</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= htmlspecialchars($producto['nombre']) ?></td>
                            <td class="text-center"><?= htmlspecialchars($producto['cantidad']) ?></td>
                            <td class="text-end">$<?= number_format($producto['precio'], 2) ?></td>
                            <td class="text-end">$<?= number_format($producto['subtotal_linea'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Subtotal Sin IVA:</td>
                        <td class="text-end">$<?= number_format($subtotal_sin_iva, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">IVA (<?= htmlspecialchars($iva_porcentaje); ?>%):</td>
                        <td class="text-end">$<?= number_format($iva_monto, 2) ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end">Costo de Envío:</td>
                        <td class="text-end">$<?= number_format($costo_envio, 2) ?></td>
                    </tr>
                    <tr class="table-info total-row">
                        <td colspan="3" class="text-end"><strong>TOTAL A PAGAR:</strong></td>
                        <td class="text-end total-amount"><strong>$<?= number_format($total_final, 2) ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="invoice-footer">
            <p>¡Gracias por tu compra en **<?= htmlspecialchars($nombre_empresa); ?>**!</p>
            <p>Esperamos verte de nuevo.</p>
            <a href="../index.html" class="btn btn-primary mt-3 me-2">Volver al Inicio</a>
            <button class="btn btn-secondary mt-3" onclick="window.print()">Imprimir Factura <i class="bi bi-printer"></i></button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>