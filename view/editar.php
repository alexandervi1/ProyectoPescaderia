<?php
include("../config/confConexion.php");

if (isset($_GET['id_producto'])) {
    $id_producto = intval($_GET['id_producto']);

    // Consulta para obtener los datos del registro.
    $sql = "SELECT * FROM producto WHERE producto_id = $id_producto";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<p class='text-danger text-center'>Error: No se encontró el registro.</p>";
        exit;
    }
} else {
    echo "<p class='text-danger text-center'>Error: No se proporcionó un ID válido.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<!-- Contenedor principal -->
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
        <h1 class="text-center mb-4">Editar Registro</h1>
        <form action="../Model/MModificar.php" method="post">
            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($id_producto); ?>">

            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" 
                       value="<?php echo isset($row['nombre']) ? htmlspecialchars($row['nombre']) : ''; ?>" required>
            </div>

            <!-- Descuento -->
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento (%):</label>
                <input type="number" id="descuento" name="descuento" class="form-control" 
                       value="<?php echo isset($row['descuento']) ? htmlspecialchars($row['descuento']) : '0'; ?>" min="0" max="100">
            </div>

            <!-- Categoría -->
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" 
                       value="<?php echo isset($row['categoria_id']) ? htmlspecialchars($row['categoria_id']) : ''; ?>" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required>
                    <?php echo isset($row['descripcion']) ? htmlspecialchars($row['descripcion']) : ''; ?>
                </textarea>
            </div>

            <!-- Imagen URL -->
            <div class="mb-3">
                <label for="imagen_url" class="form-label">URL de Imagen:</label>
                <input type="text" id="imagen_url" name="imagen_url" class="form-control" 
                       value="<?php echo isset($row['imagen_url']) ? htmlspecialchars($row['imagen_url']) : ''; ?>">
            </div>

            <!-- Precio -->
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="number" id="precio" name="precio" class="form-control" 
                       value="<?php echo isset($row['precio']) ? htmlspecialchars($row['precio']) : '0'; ?>" step="0.01" required>
            </div>

            <!-- Stock -->
            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" id="stock" name="stock" class="form-control" 
                       value="<?php echo isset($row['stock']) ? htmlspecialchars($row['stock']) : '0'; ?>" min="0" required>
            </div>

            <!-- Botón -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="ListaProductos.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>