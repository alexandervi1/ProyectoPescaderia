<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - Juguetería Marianita</title>
    <!-- Bootstrap ICONS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../public/css/style.css" rel="stylesheet">
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
                        Para buscar un producto, escribe su nombre en la barra de búsqueda y presiona Enter o haz clic en el ícono de búsqueda.
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
                        Ve a la parte de registro, completa el formulario con tus datos y haz clic en "Registrarse".
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
                        Haz clic en el botón "Iniciar sesión", ingresa tu usuario y contraseña, y presiona "Ingresar".
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
                        Agrega los productos al carrito, hacemos clic en el boton comprar, se envia el producto seleccionado al carrito y se realiza el pedidpSS.
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container text-center">
            <p>Contacto: 09924700553-0982744920</p>
            <p>Dirección: Av. Canonigo Ramos y Av.11 de Noviembre y  - Riobamba</p>
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
