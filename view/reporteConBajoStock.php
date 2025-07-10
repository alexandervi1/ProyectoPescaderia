<?php
// ====================================================================
// 1. CONFIGURACIÓN DE LA BASE DE DATOS Y CONEXIÓN
// ====================================================================
$dbConfig = [
    'host' => 'localhost',
    'database' => 'pescaderia',
    'username' => 'root', // ¡IMPORTANTE: CAMBIA ESTO por tu usuario de MySQL!
    'password' => ''      // ¡IMPORTANTE: CAMBIA ESTO por tu contraseña de MySQL!
];

$pdo = null; // Inicializar la variable PDO
try {
    $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error de conexión a la base de datos: " . $e->getMessage());
    die("Lo sentimos, no pudimos conectar con la base de datos en este momento. Por favor, inténtelo más tarde.");
}

// ====================================================================
// 2. CONFIGURACIÓN DEL UMBRAL DE BAJO STOCK
// Puedes ajustar este valor según tus necesidades
// ====================================================================
$umbralBajoStock = 10; // Ejemplo: considerar bajo stock si es menor o igual a 10 unidades/kg/ton

// ====================================================================
// 3. FUNCIÓN PARA OBTENER DATOS DEL REPORTE DE BAJO STOCK
// ====================================================================
function getReporteBajoStock($pdo, $umbral) {
    $sql = "
        SELECT
            p.nombre AS producto,
            p.stock AS stockActual,
            um.abreviatura AS unidadCompra,
            c.nombre AS categoria
        FROM
            producto p
        JOIN
            categoria c ON p.categoria_id = c.categoria_id
        JOIN
            unidad_medida um ON p.unidad_compra_id = um.unidad_id
        WHERE
            p.stock <= :umbral
        ORDER BY
            p.stock ASC, p.nombre ASC;
    ";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':umbral', $umbral, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Error al ejecutar la consulta de reporte de bajo stock: " . $e->getMessage());
        die("Lo sentimos, ocurrió un error al obtener los datos del reporte. Por favor, inténtelo más tarde.");
    }
}

$bajoStockData = getReporteBajoStock($pdo, $umbralBajoStock);

