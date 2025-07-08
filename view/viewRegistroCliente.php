<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Cliente</title>
  <!-- Fuentes y estilos -->
  <link href="https://fonts.googleapis.com/css?family=Emilys+Candy&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link href="../public/css/Administrador.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Roboto', sans-serif;
    }

    .modal-header img {
      max-width: 200px;
      height: auto;
      margin: auto;
    }

    .modal-content {
      border-radius: 15px;
    }

    label {
      font-weight: bold;
    }

    footer.footer {
      background-color: #343a40;
      color: white;
      padding: 20px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
      text-align: center;
    }
  </style>
</head>
<body>

<!-- Modal de Registro -->
<div class="modal show d-block" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header border-0 flex-column">
        <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo" class="logo mb-2">
        <h4 class="modal-title">Registro de Clientes</h4>
      </div>
      <div class="modal-body">
        <form action="../model/MRegistroCliente.php" method="post">
          <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
          </div>

          <div class="mb-3">
            <label for="nombreCompleto" class="form-label">Nombre Completo:</label>
            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
          </div>

          <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
          </div>

          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="10" pattern="[0-9]{10}" required>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Registrarme</button>
            <a href="../index.html" class="btn btn-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="footer-content">
    <p>Contactos: 0994745362</p>
    <p>Dirección: Argentinos y Nueva York - Riobamba</p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
