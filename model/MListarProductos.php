<?php
include("../config/confConexion.php");

// Consulta a la base de datos
$sql = "SELECT * FROM producto";
$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    while ($mostrar = mysqli_fetch_array($resultado)) {
        //cada fila devuelta se almacena en el array $mostrar
        // Encriptar el ID al momento de generar el enlace
        ?>
        <tr> <!-- tr es una fila , td son celdas -->
             <!-- Mostrar ID encriptado -->
             <td><?php echo $mostrar['producto_id']; ?></td>
            <td><?php echo $mostrar['nombre']; ?></td>
            <td><?php echo $mostrar['descuento']; ?></td>
            <td><?php echo $mostrar['categoria_id']; ?></td>
            <td><?php echo $mostrar['descripcion']; ?></td>
            <td><?php echo $mostrar['imagen_url']; ?></td>
            <td><?php echo $mostrar['precio']; ?></td>
            <td><?php echo $mostrar['stock']; ?></td>

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
    echo "<tr><td colspan='6'>No se encontraron registros.</td></tr>";
}
?>