// ====================================================================
// 4. CÁLCULO DE RESÚMENES
// ====================================================================
$totalProductosBajoStock = count($bajoStockData);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos con Bajo Stock - Pescadería Don Walter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
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
            box-shadow: none;
        }

        .navbar-brand img {
            background-color: var(--container-bg); /* Blanco */
            padding: 5px;
            border-radius: 5px;
        }

        .navbar .btn {
            color: var(--text-light); /* Texto blanco */
            border: 1px solid var(--text-light); /* Borde blanco */
        }

        /* Botón "Volver a la Tienda" y "Imprimir Reporte" */
        .navbar .btn-warning,
        .navbar .btn-primary {
            background-color: var(--primary-blue); /* Mismo azul oscuro para coherencia */
            border-color: var(--text-light); /* Borde blanco */
        }

        .navbar .btn-warning:hover,
        .navbar .btn-primary:hover {
            background-color: var(--light-blue); /* Azul claro al pasar el mouse */
            border-color: var(--light-blue);
        }

        /* ====================================================================
           Contenedor Principal del Reporte
           ==================================================================== */
        .container.report-section { /* Más específico para evitar conflictos */
            background-color: var(--container-bg); /* Contenedor blanco */
            padding: 2rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            color: var(--text-dark); /* Asegurar color de texto oscuro por defecto */
        }

        /* Títulos y Encabezados */
        .report-section h1 {
            color: var(--primary-blue); /* Título principal azul oscuro */
            margin-bottom: 1.5rem;
            text-align: left;
            font-weight: bold;
        }

        .report-section .lead {
            color: #555; /* Un gris oscuro para mejor legibilidad */
            margin-bottom: 2.5rem; /* Aumenta el margen inferior para separar del resumen */
        }

        /* ====================================================================
           Estilo de la tarjeta de resumen
           ==================================================================== */
        .card.shadow-sm.mb-5 {
            border: none; /* Eliminar el borde predeterminado de la tarjeta si no es deseado */
        }

        .card-header {
            background-color: var(--primary-blue); /* Azul oscuro */
            color: var(--text-light); /* Texto blanco */
            border-bottom: 1px solid var(--dark-blue); /* Tono más oscuro de azul */
            font-weight: bold;
        }

        .card-body .p-3.border.rounded {
            background-color: var(--container-bg); /* Fondo blanco para las cajas de resumen */
            border-color: var(--border-light); /* Borde estándar de Bootstrap */
            box-shadow: 0 0.05rem 0.15rem rgba(0, 0, 0, 0.05); /* Sombra muy sutil */
            color: var(--text-dark); /* Asegurar color de texto para las cajas de resumen */
        }

        /* Asegurando la visibilidad de los números de resumen con colores de Bootstrap */
        .card-body h4.text-danger { color: var(--bs-danger); } /* Rojo para bajo stock */
        .card-body p.text-muted {
            color: var(--text-muted); /* Gris de Bootstrap, legible en fondo blanco */
            font-weight: normal;
        }

        /* ====================================================================
           Tabla de Reporte
           ==================================================================== */
        .table-responsive {
            margin-top: 1.5rem;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .table thead th {
            background-color: var(--primary-blue); /* Azul oscuro para los encabezados */
            color: var(--text-light); /* Texto blanco en encabezados */
            border-bottom: 2px solid var(--dark-blue); /* Borde más oscuro */
            padding: 0.75rem;
            text-align: left;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
            color: var(--text-dark); /* Asegurar que el texto del cuerpo de la tabla sea oscuro */
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: var(--table-stripe); /* Azul muy tenue para filas impares */
        }

        .table tbody tr:hover {
            background-color: var(--table-hover); /* Un poco más oscuro al pasar el ratón */
        }
        
        /* Estilo para filas de stock crítico */
        .table tbody tr.table-danger {
            background-color: rgba(220, 53, 69, 0.1) !important; /* Rojo tenue para filas de bajo stock */
            font-weight: bold;
        }

        /* ====================================================================
           Footer
           ==================================================================== */
        footer {
            background-color: var(--primary-blue); /* Azul oscuro */
            color: var(--text-light); /* Texto blanco para todo el footer */
            text-align: center;
            padding: 15px 0;
            border-top: none;
        }

        footer p {
            color: var(--text-light); /* Forzar blanco para los párrafos de contacto/dirección */
            margin-bottom: 5px;
        }

        .footer-icons a {
            color: var(--text-light); /* Iconos blancos */
            margin: 0 10px;
            font-size: 24px;
            text-decoration: none;
        }

        .footer-icons a:hover {
            color: var(--light-blue); /* Azul claro al pasar el mouse */
        }

        /* ====================================================================
           Estilos de impresión
           ==================================================================== */
        @media print {
            .navbar, .btn-print-hide, footer {
                display: none; /* No usar !important aquí a menos que sea absolutamente necesario */
            }
            main {
                padding-top: 0;
                padding-bottom: 0;
            }
            .container {
                width: 100%;
                max-width: none;
                box-shadow: none;
                border-radius: 0;
                margin: 0;
                padding: 0;
            }
            .table {
                font-size: 0.75rem;
                border: 1px solid var(--border-light);
            }
            .card.shadow-sm.mb-5 {
                border: 1px solid var(--border-light);
                box-shadow: none;
            }
            .card-header {
                border-bottom: 1px solid var(--border-light);
            }
            /* Asegurar que el texto sea negro en la impresión para mejor contraste */
            body, p, h1, h4, td, th {
                color: black;
            }
            .table thead th {
                background-color: #e9ecef; /* Fondo gris claro para encabezados de tabla en impresión */
                color: black;
            }
            .table tbody tr.table-danger {
                background-color: #f8d7da !important; /* Un rojo claro para impresión */
                color: black;
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
            <div class="ms-auto">
                <a href="../Administrador.php" class="btn btn-warning">
                    <i class="bi bi-person-gear"></i> Volver al Panel de Administrador
                </a>
                <button class="btn btn-primary ms-2 btn-print-hide" onclick="window.print()">
                    <i class="bi bi-printer"></i> Imprimir Reporte
                </button>
            </div>
        </div>
    </nav>

    <main class="container report-section">
        <h1 class="mb-4">Productos con Bajo Stock</h1>
        <p class="lead text-muted mb-5">
            Lista de productos cuyo stock actual está por debajo del umbral de **<?php echo $umbralBajoStock; ?>** unidades/kilogramos/toneladas.
        </p>

        <div class="card shadow-sm mb-5">
            <div class="card-header">
                <h5 class="mb-0">Resumen de Bajo Stock</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="p-3 border rounded">
                            <h4 class="text-danger"><?php echo $totalProductosBajoStock; ?></h4>
                            <p class="text-muted mb-0">Productos Requieren Reabastecimiento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover border">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Stock Actual</th>
                        <th scope="col">Unidad de Compra</th>
                        <th scope="col">Categoría</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (empty($bajoStockData)) {
                        echo '<tr><td colspan="4" class="text-center text-muted py-4">¡Excelente! No hay productos con stock por debajo del umbral.</td></tr>';
                    } else {
                        foreach ($bajoStockData as $item) {
                            // Aplicar la clase table-danger si el stock es 0 o muy bajo
                            $rowClass = ((float)$item['stockActual'] <= 0) ? 'table-danger' : '';
                            echo '<tr class="' . $rowClass . '">';
                            echo '<td>' . htmlspecialchars($item['producto']) . '</td>';
                            echo '<td>' . number_format((float)$item['stockActual'], 2) . '</td>';
                            
                            // Lógica para mostrar el alias de la unidad de compra
                            $displayUnit = htmlspecialchars($item['unidadCompra']);
                            if (strtolower($displayUnit) === 'tn') {
                                $displayUnit = 'toneladas';
                            } elseif (strtolower($displayUnit) === 'u') {
                                $displayUnit = 'unidades';
                            }
                            echo '<td>' . $displayUnit . '</td>'; 
                            echo '<td>' . htmlspecialchars($item['categoria']) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="footer mt-5 py-4">
        <div class="container">
            <p class="mb-0">Contacto: 09924700553 - 0982744920</p>
            <p class="mb-0">Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y - Riobamba</p>
            <div class="footer-icons">
                <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>