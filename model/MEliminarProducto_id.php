<?php
// Incluye el archivo de conexión a la base de datos
include("../config/confConexion.php");

// Obtiene el ID del producto de la URL
$idProducto = $_GET['producto_id'] ?? null; // Usa el operador null coalescing para evitar errores si no se pasa el ID

// Verifica si el ID del producto no está vacío
if (!empty($idProducto)) {
    // Escapa el ID del producto para prevenir inyecciones SQL (aunque es mejor usar sentencias preparadas)
    // Nota: Para una seguridad óptima, se recomienda encarecidamente usar sentencias preparadas (mysqli_prepare, mysqli_stmt_bind_param, mysqli_stmt_execute)
    $idProducto = mysqli_real_escape_string($conn, $idProducto);

    // Consulta SQL para eliminar el producto
    $deleteSql = "DELETE FROM producto WHERE producto_id = '$idProducto'";
    
    // Ejecuta la consulta de eliminación
    if (mysqli_query($conn, $deleteSql)) {
        // Muestra el mensaje de confirmación con los estilos actualizados
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Producto eliminado</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    /* Fondo que complementa el azul del sistema */
                    background-color: #f0f8ff; /* Alice Blue, un azul muy claro */
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                .card {
                    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                    border-radius: 18px;
                    border: none;
                    max-width: 400px;
                    background-color: #fefefe; /* Blanco suave para la tarjeta */
                }
                .btn-primary {
                    /* Color principal de tu sistema */
                    background-color: #1A519D; 
                    border: none;
                    border-radius: 8px;
                    font-weight: 600;
                    transition: background-color 0.3s ease;
                }
                .btn-primary:hover {
                    /* Color de hover de tu sistema */
                    background-color: #154382; /* Un tono más oscuro de tu azul principal */
                }
                .text-success {
                    /* Un verde estándar para mensajes de éxito */
                    color: #28a745 !important; 
                }
            </style>
        </head>
        <body class="d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="card p-4 text-center">
                <h4 class="mb-3 text-success">Registro eliminado correctamente.</h4>
                <a href="../view/ListaProductos.php" class="btn btn-primary px-4 py-2">Aceptar</a>
            </div>
        </body>
        </html>';
    } else {
        // Muestra un mensaje de error si la eliminación falla
        echo '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Error al eliminar</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f0f8ff;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                .card {
                    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                    border-radius: 18px;
                    border: none;
                    max-width: 400px;
                    background-color: #fefefe;
                }
                .btn-danger {
                    background-color: #dc3545; /* Rojo estándar para errores */
                    border: none;
                    border-radius: 8px;
                    font-weight: 600;
                    transition: background-color 0.3s ease;
                }
                .btn-danger:hover {
                    background-color: #c82333;
                }
                .text-danger {
                    color: #dc3545 !important;
                }
            </style>
        </head>
        <body class="d-flex flex-column justify-content-center align-items-center vh-100">
            <div class="card p-4 text-center">
                <h4 class="mb-3 text-danger">Error al eliminar el registro.</h4>
                <p class="text-muted">' . htmlspecialchars(mysqli_error($conn)) . '</p>
                <a href="../view/ListaProductos.php" class="btn btn-danger px-4 py-2">Volver</a>
            </div>
        </body>
        </html>';
    }
} else {
    // Muestra un mensaje si el ID del producto no es válido
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ID de Producto Inválido</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f0f8ff;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .card {
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
                border-radius: 18px;
                border: none;
                max-width: 400px;
                background-color: #fefefe;
            }
            .btn-secondary {
                background-color: #6c757d;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                transition: background-color 0.3s ease;
            }
            .btn-secondary:hover {
                background-color: #5a6268;
            }
            .text-warning {
                color: #ffc107 !important;
            }
        </style>
    </head>
    <body class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="card p-4 text-center">
            <h4 class="mb-3 text-warning">Identificador de producto no válido.</h4>
            <a href="../view/ListaProductos.php" class="btn btn-secondary px-4 py-2">Volver</a>
        </div>
    </body>
    </html>';
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
