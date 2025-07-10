<?php
// ====================================================================
// 1. CONFIGURACIÓN DE LA BASE DE DATOS Y CONEXIÓN
// ====================================================================
$dbConfig = [
    'host' => 'localhost',
    'database' => 'pescaderia', // Asegúrate de que este sea el nombre correcto de tu base de datos
    'username' => 'root',        // ¡IMPORTANTE: CAMBIA ESTO por tu usuario de MySQL!
    'password' => ''             // ¡IMPORTANTE: CAMBIA ESTO por tu contraseña de MySQL!
];

$pdo = null; // Inicializar la variable PDO
try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Es mejor registrar el error y mostrar un mensaje genérico al usuario
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    die("Lo sentimos, no pudimos conectar con la base de datos en este momento. Por favor, inténtelo más tarde.");
}

// ====================================================================
// 2. FUNCIONES PARA OBTENER DATOS
// ====================================================================

/**
 * Obtiene todos los clientes de la base de datos con rol de 'Cliente'.
 *
 * @param PDO $pdo Objeto PDO de conexión a la base de datos.
 * @return array Una matriz de clientes o una matriz vacía si hay un error.
 */
function getClientes(PDO $pdo): array {
    $sql = "
        SELECT
            usuario_id,
            nombre_completo
        FROM
            usuario
        WHERE
            rol_id = 2 -- Asume que el rol_id 2 es para 'Cliente'
        ORDER BY
            nombre_completo ASC;
    ";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error al obtener la lista de clientes: " . $e->getMessage());
        return [];
    }
}

/**
 * Obtiene los pedidos de un cliente específico por su ID.
 *
 * @param PDO $pdo Objeto PDO de conexión a la base de datos.
 * @param int $clienteId El ID del cliente.
 * @return array Una matriz de pedidos del cliente o una matriz vacía si hay un error o no hay pedidos.
 */
function getPedidosPorClienteId(PDO $pdo, int $clienteId): array {
    $sql = "
        SELECT
            p.pedido_id AS numero_pedido,
            DATE_FORMAT(p.fecha_pedido, '%Y-%m-%d %H:%i') AS fecha_pedido_formateada,
            p.total AS total_pedido
        FROM
            pedido p
        WHERE
            p.usuario_id = :cliente_id
        ORDER BY
            p.fecha_pedido DESC;
    ";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cliente_id', $clienteId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error al ejecutar la consulta de pedidos por cliente: " . $e->getMessage());
        return [];
    }
}

/**
 * Obtiene los detalles de un pedido específico, incluyendo el nombre del producto y la cantidad.
 *
 * @param PDO $pdo Objeto PDO de conexión a la base de datos.
 * @param int $pedidoId El ID del pedido.
 * @return array Una matriz de detalles del pedido o una matriz vacía si hay un error o no hay detalles.
 */
function getDetallesPedidoPorPedidoId(PDO $pdo, int $pedidoId): array {
    $sql = "
        SELECT
            pd.cantidad,
            p.nombre AS nombre_producto,
            pd.precio_unitario,
            pd.subtotal AS subtotal_detalle
        FROM
            pedido_detalle pd
        INNER JOIN
            producto p ON pd.producto_id = p.producto_id
        WHERE
            pd.pedido_id = :pedido_id;
    ";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error al obtener los detalles del pedido: " . $e->getMessage());
        return [];
    }
}

// ====================================================================
// 3. LÓGICA PRINCIPAL
// ====================================================================
$clientes = getClientes($pdo);
$pedidosCliente = [];
$clienteSeleccionadoId = null;
$clienteSeleccionadoNombre = '';
$totalGastado = 0;

