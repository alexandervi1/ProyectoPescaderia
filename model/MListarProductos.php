<?php
// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

// =========================================================================
// LÓGICA PARA OBTENER Y MOSTRAR DATOS DE PRODUCTOS EN LA TABLA
// =========================================================================

// Consulta a la base de datos, uniendo con la tabla unidad_medida para obtener los nombres de las unidades
// 'p.imagen_url' sigue excluida de la selección, ya que no la quieres en la interfaz de edición.
$sql = "SELECT
            p.producto_id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.categoria_id,
            uc.nombre AS unidad_compra_nombre,
            uv.nombre AS unidad_venta_nombre
        FROM
            producto AS p
        LEFT JOIN
            unidad_medida AS uc ON p.unidad_compra_id = uc.unidad_id
        LEFT JOIN
            unidad_medida AS uv ON p.unidad_venta_id = uv.unidad_id
        ORDER BY p.producto_id ASC"; // Es buena práctica ordenar los resultados

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    // Verificar si hay filas devueltas antes de iterar
    if (mysqli_num_rows($resultado) > 0) {
        while ($mostrar = mysqli_fetch_array($resultado)) {
            ?>
            <tr> <td><?php echo htmlspecialchars($mostrar['producto_id']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['nombre']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['categoria_id']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['precio']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['stock']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['unidad_compra_nombre']); ?></td> <td><?php echo htmlspecialchars($mostrar['unidad_venta_nombre']); ?></td>  <td>
                    <a href="../Model/MEliminarProducto_id.php?producto_id=<?php echo htmlspecialchars($mostrar['producto_id']); ?>"
                       class="btn btn-danger btn-sm"
                       title="Eliminar"
                       onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </td>
                <td>
                    <a href="../Model/MSearchProducto_id.php?producto_id=<?php echo htmlspecialchars($mostrar['producto_id']); ?>"
                       class="btn btn-info btn-sm"
                       title="Editar">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        // Si no se encontraron registros, se muestra un mensaje en una fila
        // Columnas: ID, Nombre, Categoría, Descripción, Precio, Stock,
        // Unidad Compra, Unidad Venta, Edición, Eliminación = 10 columnas
        echo "<tr><td colspan='10' class='text-center'>No se encontraron productos.</td></tr>";
    }
} else {
    // En caso de error en la consulta SQL
    echo "<tr><td colspan='10' class='text-center text-danger'>Error al cargar los productos: " . mysqli_error($conn) . "</td></tr>";
}

// Es buena práctica cerrar la conexión a la base de datos cuando ya no se necesita
mysqli_close($conn);
?>