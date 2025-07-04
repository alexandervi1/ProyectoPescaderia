<?php
require_once __DIR__ . '/../controller/UsuarioController.php';
include("../model/mRegistroVentas.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ventas</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    
    <header class="header">
        <div class="top-bar">REGISTRO DE VENTAS</div>
        <div class="header-content">
            <div class="logo">
                <img src="../img/lg5.png" alt="Logo Marianita">
            </div>
            <input type="text" id="buscador" class="form-control w-25 d-block" placeholder="Buscar pedido...">
            <h1 class="title">Administrador: <?php echo htmlspecialchars($nombreAdministrador); ?></h1>
          
        </div>
    </header>

    <div class="linea-debajo-header"></div>
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
    <main class="body-central">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentPedidoId = null;
                            foreach ($ventas as $venta) {
                                if ($currentPedidoId !== $venta['pedido_id']) {
                                    if ($currentPedidoId !== null) {
                                        echo '</ul></td></tr>';
                                    }
                                    $currentPedidoId = $venta['pedido_id'];
                                    echo '<tr>';
                                    echo '<td>' . $venta['pedido_id'] . '</td>';
                                    echo '<td>' . $venta['fecha_pedido'] . '</td>';
                                    echo '<td>' . $venta['nombre_completo'] . '</td>';
                                    echo '<td>' . $venta['total'] . '</td>';
                                    echo '<td><ul>';
                                }
                                echo '<li>' . $venta['producto_nombre'] . ' (Cantidad: ' . $venta['cantidad'] . ', Precio Unitario: ' . $venta['precio_unitario'] . ')</li>';
                            }
                            if ($currentPedidoId !== null) {
                                echo '</ul></td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="text-center my-3">
        <a href="../Administrador.php" class="btn btn-danger">Regresar</a>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>Contactos: 0994745362</p>
            <p>Dirección: Argentinos y Nueva York - Riobamba</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
</body>
</html>