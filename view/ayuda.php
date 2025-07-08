<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Ayuda - Pescadería Don Walter</title>
    <!-- Bootstrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../public/css/style.css" rel="stylesheet">
    <style>
        /* Estilos adicionales para la página de ayuda si no están en style.css */
        body {
            background-color: #f0f8ff; /* Alice Blue, un azul muy claro */
            font-family: 'Inter', sans-serif;
        }
        .navbar {
            background-color: #1A519D; /* Azul oscuro */
            padding: 10px 0;
            box-shadow: none;
        }
        .navbar-brand img {
            background-color: white;
            padding: 5px;
            border-radius: 5px;
        }
        .btn-warning {
            background-color: #ffc107; /* Amarillo de Bootstrap */
            border-color: #ffc107;
            color: #212529; /* Texto oscuro para contraste */
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .accordion-item {
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden; /* Para que los bordes redondeados se apliquen bien */
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); /* Sombra suave */
        }
        .accordion-header .accordion-button {
            background-color: #1A519D; /* Azul oscuro para los encabezados */
            color: white;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 15px 20px;
            border-radius: 8px; /* Bordes redondeados para el botón */
            transition: background-color 0.3s ease;
        }
        .accordion-header .accordion-button:hover {
            background-color: #154382; /* Tono más oscuro al hacer hover */
        }
        .accordion-button:not(.collapsed) {
            background-color: #002E5D; /* Azul aún más oscuro cuando está abierto */
            color: white;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .accordion-body {
            background-color: #f8f9fa; /* Fondo claro para el contenido */
            color: #343a40;
            padding: 20px;
            text-align: left;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="../index.html">
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Don Walter" width="200" height="64">
            </a>
            <div class="ms-auto">
                <a href="../index.html" class="btn btn-warning">
                    <i class="bi bi-house-door"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container text-center mt-4">
        <h1 class="mb-4">Centro de Ayuda</h1>

        <div class="accordion" id="helpAccordion">
            <!-- Cómo realizar búsquedas -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSearch">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSearch" aria-expanded="true" aria-controls="collapseSearch">
                        🔍 ¿Cómo realizar búsquedas?
                    </button>
                </h2>
                <div id="collapseSearch" class="accordion-collapse collapse show" aria-labelledby="headingSearch" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Para encontrar rápidamente el producto que buscas, utiliza la barra de búsqueda ubicada en la parte superior de la página.
                        Simplemente escribe el nombre del producto (por ejemplo, "camarones", "tilapia", "pulpo") y presiona la tecla Enter o haz clic en el ícono de la lupa (🔍).
                        Los resultados se mostrarán en la misma página, filtrando los productos disponibles que coincidan con tu búsqueda.
                    </div>
                </div>
            </div>
            
            <!-- Cómo registrarse -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingRegister">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRegister" aria-expanded="false" aria-controls="collapseRegister">
                        📝 ¿Cómo registrarse?
                    </button>
                </h2>
                <div id="collapseRegister" class="accordion-collapse collapse" aria-labelledby="headingRegister" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Crear una cuenta es rápido y sencillo. Sigue estos pasos:
                        <ol>
                            <li>Haz clic en el botón "Registrarse" que se encuentra en la esquina superior derecha de la página.</li>
                            <li>Se abrirá un formulario de registro. Rellena todos los campos obligatorios, incluyendo tu nombre completo, un nombre de usuario único y una contraseña segura.</li>
                            <li>Una vez completados los datos, haz clic en el botón "Registrarse" al final del formulario.</li>
                        </ol>
                        ¡Listo! Ya tendrás tu cuenta creada y podrás iniciar sesión para disfrutar de todas las funcionalidades de nuestra tienda.
                    </div>
                </div>
            </div>

            <!-- Cómo iniciar sesión -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingLogin">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogin" aria-expanded="false" aria-controls="collapseLogin">
                        🔑 ¿Cómo iniciar sesión?
                    </button>
                </h2>
                <div id="collapseLogin" class="accordion-collapse collapse" aria-labelledby="headingLogin" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Para acceder a tu cuenta y a tus beneficios como cliente, sigue estos pasos:
                        <ol>
                            <li>Haz clic en el botón "Iniciar Sesión" ubicado en la esquina superior derecha de la página.</li>
                            <li>Aparecerá una ventana emergente (modal) solicitando tus credenciales.</li>
                            <li>Ingresa tu Nombre de Usuario y tu Contraseña en los campos correspondientes.</li>
                            <li>Finalmente, haz clic en el botón "Ingresar".</li>
                        </ol>
                        Si tus datos son correctos, serás redirigido a la página principal con tu sesión activa.
                    </div>
                </div>
            </div>
            
            <!-- Cómo hacer un pedido -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOrder">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder" aria-expanded="false" aria-controls="collapseOrder">
                        🛒 ¿Cómo hacer un pedido?
                    </button>
                </h2>
                <div id="collapseOrder" class="accordion-collapse collapse" aria-labelledby="headingOrder" data-bs-parent="#helpAccordion">
                    <div class="accordion-body">
                        Realizar un pedido en Pescadería Don Walter es muy sencillo:
                        <ol>
                            <li>Explora nuestros productos: Navega por nuestras categorías o utiliza la barra de búsqueda para encontrar los mariscos que deseas.</li>
                            <li>Añade al carrito: Una vez que encuentres un producto, haz clic en el botón "Comprar" o "Agregar al Carrito" en la tarjeta del producto o en su página de detalles. Puedes ajustar la cantidad deseada antes de añadirlo.</li>
                            <li>Revisa tu carrito: Cuando hayas añadido todos los productos, haz clic en el ícono del carrito (🛒) en la barra de navegación para revisar tu selección. Aquí podrás modificar cantidades o eliminar productos.</li>
                            <li>Finaliza la compra: Si todo es correcto, procede a la sección de pago (o confirmación de pedido, según tu flujo de compra) para completar tu pedido.</li>
                        </ol>
                        ¡Tu pedido será procesado y te lo haremos llegar lo antes posible!
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