// Procesar el formulario si se ha enviado un cliente_id
if (isset($_GET['cliente_id']) && !empty($_GET['cliente_id'])) {
    $clienteSeleccionadoId = filter_var($_GET['cliente_id'], FILTER_VALIDATE_INT); // Sanitizar la entrada

    if ($clienteSeleccionadoId === false) {
        // Manejar el caso de un ID de cliente inválido
        $clienteSeleccionadoId = null;
        // Podrías añadir un mensaje de error para el usuario aquí
    } else {
        $pedidosCliente = getPedidosPorClienteId($pdo, $clienteSeleccionadoId);

        // Encontrar el nombre del cliente seleccionado y calcular el total gastado
        foreach ($clientes as $cliente) {
            if ($cliente['usuario_id'] == $clienteSeleccionadoId) {
                $clienteSeleccionadoNombre = htmlspecialchars($cliente['nombre_completo']);
                break;
            }
        }
        
        foreach ($pedidosCliente as &$pedido) { // Usar & para pasar por referencia y modificar el array
            $pedido['detalles'] = getDetallesPedidoPorPedidoId($pdo, $pedido['numero_pedido']);
            $totalGastado += (float)$pedido['total_pedido'];
        }
        unset($pedido); // Romper la referencia al último elemento
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos por Cliente - Pescadería Don Walter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* ====================================================================
           Variables CSS para un control de tema más sencillo
           ==================================================================== */
        :root {
            --primary-blue: #1A519D;
            --dark-blue: #002E5D; /* Un tono más oscuro para bordes o sombras sutiles */
            --light-blue: #7CCCED;
            --background-light: #f8f9fa;
            --container-bg: #fff;
            --text-dark: #333;
            --text-muted: #6c757d;
            --text-light: #ffffff; /* Color de texto para fondos oscuros */
            --border-light: #dee2e6;
            --table-stripe: rgba(26, 81, 157, 0.03); /* Un azul muy tenue para filas impares */
            --table-hover: rgba(26, 81, 157, 0.08); /* Un poco más oscuro al pasar el ratón */

            /* Colores de Bootstrap que pueden necesitar sobrescribirse con más especificidad */
            --bs-info: #0dcaf0;
            --bs-success: #198754;
            --bs-warning: #ffc107;
            --bs-danger: #dc3545; /* Rojo para alertas */
        }

        /* ====================================================================
           Estilos Generales y Reseteos (Alineados con tu style.css)
           ==================================================================== */
        body {
            background-color: var(--background-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* ====================================================================
           Navbar
           ==================================================================== */
        .navbar {
            background-color: var(--primary-blue); /* Usando variable */
            padding: 10px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Agregada sombra para darle profundidad */
        }

        .navbar-brand img {
            background-color: var(--container-bg); /* Blanco */
            padding: 5px;
            border-radius: 5px;
        }

        /* Botón "Volver al Panel de Administrador" y "Imprimir Reporte" */
        .navbar .btn-secondary-custom { /* Cambiado a una clase personalizada para evitar sobrescribir btn-warning */
            background-color: var(--primary-blue);
            color: var(--text-light);
            border: 1px solid var(--text-light);
            transition: all 0.3s ease; /* Transición suave para hover */
        }

        .navbar .btn-secondary-custom:hover {
            background-color: var(--light-blue);
            border-color: var(--light-blue);
            color: var(--dark-blue); /* Cambio de color de texto al hacer hover para mejor contraste */
        }

        .navbar .btn-print { /* Clase específica para el botón de imprimir */
            background-color: var(--light-blue);
            color: var(--dark-blue);
            border: 1px solid var(--light-blue);
            transition: all 0.3s ease;
        }

        .navbar .btn-print:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
            color: var(--text-light);
        }

        /* ====================================================================
           Contenedor Principal del Reporte
           ==================================================================== */
        .container.report-section {
            background-color: var(--container-bg);
            padding: 2.5rem; /* Un poco más de padding */
            margin-top: 2rem;
            margin-bottom: 2rem;
            border-radius: 0.75rem; /* Bordes más redondeados */
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1); /* Sombra más pronunciada */
            color: var(--text-dark);
        }

        /* Títulos y Encabezados */
        .report-section h1 {
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            text-align: center; /* Centrar el título principal */
            font-weight: 700; /* Más negrita */
            font-size: 2.5rem; /* Tamaño de fuente más grande */
        }

        .report-section .lead {
            color: var(--text-muted); /* Usar la variable para texto muted */
            margin-bottom: 2.5rem;
            text-align: center; /* Centrar el texto introductorio */
            font-size: 1.1rem;
        }

        /* ====================================================================
           Estilo de la tarjeta de resumen
           ==================================================================== */
        .card.summary-card { /* Clase más descriptiva */
            border: 1px solid var(--border-light); /* Borde suave */
            border-radius: 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05); /* Sombra suave */
        }

        .card-header {
            background-color: var(--primary-blue);
            color: var(--text-light);
            border-bottom: 1px solid var(--dark-blue);
            font-weight: bold;
            padding: 1rem 1.5rem; /* Más padding en el header de la tarjeta */
            border-top-left-radius: 0.65rem; /* Ajustar borde superior de la tarjeta */
            border-top-right-radius: 0.65rem;
        }

        .card-body .summary-box { /* Clase para las cajas de resumen */
            background-color: var(--background-light); /* Fondo ligeramente gris para las cajas de resumen */
            border: 1px solid var(--border-light);
            border-radius: 0.5rem;
            box-shadow: inset 0 0.05rem 0.15rem rgba(0, 0, 0, 0.03); /* Sombra interna sutil */
            padding: 1.5rem; /* Más padding */
            transition: all 0.2s ease-in-out;
        }

        .card-body .summary-box:hover {
            transform: translateY(-3px); /* Efecto hover sutil */
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.08);
        }

        /* Asegurando la visibilidad de los números de resumen con colores de Bootstrap */
        .card-body h4.text-info { color: var(--bs-info); font-weight: bold; font-size: 1.8rem; }
        .card-body h4.text-success { color: var(--bs-success); font-weight: bold; font-size: 1.8rem; }
        .card-body h4.text-warning { color: var(--bs-warning); font-weight: bold; font-size: 1.8rem; }
        .card-body p.text-muted {
            color: var(--text-muted);
            font-weight: normal;
            font-size: 0.95rem;
        }

        /* ====================================================================
           Formulario de selección de cliente
           ==================================================================== */
        .form-select {
            border-color: var(--border-light);
            box-shadow: inset 0 1px 2px rgba(0,0,0,.075);
        }
        .form-select:focus {
            border-color: var(--light-blue);
            box-shadow: 0 0 0 0.25rem rgba(124, 204, 237, 0.25); /* Sombra de foco más suave */
        }
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        /* ====================================================================
           Tabla de Reporte
           ==================================================================== */
        .table-responsive {
            margin-top: 2rem; /* Más margen superior */
            border-radius: 0.75rem; /* Bordes redondeados */
            overflow: hidden;
            box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.08); /* Sombra para la tabla */
        }

        .table thead th {
            background-color: var(--primary-blue);
            color: var(--text-light);
            border-bottom: 2px solid var(--dark-blue);
            padding: 1rem; /* Más padding en encabezados */
            text-align: left;
            white-space: nowrap;
            font-weight: 600; /* Un poco más de negrita */
            font-size: 1rem;
        }

        .table tbody td {
            padding: 0.85rem 1rem; /* Más padding */
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: var(--table-stripe);
        }

        .table tbody tr:hover {
            background-color: var(--table-hover);
            cursor: default; /* Indicar que no es clicable */
        }

        .alert-warning {
            border-radius: 0.5rem;
            margin-top: 1.5rem;
            padding: 1.25rem;
            font-size: 1.1rem;
        }

        /* Estilos para la tabla de detalles del producto anidada */
        .table-details {
            margin-top: 10px;
            margin-bottom: 5px;
            width: 100%;
            border-collapse: collapse;
        }
        .table-details th, .table-details td {
            padding: 5px;
            border: 1px solid var(--border-light);
            font-size: 0.85rem;
        }
        .table-details thead th {
            background-color: var(--light-blue);
            color: var(--dark-blue);
            font-weight: 600;
        }
        .table-details tbody tr:nth-of-type(odd) {
            background-color: var(--table-stripe);
        }
        .table-details tbody td {
            background-color: var(--container-bg); /* Asegura que no herede el rayado del padre */
        }


        /* ====================================================================
           Footer
           ==================================================================== */
        footer {
            background-color: var(--primary-blue);
            color: var(--text-light);
            text-align: center;
            padding: 20px 0; /* Más padding */
            margin-top: 3rem; /* Más margen superior para separarlo del contenido */
            border-top: 5px solid var(--dark-blue); /* Un borde superior más definido */
        }

        footer p {
            color: var(--text-light);
            margin-bottom: 8px; /* Espacio entre líneas */
            font-size: 0.95rem;
        }

        .footer-icons a {
            color: var(--text-light);
            margin: 0 12px; /* Más espacio entre iconos */
            font-size: 26px; /* Iconos un poco más grandes */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-icons a:hover {
            color: var(--light-blue);
        }

        /* ====================================================================
           Estilos de impresión
           ==================================================================== */
        @media print {
            body {
                background-color: #fff !important; /* Fondo blanco para impresión */
                color: #000 !important; /* Texto negro para impresión */
            }
            .navbar, .btn-print-hide, footer, .form-control, .btn-primary, .lead, .mb-4 form {
                display: none; /* Ocultar elementos no deseados en la impresión */
            }
            main {
                padding-top: 0;
                padding-bottom: 0;
                margin: 0;
            }
            .container.report-section {
                width: 100%;
                max-width: none;
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                padding: 0;
            }
            .report-section h1 {
                text-align: left !important; /* Alinear título a la izquierda en impresión */
                margin-top: 1rem;
                margin-bottom: 1rem;
                color: #000 !important;
            }
            .card.summary-card {
                border: 1px solid #ddd !important;
                box-shadow: none !important;
                margin-bottom: 1.5rem !important;
            }
            .card-header {
                background-color: #e9ecef !important; /* Fondo gris claro para encabezados de tarjeta */
                color: #000 !important;
                border-bottom: 1px solid #dee2e6 !important;
            }
            .card-body .summary-box {
                background-color: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
                box-shadow: none !important;
            }
            .table-responsive {
                margin-top: 1rem;
                box-shadow: none;
                border-radius: 0;
                border: 1px solid #dee2e6; /* Borde general para la tabla en impresión */
            }
            .table {
                font-size: 0.8rem; /* Fuente más pequeña para la tabla en impresión */
                width: 100%;
            }
            .table thead th {
                background-color: #e9ecef !important;
                color: #000 !important;
                border-bottom: 1px solid #dee2e6 !important;
            }
            .table tbody td {
                border-bottom: 1px solid #eee !important; /* Líneas de tabla más claras */
                color: #000 !important;
            }
            .table tbody tr:nth-of-type(odd) {
                background-color: #f7f7f7 !important; /* Fondo rayado más tenue */
            }
            .table tbody tr:hover {
                background-color: #f7f7f7 !important; /* Eliminar efecto hover en impresión */
            }
            .alert {
                border: 1px solid #ffecb5 !important;
                background-color: #fff3cd !important;
                color: #664d03 !important;
            }
            /* Estilos de impresión para la tabla de detalles */
            .table-details {
                font-size: 0.75rem !important;
            }
            .table-details th, .table-details td {
                border: 1px solid #ccc !important;
            }
            .table-details thead th {
                background-color: #f0f0f0 !important;
                color: #000 !important;
            }
            .table-details tbody td {
                background-color: #fff !important;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescadería Don Walter" width="150" height="48">
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="../Administrador.php" class="btn btn-secondary-custom me-2">
                    <i class="bi bi-person-gear"></i> Volver al Panel de Administrador
                </a>
                <button class="btn btn-print btn-print-hide" onclick="window.print()">
                    <i class="bi bi-printer"></i> Imprimir Reporte
                </button>
            </div>
        </div>
    </nav>

    <main class="container report-section">
        <h1 class="mb-4">Pedidos por Cliente</h1>
        <p class="lead text-muted mb-5">
            Selecciona un cliente de la lista para ver el detalle de sus pedidos.
        </p>

        <form method="GET" action="seleccionar_cliente_pedidos.php" class="mb-5">
            <div class="row g-3 align-items-center justify-content-center">
                <div class="col-auto">
                    <label for="clienteSelect" class="col-form-label fs-5">Elegir Cliente:</label>
                </div>
                <div class="col-md-6 col-lg-5">
                    <select class="form-select form-select-lg" id="clienteSelect" name="cliente_id" required>
                        <option value="">-- Selecciona un Cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo htmlspecialchars($cliente['usuario_id']); ?>"
                                <?php echo ($clienteSeleccionadoId == $cliente['usuario_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['nombre_completo']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-search"></i> Ver Pedidos
                    </button>
                </div>
            </div>
        </form>

        <?php if ($clienteSeleccionadoId && !empty($clienteSeleccionadoNombre)): ?>
            <div class="card summary-card mb-5">
                <div class="card-header">
                    <h5 class="mb-0">Resumen de Pedidos para: <span class="fw-bold"><?php echo $clienteSeleccionadoNombre; ?></span></h5>
                </div>
                <div class="card-body">
                    <div class="row text-center g-3">
                        <div class="col-md-6">
                            <div class="summary-box">
                                <h4 class="text-info"><?php echo count($pedidosCliente); ?></h4>
                                <p class="text-muted mb-0">Pedidos Encontrados</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="summary-box">
                                <h4 class="text-success">$<?php echo number_format($totalGastado, 2); ?></h4>
                                <p class="text-muted mb-0">Total Gastado por el Cliente</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (empty($pedidosCliente)): ?>
                <div class="alert alert-info text-center" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i> No hay pedidos registrados para este cliente.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover border">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No. Pedido</th>
                                <th scope="col">Fecha del Pedido</th>
                                <th scope="col">Total del Pedido</th>
                                <th scope="col">Detalles del Pedido</th> </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidosCliente as $pedido): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($pedido['numero_pedido']); ?></td>
                                    <td><?php echo htmlspecialchars($pedido['fecha_pedido_formateada']); ?></td>
                                    <td>$<?php echo number_format((float)$pedido['total_pedido'], 2); ?></td>
                                    <td>
                                        <?php if (!empty($pedido['detalles'])): ?>
                                            <table class="table-details">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Unit.</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($pedido['detalles'] as $detalle): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($detalle['nombre_producto']); ?></td>
                                                            <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                                                            <td>$<?php echo number_format((float)$detalle['precio_unitario'], 2); ?></td>
                                                            <td>$<?php echo number_format((float)$detalle['subtotal_detalle'], 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <span class="text-muted">Sin detalles de productos.</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        <?php elseif (isset($_GET['cliente_id']) && $clienteSeleccionadoId === null): ?>
            <div class="alert alert-danger text-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> El ID de cliente proporcionado no es válido.
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                <i class="bi bi-lightbulb-fill me-2"></i> Por favor, selecciona un cliente de la lista desplegable para ver sus pedidos.
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer mt-5 py-4">
        <div class="container">
            <p class="mb-0">Contacto: 09924700553 - 0982744920</p>
            <p class="mb-0">Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y - Riobamba</p>
            <div class="footer-icons mt-3">
                <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>