<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiénes Somos - Juguetería Marianita</title>
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
                <img src="../public/img/Pescaderia Don Walter logo.png" alt="Logo Juguetería Marianita" width="200" height="64">
            </a>
            <div class="ms-auto">
                <a href="../index.html" class="btn btn-warning">
                    <i class="bi bi-house-door"></i> Volver a la tienda
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
     <!-- HERO SECTION -->
    <section class="hero bg-gradient-primary text-white position-relative overflow-hidden">
        <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(135deg, rgba(13, 110, 253, 0.9), rgba(25, 135, 84, 0.8));"></div>
        <div class="container position-relative py-5">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="hero-text">
                        <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInUp">🌊 Del Mar a Tu Mesa 🐟</h1>
                        <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Más de 15 años llevando la frescura del océano directamente a tu hogar con calidad premium</p>
                        <div class="wave-decoration d-flex justify-content-center justify-content-lg-start gap-3 mb-4">
                            <ion-icon name="water" class="text-info fs-2"></ion-icon>
                            <ion-icon name="fish" class="text-warning fs-2"></ion-icon>
                            <ion-icon name="water" class="text-info fs-2"></ion-icon>
                        </div>
                        <a href="#presentacion" class="btn btn-outline-light btn-lg px-4 py-2 rounded-pill">
                            Conoce más <i class="bi bi-arrow-down-circle ms-2"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="hero-image position-relative">
                        <div class="bg-white rounded-circle shadow-lg p-4 d-inline-block">
                            <img src="../public/img/cangrejo.png" 
                                 alt="Logo Pescadería Don Walter" 
                                 class="mascota img-fluid" 
                                 style="max-width: 300px; height: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Decorative wave -->
        <div class="position-absolute bottom-0 start-0 w-100">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" style="height: 60px; width: 100%;">
                <path d="M0,120 C150,80 350,40 600,60 C850,80 1050,40 1200,80 L1200,120 Z" fill="white"></path>
            </svg>
        </div>
    </section>

    <!-- PRESENTACIÓN -->
    <section id="presentacion" class="presentacion py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="intro-card bg-white rounded-4 shadow-lg p-5 border-0">
                        <div class="text-center mb-5">
                            <h2 class="display-5 fw-bold text-primary mb-4">🐙 Bienvenidos a Pescadería Don Walter</h2>
                            <div class="mx-auto bg-primary rounded-pill mb-4" style="width: 80px; height: 4px;"></div>
                        </div>
                        <p class="intro-text fs-5 text-muted text-center mb-5 lh-lg">
                            Somos una empresa familiar que nació del amor por el mar y la pasión por ofrecer 
                            productos marinos de la más alta calidad. En cada producto que vendemos, 
                            llevamos el sabor auténtico del océano y el compromiso con la frescura que nos caracteriza.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="stat-card h-100">
                                    <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <span class="stat-number fs-3 fw-bold text-white">15+</span>
                                    </div>
                                    <h5 class="stat-label fw-semibold text-dark">Años de experiencia</h5>
                                    <p class="text-muted small">Décadas perfeccionando nuestro arte</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="stat-card h-100">
                                    <div class="bg-success bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <span class="stat-number fs-3 fw-bold text-white">1K+</span>
                                    </div>
                                    <h5 class="stat-label fw-semibold text-dark">Clientes satisfechos</h5>
                                    <p class="text-muted small">Familias que confían en nosotros</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="stat-card h-100">
                                    <div class="bg-warning bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                        <span class="stat-number fs-3 fw-bold text-white">100%</span>
                                    </div>
                                    <h5 class="stat-label fw-semibold text-dark">Productos frescos</h5>
                                    <p class="text-muted small">Garantía de calidad superior</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MISIÓN -->
    <section id="mision" class="mision py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="content-card bg-white rounded-4 shadow-lg p-5 border-0">
                        <div class="row align-items-center">
                            <div class="col-lg-3 text-center mb-4 mb-lg-0">
                                <div class="icon-container bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px;">
                                    <ion-icon name="target" class="section-icon text-white" style="font-size: 3rem;"></ion-icon>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <h2 class="display-6 fw-bold text-primary mb-4">🎯 Nuestra Misión</h2>
                                <p class="fs-5 text-muted lh-lg mb-4">
                                    Proveer productos marinos frescos, sostenibles y de excelente calidad, 
                                    manteniendo la tradición pesquera artesanal mientras adoptamos prácticas 
                                    responsables con el medio ambiente. Nos comprometemos a ser el puente 
                                    entre el océano y las familias ecuatorianas, garantizando que cada 
                                    producto llegue a su mesa con la frescura del primer día.
                                </p>
                            </div>
                        </div>
                        
                        <div class="row g-4 mt-4">
                            <div class="col-lg-4">
                                <div class="mission-point h-100 p-4 bg-light rounded-3 border-start border-primary border-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="point-icon bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <ion-icon name="water" class="text-white fs-5"></ion-icon>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0">Frescura Diaria</h5>
                                    </div>
                                    <p class="text-muted mb-0">Productos del mar seleccionados cada amanecer, garantizando máxima calidad</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mission-point h-100 p-4 bg-light rounded-3 border-start border-success border-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="point-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <ion-icon name="leaf" class="text-white fs-5"></ion-icon>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0">Pesca Sostenible</h5>
                                    </div>
                                    <p class="text-muted mb-0">Métodos responsables que protegen nuestros océanos para futuras generaciones</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mission-point h-100 p-4 bg-light rounded-3 border-start border-warning border-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="point-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                            <ion-icon name="people" class="text-white fs-5"></ion-icon>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-0">Comunidad Local</h5>
                                    </div>
                                    <p class="text-muted mb-0">Colaboración directa con pescadores artesanales de nuestra región</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VISIÓN -->
    <section id="vision" class="vision py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="content-card bg-white rounded-4 shadow-lg p-5 border-0">
                        <div class="row align-items-center">
                            <div class="col-lg-9 order-lg-1">
                                <h2 class="display-6 fw-bold text-primary mb-4">🔭 Nuestra Visión</h2>
                                <p class="fs-5 text-muted lh-lg mb-4">
                                    Ser la pescadería líder en la región, reconocida por nuestra excelencia 
                                    en calidad, innovación en servicios y compromiso con la sostenibilidad marina. 
                                    Aspiramos a expandir nuestro alcance manteniendo los valores familiares 
                                    que nos fundaron, contribuyendo al desarrollo de la industria pesquera 
                                    local y siendo un referente en la comercialización responsable de productos del mar.
                                </p>
                            </div>
                            <div class="col-lg-3 order-lg-2 text-center mb-4 mb-lg-0">
                                <div class="icon-container bg-info bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px;">
                                    <ion-icon name="telescope" class="section-icon text-white" style="font-size: 3rem;"></ion-icon>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-4 mt-4">
                            <div class="col-lg-4">
                                <div class="vision-goal h-100 text-center p-4 bg-light rounded-3 border-top border-info border-4">
                                    <div class="goal-icon bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <ion-icon name="trending-up" class="text-white fs-4"></ion-icon>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-3">Crecimiento Sostenible</h5>
                                    <p class="text-muted mb-0">Expandir responsablemente preservando la calidad que nos distingue y manteniendo nuestros valores familiares</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="vision-goal h-100 text-center p-4 bg-light rounded-3 border-top border-success border-4">
                                    <div class="goal-icon bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <ion-icon name="shield-checkmark" class="text-white fs-4"></ion-icon>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-3">Compromiso Ambiental</h5>
                                    <p class="text-muted mb-0">Liderar en prácticas ecológicas marinas, siendo pioneros en la conservación de nuestros ecosistemas</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="vision-goal h-100 text-center p-4 bg-light rounded-3 border-top border-warning border-4">
                                    <div class="goal-icon bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                        <ion-icon name="handshake" class="text-white fs-4"></ion-icon>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-3">Fortalecimiento Comunitario</h5>
                                    <p class="text-muted mb-0">Impulsar la economía pesquera local creando oportunidades para nuestras comunidades costeras</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VALORES -->
    <section class="valores py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-primary mb-4">🌟 Nuestros Valores</h2>
                <div class="mx-auto bg-primary rounded-pill mb-4" style="width: 80px; height: 4px;"></div>
                <p class="lead text-muted">Los principios que guían cada día nuestro trabajo</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="valor-card h-100 bg-white rounded-4 shadow-lg p-4 text-center border-0 hover-lift">
                        <div class="bg-danger bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 80px; height: 80px;">
                            <ion-icon name="heart" class="text-white" style="font-size: 2.5rem;"></ion-icon>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Pasión</h4>
                        <p class="text-muted mb-0">Amor genuino por lo que hacemos y por servir a nuestros clientes con dedicación</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="valor-card h-100 bg-white rounded-4 shadow-lg p-4 text-center border-0 hover-lift">
                        <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 80px; height: 80px;">
                            <ion-icon name="shield-checkmark" class="text-white" style="font-size: 2.5rem;"></ion-icon>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Calidad</h4>
                        <p class="text-muted mb-0">Compromiso inquebrantable con la excelencia en cada producto que ofrecemos</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="valor-card h-100 bg-white rounded-4 shadow-lg p-4 text-center border-0 hover-lift">
                        <div class="bg-warning bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 80px; height: 80px;">
                            <ion-icon name="handshake" class="text-white" style="font-size: 2.5rem;"></ion-icon>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Confianza</h4>
                        <p class="text-muted mb-0">Relaciones duraderas basadas en honestidad, transparencia y respeto mutuo</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="valor-card h-100 bg-white rounded-4 shadow-lg p-4 text-center border-0 hover-lift">
                        <div class="bg-success bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow" style="width: 80px; height: 80px;">
                            <ion-icon name="earth" class="text-white" style="font-size: 2.5rem;"></ion-icon>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Sostenibilidad</h4>
                        <p class="text-muted mb-0">Respeto y cuidado por nuestros océanos y recursos marinos para el futuro</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
