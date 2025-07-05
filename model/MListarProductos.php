<?php
include("../config/confConexion.php");

// Consulta a la base de datos, uniendo con la tabla unidad_medida para obtener los nombres de las unidades
$sql = "SELECT
            p.producto_id,
            p.nombre,
            p.descripcion,
            p.precio,
            p.stock,
            p.imagen_url,
            p.categoria_id,
            uc.nombre AS unidad_compra_nombre,
            uv.nombre AS unidad_venta_nombre
        FROM
            producto AS p
        LEFT JOIN
            unidad_medida AS uc ON p.unidad_compra_id = uc.unidad_id
        LEFT JOIN
            unidad_medida AS uv ON p.unidad_venta_id = uv.unidad_id";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    while ($mostrar = mysqli_fetch_array($resultado)) {
        //cada fila devuelta se almacena en el array $mostrar
        ?>
        <tr> <!-- tr es una fila , td son celdas -->
            <td><?php echo $mostrar['producto_id']; ?></td>
            <td><?php echo $mostrar['nombre']; ?></td>
            <td><?php echo $mostrar['categoria_id']; ?></td>
            <td><?php echo $mostrar['descripcion']; ?></td>
            <td><?php echo $mostrar['imagen_url']; ?></td>
            <td><?php echo $mostrar['precio']; ?></td>
            <td><?php echo $mostrar['stock']; ?></td>
            <td><?php echo $mostrar['unidad_compra_nombre']; ?></td> <!-- Mostrar nombre de la unidad de compra -->
            <td><?php echo $mostrar['unidad_venta_nombre']; ?></td>  <!-- Mostrar nombre de la unidad de venta -->

            <!-- Enlace para eliminar usando Clave sin encriptar -->
            <td>
                <a href="../Model/MEliminarProducto_id.php?producto_id=<?php echo $mostrar['producto_id']; ?>" title="Eliminar">
                    <i class="bi bi-trash" style="color: red;"></i> <br>
                    Eliminar
                </a>
            </td>
            <!-- Enlace para editar usando Clave sin encriptar -->
            <td>
            <a href="../Model/MSearchProducto_id.php?producto_id=<?php echo $mostrar['producto_id']; ?>" title="Editar">
                    <i class="bi bi-pencil-fill" style="color: red;"></i> <br>
                    Editar
                </a>
            </td>
        </tr>
        <?php
    }
} else {
    // Si no se encontraron registros, se muestra un mensaje en una fila con 9 columnas (para coincidir con las columnas de datos)
    echo "<tr><td colspan='9'>No se encontraron registros.</td></tr>";
}
?>
