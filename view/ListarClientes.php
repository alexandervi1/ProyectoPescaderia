<?php
// Incluir el controlador de Usuario.
// Asumimos que UsuarioController.php ya gestiona session_start() y la autenticación.
require_once __DIR__ . '/../controller/UsuarioController.php';

// Verificar si el usuario está logueado y es administrador (rol_id = 1)
if (!isset($_SESSION['rol_id']) || $_SESSION['rol_id'] !== 1) {
    header("Location: ../index.html"); // Redirige a la página de inicio o login
    exit();
}

// Obtener el nombre del administrador de la sesión
$nombreAdministrador = $_SESSION['nombre_usuario'] ?? 'Administrador';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            flex-wrap: wrap;
        }

        .header-content .logo {
            flex-shrink: 0;
        }

        .header-content .form-control {
            margin: 0 15px;
            flex-grow: 1;
            max-width: 300px;
        }
        
        .header-content .title {
            margin: 0;
            flex-shrink: 0;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }
            .header-content .form-control {
                margin: 10px 0;
                width: 80% !important;
                max-width: unset;
            }
            .header-content .title {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="top-bar">GESTIÓN DE CLIENTES</div>
        <div class="header-content">
            <div class="logo">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Don Walter">
            </div>
            <input type="text" id="buscador" class="form-control" placeholder="Buscar cliente...">
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
            <?php
            // Mensajes de éxito/error después de una operación
            if (isset($_GET['success']) && $_GET['success'] == 'deleted') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente eliminado exitosamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            if (isset($_GET['success']) && $_GET['success'] == 'updated') {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Cliente actualizado exitosamente.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Ocurrió un error: ' . htmlspecialchars($_GET['error']) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            ?>

            <table class="table table-bordered text-center" id="tablaClientes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Nombre Completo</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo que trae los datos de los clientes y los muestra en filas HTML.
                    include("../model/MListarClientes.php");
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <div class="text-center my-3">
        <a href="../Administrador.php" class="btn btn-warning">Regresar al Panel de Admin</a>
    </div>

    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Contacto: 09924700553-0982744920</p>
            <p>Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y - Riobamba</p>
            <div class="footer-icons">
                <a target="_blank" href="https://www.facebook.com/profile.php?id=100066757715498" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                <a target="_blank" href="https://www.tiktok.com/@confiteriamarianita?_t=ZM-8ttYZp03fba&_r=1" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                <a target="_blank" href="https://api.whatsapp.com/send?phone=%2B593999286646&context=ARDuYHFCu7Lh0wtPO6KVw3dnQsxuFUe4sbaDxPoJymtclhx9dNDnWkvdBQvXbt_yUJPryWxZU7tMhTHSeKzwtTxfrm8ZKINThR1d3ISuYtDzHvYnJtkDnGUYnUpNYuECXqHncA9JKgvEMmzPAJdU16dkxA&source=FB_Page&app=facebook&entry_point=page_cta"
                    aria-label="Instagram"><i class="bi bi-whatsapp"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tablaClientes tbody tr');
            rows.forEach(row => {
                row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
</body>
</html>