<?php
// Mostrar errores para depuración durante el desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir la configuración de conexión a la base de datos
include("../config/confConexion.php");

$cliente = null; // Inicializar $cliente a null

if (isset($_GET['usuario_id'])) {
    $usuario_id = intval($_GET['usuario_id']); // Asegúrate de que sea un entero para seguridad

    // Consulta para obtener los datos del cliente
    $sql_cliente = "SELECT
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
                        u.usuario_id = ? AND u.rol_id = 2"; // Asegurarse de que sea un cliente

    $stmt_cliente = $conn->prepare($sql_cliente);
    $stmt_cliente->bind_param("i", $usuario_id);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();

    if ($result_cliente && $result_cliente->num_rows > 0) {
        $cliente = $result_cliente->fetch_assoc();
    } else {
        echo "<p class='text-danger text-center'>Error: No se encontró el cliente con ID " . htmlspecialchars($usuario_id) . " o no tiene rol de cliente.</p>";
        exit;
    }
    $stmt_cliente->close();
} else {
    echo "<p class='text-danger text-center'>Error: No se proporcionó un ID de cliente válido para editar.</p>";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 0;
            margin: 0;
            display: block;
        }
        .main-container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            box-sizing: border-box;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 25px;
            box-sizing: border-box;
            margin: auto;
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
        @media (max-width: 576px) {
            .main-container-center {
                padding: 10px;
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
        <h1 class="text-center">Editar Cliente</h1>
        <form action="../model/MModificarCliente.php" method="post">
            <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($cliente['usuario_id'] ?? ''); ?>">

            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre Completo:</label>
                <input type="text" id="nombre_completo" name="nombre_completo" class="form-control"
                        value="<?php echo htmlspecialchars($cliente['nombre_completo'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control"
                        value="<?php echo htmlspecialchars($cliente['nombre_usuario'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="form-control"
                        value="<?php echo htmlspecialchars($cliente['direccion'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" id="correo" name="correo" class="form-control"
                        value="<?php echo htmlspecialchars($cliente['correo'] ?? ''); ?>" required>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control"
                        value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>">
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="ListarClientes.php" class="btn btn-secondary">Cancelar</a> </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>