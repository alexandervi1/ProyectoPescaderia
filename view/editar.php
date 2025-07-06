<?php
// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

// =========================================================================
// LÓGICA PARA OBTENER DATOS DEL PRODUCTO Y LISTAS DESPLEGABLES
// =========================================================================

$row = null; // Inicializar $row a null

if (isset($_GET['producto_id'])) {
    $producto_id = intval($_GET['producto_id']); // Asegúrate de que sea un entero

    // Consulta para obtener los datos del producto (sin descuento)
    // Se ha eliminado 'p.imagen_url' de la selección
    $sql_producto = "SELECT
                            p.producto_id,
                            p.nombre,
                            p.categoria_id,
                            p.descripcion,
                            p.precio,
                            p.stock,
                            p.unidad_compra_id,
                            p.unidad_venta_id
                        FROM
                            producto AS p
                        WHERE
                            p.producto_id = $producto_id";

    $result_producto = mysqli_query($conn, $sql_producto);

    if ($result_producto && mysqli_num_rows($result_producto) > 0) {
        $row = mysqli_fetch_assoc($result_producto);
    } else {
        // Redirigir o mostrar un error más amigable si el producto no existe
        echo "<p class='text-danger text-center'>Error: No se encontró el registro del producto.</p>";
        // Considera redirigir a una página de error o a la lista de productos
        // header("Location: ListaProductos.php?error=producto_no_encontrado");
        exit;
    }
} else {
    // Redirigir o mostrar un error más amigable si no se proporciona un ID
    echo "<p class='text-danger text-center'>Error: No se proporcionó un ID de producto válido.</p>";
    // header("Location: ListaProductos.php?error=id_no_valido");
    exit;
}

// Consulta para obtener todas las unidades de medida
$sql_unidades = "SELECT unidad_id, nombre FROM unidad_medida ORDER BY nombre ASC";
$result_unidades = mysqli_query($conn, $sql_unidades);
$unidades = [];
if ($result_unidades) {
    while ($um = mysqli_fetch_assoc($result_unidades)) {
        $unidades[] = $um;
    }
}

// Es buena práctica cerrar la conexión a la base de datos cuando ya no se necesita
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Un color de fondo Bootstrap light más suave */
            min-height: 100vh; /* Asegura que ocupe al menos toda la altura de la ventana */
            padding: 0; /* Quitamos padding del body para que el contenedor lo maneje */
            margin: 0; /* Asegura que no haya márgenes predeterminados en el body */
            display: block; /* Asegura que el body se comporte como un bloque */
        }
        
        /* Nuevo estilo para el contenedor principal para centrarlo */
        .main-container-center {
            display: flex;
            justify-content: center; /* Centrado horizontal del contenido */
            align-items: center; /* Centrado vertical del contenido */
            min-height: 100vh; /* Ocupa al menos toda la altura de la ventana del navegador */
            padding: 20px; /* Padding alrededor del contenido para que no se pegue a los bordes */
            box-sizing: border-box; /* Incluir padding en el tamaño total */
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Ancho máximo para el formulario */
            padding: 25px; /* Padding interno de la tarjeta */
            box-sizing: border-box;
            margin: auto; /* Esto también ayuda a centrar horizontalmente si el padre tiene un ancho definido */
        }
        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 0.95rem;
        }
        .form-control, .form-select {
            font-size: 0.9rem;
            padding: 0.375rem 0.75rem;
            height: auto;
        }
        .mb-3 {
            margin-bottom: 0.8rem !important;
        }
        h1 {
            font-size: 1.8rem;
            margin-bottom: 1.5rem !important;
            color: #1A519D;
        }
        .btn-primary {
            background-color: #1A519D;
            border-color: #1A519D;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }
        .btn-primary:hover {
            background-color: #164282;
            border-color: #164282;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        /* Media Queries para ajustes específicos en pantallas más pequeñas */
        @media (max-width: 576px) {
            .main-container-center {
                padding: 10px; /* Reducir padding en móviles */
            }
            .card {
                padding: 15px;
            }
            h1 {
                font-size: 1.5rem;
                margin-bottom: 1rem !important;
            }
            .form-control, .form-select {
                font-size: 0.85rem;
                padding: 0.3rem 0.6rem;
            }
            .btn-primary, .btn-secondary {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="main-container-center">
    <div class="card">
        <h1 class="text-center">Editar Producto</h1>
        <form action="../Model/MModificar.php" method="post">
            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto_id); ?>">

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                        value="<?php echo htmlspecialchars($row['nombre'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoría (ID):</label>
                <input type="number" id="categoria_id" name="categoria_id" class="form-control"
                        value="<?php echo htmlspecialchars($row['categoria_id'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="2" required><?php echo htmlspecialchars($row['descripcion'] ?? ''); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control"
                        value="<?php echo htmlspecialchars($row['precio'] ?? '0'); ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control"
                        value="<?php echo htmlspecialchars($row['stock'] ?? '0'); ?>" min="0" required>
            </div>

            <div class="mb-3">
                <label for="unidad_compra_id" class="form-label">Unidad de Compra:</label>
                <select id="unidad_compra_id" name="unidad_compra_id" class="form-select" required>
                    <option value="">Seleccione una unidad</option>
                    <?php foreach ($unidades as $um): ?>
                        <option value="<?php echo htmlspecialchars($um['unidad_id']); ?>"
                            <?php echo (isset($row['unidad_compra_id']) && $row['unidad_compra_id'] == $um['unidad_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($um['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="unidad_venta_id" class="form-label">Unidad de Venta:</label>
                <select id="unidad_venta_id" name="unidad_venta_id" class="form-select" required>
                    <option value="">Seleccione una unidad</option>
                    <?php foreach ($unidades as $um): ?>
                        <option value="<?php echo htmlspecialchars($um['unidad_id']); ?>"
                            <?php echo (isset($row['unidad_venta_id']) && $row['unidad_venta_id'] == $um['unidad_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($um['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="ListaProductos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>