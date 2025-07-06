<?php
// Incluir la configuración de conexión a la base de datos
// Asegúrate de que esta ruta sea correcta desde el punto de vista de donde se incluya MListarClientes.php
include("../config/confConexion.php");

// =========================================================================
// LÓGICA PARA OBTENER Y MOSTRAR DATOS DE CLIENTES EN LA TABLA
// =========================================================================

// Consulta a la base de datos para obtener los clientes (rol_id = 2)
$sql = "SELECT
            u.usuario_id,
            u.nombre_usuario,
            u.nombre_completo,
            u.direccion,
            u.correo,
            u.telefono,
            r.nombre AS nombre_rol
        FROM
            usuario AS u
        LEFT JOIN
            rol AS r ON u.rol_id = r.rol_id
        WHERE
            u.rol_id = 2 -- Solo listar usuarios con rol de Cliente
        ORDER BY u.usuario_id ASC";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
    // Verificar si hay filas devueltas antes de iterar
    if (mysqli_num_rows($resultado) > 0) {
        while ($mostrar = mysqli_fetch_array($resultado)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($mostrar['usuario_id']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['nombre_usuario']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['nombre_completo']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['direccion']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['correo']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['telefono']); ?></td>
                <td><?php echo htmlspecialchars($mostrar['nombre_rol']); ?></td>

                <td>
                    <a href="../view/editar_cliente.php?usuario_id=<?php echo htmlspecialchars($mostrar['usuario_id']); ?>"
                       class="btn btn-info btn-sm"
                       title="Editar Cliente">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                </td>
                <td>
                    <a href="../Model/MEliminarCliente_id.php?usuario_id=<?php echo htmlspecialchars($mostrar['usuario_id']); ?>"
                       class="btn btn-danger btn-sm"
                       title="Eliminar Cliente"
                       onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente? Esta acción es irreversible.');">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        // Contamos las columnas: ID, Usuario, Nombre Completo, Dirección, Correo, Teléfono, Rol, Edición, Eliminación = 9 columnas
        echo "<tr><td colspan='9' class='text-center'>No se encontraron clientes.</td></tr>";
    }
} else {
    // En caso de error en la consulta SQL
    echo "<tr><td colspan='9' class='text-center text-danger'>Error al cargar los clientes: " . mysqli_error($conn) . "</td></tr>";
}

// Es buena práctica cerrar la conexión a la base de datos cuando ya no se necesita
mysqli_close($conn);
?>