<?php
require_once __DIR__ . '/../config/confConexion.php';
 
// Leer el IVA actual
$sql = "SELECT valor FROM Configuracion WHERE clave = 'iva_actual'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$ivaActual = $row ? $row['valor'] : '0.00';
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar IVA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Modificar IVA</h2>
    <form action="../model/MActualizarIVA.php" method="POST">
        <div class="mb-3">
            <label for="ivaActual" class="form-label">IVA Actual:</label>
            <input type="text" class="form-control" id="ivaActual" value="<?= htmlspecialchars($ivaActual) ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="nuevoIVA" class="form-label">Nuevo IVA (%):</label>
            <input type="number" name="nuevoIVA" class="form-control" id="nuevoIVA" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Confirmar</button>
        <a href="../view/ListaProductos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>