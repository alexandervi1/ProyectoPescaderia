<?php
require_once '../config/confConexion.php';
require_once '../model/mObtDatosProducto.php';

// Obtener el ID del producto desde la URL
if (!isset($_GET['id'])) {
    die('Error: ID de producto no especificado.');
}
$producto_id = $_GET['id'];

// Obtener los datos del producto desde la base de datos
$producto = obtenerDatosProducto($producto_id);
if (!$producto) {
    die('Error: Producto no encontrado.');
}
?>
<!DOCTYPE html>
<html lang="es">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descripción del producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/producto.css">
    <style>
    /* --- Estilos para el Modal de "Producto Agregado" al Carrito --- */
/* (Este es el modal con ID #modal-agregado-carrito) */
.modal {
    position: fixed;
    z-index: 1050; /* Alto para estar por encima de otros elementos */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6); /* Fondo oscurecido para destacar el modal */
    display: flex; /* Usar flexbox para centrar contenido */
    justify-content: center;
    align-items: center;

    opacity: 0; /* Inicialmente invisible */
    visibility: hidden; /* Oculto para no recibir eventos */
    transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out; /* Transición para ambos */
    pointer-events: none; /* No interactuable por defecto hasta que se muestre */
}

.modal.show {
    opacity: 1; /* Visible cuando tiene la clase 'show' */
    visibility: visible; /* Interacciones habilitadas */
    pointer-events: all; /* Puede recibir eventos del ratón/toque */
}

.modal-content {
    background-color: #ffffff; /* Fondo blanco para el contenido del modal */
    padding: 30px; /* Más padding para una mejor presentación */
    border: none; /* Quitamos el borde, la sombra es suficiente */
    width: 380px; /* Ancho específico para este modal */
    max-width: 90%; /* Ajuste para pantallas pequeñas */
    text-align: center;
    box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.25); /* Sombra más prominente */
    border-radius: 15px; /* Bordes más redondeados como en tus otros estilos */
    position: relative; /* Para posicionar el botón de cerrar */
    transform: translateY(-30px); /* Pequeño efecto de entrada */
    transition: transform 0.3s ease-out; /* Transición para el movimiento */
}

.modal.show .modal-content {
    transform: translateY(0); /* Vuelve a la posición original */
}

.close-button {
    position: absolute;
    top: 15px;
    right: 20px;
    background: none;
    border: none;
    font-size: 30px; /* Botón de cerrar más grande y visible */
    font-weight: bold;
    color: #6c757d; /* Un gris neutro */
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}

.close-button:hover,
.close-button:focus {
    color: #333;
}

.modal-title {
    color: #28a745; /* Verde para el mensaje de éxito (Bootstrap success) */
    margin-bottom: 25px;
    font-size: 2.2rem; /* Tamaño de fuente para el título */
    display: flex; /* Para alinear el ícono y el texto */
    align-items: center;
    justify-content: center;
}
.modal-title i {
    margin-right: 10px; /* Espacio entre el ícono y el texto */
    font-size: 2.5rem; /* Tamaño del ícono de check */
}

.modal-body-text {
    margin-bottom: 30px;
    font-size: 1.1rem;
    color: #333; /* Color de texto oscuro para legibilidad */
}

.modal-buttons-group {
    display: flex;
    flex-direction: column; /* Apilados en móviles */
    gap: 15px; /* Espacio entre botones */
}

@media (min-width: 576px) { /* En pantallas más grandes, los botones se ponen en línea */
    .modal-buttons-group {
        flex-direction: row;
        justify-content: center;
    }
}

.modal-button {
    padding: 15px 25px; /* Más padding para botones */
    border: none;
    border-radius: 8px; /* Bordes redondeados para los botones */
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
    flex-grow: 1; /* Para que los botones ocupen espacio equitativamente */
}

.primary-button {
    background-color: #1A519D; /* Tu azul oscuro principal */
    color: white;
}
.primary-button:hover {
    background-color: #154382; /* Tono más oscuro al pasar el mouse */
    transform: translateY(-2px);
}
.secondary-button {
    background-color: #7CCCED; /* Tu azul más claro/secundario */
    color: #1A519D; /* Texto en azul oscuro para contraste */
    border: 1px solid #7CCCED; /* Borde del mismo color */
}
.secondary-button:hover {
    background-color: #5eb9d9; /* Tono más oscuro al pasar el mouse */
    transform: translateY(-2px);
    color: white; /* Texto blanco al hacer hover para este botón */
}
</style
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Pescaderia Don Walter" width="200" height="64">
            </a>
          
            <div id="guest-options">
                <a href="../controller/usercontrolador.php?accion=quienes_somos" id="btn-quienes" class="btn btn-link text-light" style="color: white;">¿Quiénes somos?</a>
                <button class="btn btn-danger" id="open-login-modal">Iniciar Sesión</button>
                <a href="#" class="btn btn-primary" id="open-register-modal">Registrarse</a>
                <a href="./controller/usercontrolador.php?accion=ayuda" id="btn-ayuda" class="btn btn-link text-light" style="color: white;">
                    <i class="bi bi-question-circle"></i> Ayuda
                </a>
            </div>
            <div id="user-options">
                <i class="bi bi-person-circle" style="color: white; font-size: 1.5rem;"></i>
                <span id="user-name" class="user-info" style="color: white;"></span>
                <a href="carrito.php" aria-label="Carrito de compras"><i class="bi bi-cart"></i></a>
                <a href="../controller/logout.php" aria-label="Cerrar sesión" style="color: white;">
                    <i class="bi bi-power" style="font-size: 2.0rem;"></i>
                </a>
                <a href="./controller/usercontrolador.php?accion=ayuda" id="btn-ayuda" class="btn btn-link text-light" style="color: white;">
                    <i class="bi bi-question-circle"></i> Ayuda
                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-3">
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action" onclick="cambiarImagen('../<?php echo $producto['imagen_url']; ?>')">
                        <img src="../<?php echo $producto['imagen_url']; ?>" alt="Miniatura" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <img id="imagenAmpliada" src="../<?php echo $producto['imagen_url']; ?>" alt="Imagen Ampliada" class="img-fluid">
            </div>
            <div class="col-md-4">
                <h2 class="font-weight-bold"><?php echo $producto['nombre']; ?></h2>
                <span>$<?php echo number_format($producto['precio'], 2); ?></span>
                <p><?php echo $producto['descripcion']; ?></p>
                <div class="d-flex justify-content-center mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(-1)">-</button>
                        </div>
                        <input type="text" class="form-control text-center" id="cantidad" value="1" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="cambiarCantidad(1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary" onclick="agregarAlCarrito(<?php echo $producto_id; ?>, document.getElementById('cantidad').value)">
                        Agregar al Carrito
                    </button>
                </div>
            </div>
        </div>
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
      <div id="modal-agregado-carrito" class="modal">
        <div class="modal-content">
            <span class="close-button" aria-label="Cerrar modal">&times;</span> 
            <h2 class="modal-title"><i class="bi bi-check-circle-fill"></i> Producto Agregado</h2>
            <p id="modal-agregado-mensaje" class="modal-body-text">Tu producto se ha añadido correctamente al carrito de compras.</p>
            <div class="modal-buttons-group">
                <button id="modal-ir-carrito-btn" class="modal-button primary-button">Ir al Carrito</button>
                <button id="modal-seguir-comprando-btn" class="modal-button secondary-button">Seguir Comprando</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../public/js/producto.js?v=<?= time() ?>"></script>
    <script src="../public/js/index.js"></script>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/app copy.js"></script>
    <script src="../public/js/carrito.js"></script>
</body>
</html>