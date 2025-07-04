<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Incluyendo Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Incluyendo FontAwesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<?php
include("../config/confConexion.php");
$baseDatos = new Database();
$conn = $baseDatos->getConnection();
$sql = "SELECT * FROM datos_estu";
$resultado = mysqli_query($conn, $sql);
while ($mostrar = mysqli_fetch_array($resultado)) {
?>
    <tr>
        <td><?php echo $mostrar['id'] ?></td>
        <td><?php echo $mostrar['nombre'] ?></td>
        <td><?php echo $mostrar['apellido'] ?></td>
        <td><?php echo $mostrar['clave'] ?></td>
        <td>
            <a href="#" onclick="confirmDelete(<?php echo $mostrar['id'] ?>)" class="btn btn-danger">
                <i class="fas fa-trash-alt"></i>
            </a>
        </td>
        <td>
            <a href="#" onclick="openEditModal(<?php echo $mostrar['id']?>, &quot;<?php echo $mostrar['nombre'] ?>&quot;, &quot;<?php echo $mostrar['apellido']?>&quot;, &quot;<?php echo $mostrar['clave']?>&quot;)" class="btn btn-warning">
                <i class="fas fa-edit"></i>
            </a>
        </td>
    </tr>
<?php
}
?>

<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Estudiante</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" action="../model/modEditar.php" method="post">
                    <div align="left">
                    <label for="">ID:</label>
                    <input type="text" name="id" id="editId" readonly>
                    </div>
                    <div class="form-group">
                        <label for="editNombre">Nombre:</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editApellido">Apellido:</label>
                        <input type="text" class="form-control" id="editApellido" name="apellido" required>
                    </div>
                    <div class="form-group">
                        <label for="editClave">Clave:</label>
                        <input type="text" class="form-control" id="editClave" name="clave" required>
                    </div>
                    <br><br>
                    <button type="button" onclick="confirmEdit()" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let deleteId = null;

    function confirmDelete(id) {
        if (confirm("¿Está seguro de eliminar el registro del estudiante " + id + "?")) {
            window.location.href = `../model/modEliminar.php?id=${id}`;
        }
    }

    function openEditModal(id, nombre, apellido, clave) {
        document.getElementById('editId').value = id;
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editApellido').value = apellido;
        document.getElementById('editClave').value = clave;
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    }

    function confirmEdit() {
        if (confirm("¿Está seguro de que desea guardar los cambios?")) {
            document.getElementById('editForm').submit();
        }
    }
</script>

<!-- Incluyendo jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>