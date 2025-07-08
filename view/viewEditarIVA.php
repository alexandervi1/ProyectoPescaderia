<?php
require_once __DIR__ . '/../config/confConexion.php';

// Leer el IVA actual
$sql = "SELECT valor FROM Configuracion WHERE clave = 'iva_actual'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$ivaActual = $row ? htmlspecialchars($row['valor']) : '0.00'; // Asegúrate de escapar el valor

// Cierra la conexión a la base de datos después de obtener el valor
// Si confConexion.php mantiene la conexión abierta globalmente y se usa en otros lugares,
// podrías no cerrarla aquí, pero para este script específico, es buena práctica si no se usará más.
// mysqli_close($conn); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar IVA - Pescadería Don Walter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff; /* Alice Blue, un azul muy claro */
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Inter', sans-serif; /* Consistencia de fuente */
        }
        .card-custom {
            background-color: #fefefe; /* Blanco suave para la tarjeta */
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-radius: 18px; /* Bordes más redondeados */
            border: none;
            max-width: 450px; /* Ancho máximo para el formulario */
            width: 90%; /* Responsivo */
            padding: 30px;
            text-align: center;
        }
        .card-custom .logo {
            margin-bottom: 25px;
        }
        .card-custom h2 {
            color: #1A519D; /* Azul oscuro de tu sistema */
            font-weight: bold;
            margin-bottom: 25px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            text-align: left;
            display: block; /* Asegura que la etiqueta ocupe su propia línea */
            margin-bottom: 8px; /* Espacio debajo de la etiqueta */
        }
        .form-control {
            border-radius: 8px; /* Bordes redondeados para inputs */
            border: 1px solid #ced4da;
            padding: 10px 15px;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .form-control:focus {
            border-color: #7CCCED; /* Azul claro al enfocar */
            box-shadow: 0 0 0 0.25rem rgba(124, 204, 237, 0.25); /* Sombra de enfoque */
        }
        .btn-primary {
            background-color: #1A519D; /* Azul oscuro de tu sistema */
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 25px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%; /* Ocupa todo el ancho */
            margin-top: 20px;
        }
        .btn-primary:hover {
            background-color: #154382; /* Tono más oscuro al hacer hover */
            transform: translateY(-2px); /* Pequeño efecto de elevación */
        }
        .btn-secondary {
            background-color: #6c757d; /* Gris de Bootstrap secondary */
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 25px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%; /* Ocupa todo el ancho */
            margin-top: 10px;
        }
        .btn-secondary:hover {
            background-color: #5a6268; /* Tono más oscuro al hacer hover */
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="card-custom">
        <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" class="logo img-fluid" width="200">
        <h2>Modificar IVA</h2>
        <form action="../model/MActualizarIVA.php" method="POST">
            <div class="mb-3">
                <label for="ivaActual" class="form-label">IVA Actual:</label>
                <input type="text" class="form-control text-center" id="ivaActual" value="<?= $ivaActual ?>%" readonly>
            </div>
            <div class="mb-3">
                <label for="nuevoIVA" class="form-label">Nuevo IVA (%):</label>
                <input type="number" name="nuevoIVA" class="form-control" id="nuevoIVA" step="0.01" min="0" max="100" required>
            </div>
            <button type="submit" class="btn btn-primary">Confirmar</button>
            <a href="../view/ListaProductos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
