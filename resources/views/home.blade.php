<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    {{-- SEO Meta Tags, Open Graph, Twitter Cards, y Scripts de Seguimiento --}}
    <x-seo-head page="home" />

    <!-- Favicon -->
    <link
        href="{{ $companyInfo->logo ? (str_starts_with($companyInfo->logo, 'img/') ? asset($companyInfo->logo) : asset('storage/' . $companyInfo->logo)) : asset('img/logo.png') }}"
        rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;600;800&family=Roboto:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom CSS for scroll offset -->
    <style>
        #nosotros {
            scroll-margin-top: 25px;
        }

        #servicios {
            scroll-margin-top: 50px;
        }

        #equipo {
            scroll-margin-top: 50px;
        }
    </style>

    <!-- Active Navigation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navLinks = document.querySelectorAll('.navbar-nav a[href^="#"]');

            function updateActiveNav() {
                let current = 'inicio';

                // Check nosotros section
                const nosotrosSection = document.getElementById('nosotros');
                if (nosotrosSection) {
                    const rect = nosotrosSection.getBoundingClientRect();
                    if (rect.top <= 200) {
                        current = 'nosotros';
                    }
                }
                const serviciosSection = document.getElementById('servicios');
                if (serviciosSection) {
                    const rect = serviciosSection.getBoundingClientRect();
                    if (rect.top <= 200) {
                        current = 'servicios';
                    }
                }
                const equipoSection = document.getElementById('equipo');
                if (equipoSection) {
                    const rect = equipoSection.getBoundingClientRect();
                    if (rect.top <= 200) {
                        current = 'equipo';
                    }
                }
                // Update nav links
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }

            window.addEventListener('scroll', updateActiveNav);
            updateActiveNav();
        });
    </script>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <seccion id="inicio">
        @include('partials.topbar')
        <!-- Topbar End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
            <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
                @if ($companyInfo)
                    <h1 class="m-0"><img class="img-fluid me-3"
                            src="{{ $companyInfo->logo ? (str_starts_with($companyInfo->logo, 'img/') ? asset($companyInfo->logo) : asset('storage/' . $companyInfo->logo)) : asset('img/logo.png') }}"
                            alt=""></h1>
                @else
                    <h1 class="m-0"><img class="img-fluid me-3" src="{{ asset('img/logo.png') }}" alt="">AirCon</h1>
                @endif
            </a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto bg-light pe-4 py-3 py-lg-0">
                    <a href="#inicio" class="nav-item nav-link active">Inicio</a>
                    <a href="#nosotros" class="nav-item nav-link">Nosotros</a>
                    @if($companyInfo && $companyInfo->services_enabled)
                        <a href="#servicios" class="nav-item nav-link">Nuestros Servicios</a>
                    @endif
                    @if($companyInfo && $companyInfo->testimonials_enabled)
                        <a href="#equipo" class="nav-item nav-link">Nuestro Equipo</a>
                    @endif
                    <a href="{{ route('contact') }}" class="nav-item nav-link">Contáctanos</a>
                </div>
                @include('partials.social-links')
            </div>
        </nav>
        <!-- Navbar End -->

        @if($companyInfo && $companyInfo->slides_enabled && $slides->count() > 0)
            <!-- Carousel Start -->
            <div class="container-fluid p-0 mb-5">
                <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($slides as $index => $slide)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img class="w-100"
                                    src="{{ $slide->image ? (str_starts_with($slide->image, 'img/') ? asset($slide->image) : asset('storage/' . $slide->image)) : asset('img/carousel-1.jpg') }}"
                                    alt="{{ $slide->title }}">
                                <div class="carousel-caption">
                                    <div class="container">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-7 pt-5">
                                                <h1 class="display-4 text-white mb-4 animated slideInDown">
                                                    {{ $slide->title }}
                                                </h1>
                                                <p class="fs-5 text-body mb-4 pb-2 mx-sm-5 animated slideInDown">
                                                    {{ $slide->subtitle }}
                                                </p>
                                                @if ($slide->button_text && $slide->button_url)
                                                    <a href="{{ $slide->button_url }}"
                                                        class="btn btn-primary py-3 px-5 animated slideInDown">{{ $slide->button_text }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#header-carousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </div>
        @endif
        </section>
        <!-- Carousel End -->


        <!-- About Start -->
        <section id="nosotros">
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="h-100">
                                <h1 class="display-6 mb-5">{{ $companyInfo->about_title }}</h1>
                                <div class="row g-4 mb-4">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 me-3"
                                                src="{{ $companyInfo->feature_1_icon ? (str_starts_with($companyInfo->feature_1_icon, 'img/') ? asset($companyInfo->feature_1_icon) : asset('storage/' . $companyInfo->feature_1_icon)) : asset('img/icon/icon-07-primary.png') }}"
                                                alt="">
                                            <h5 class="mb-0">{{ $companyInfo->feature_1_title }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 me-3"
                                                src="{{ $companyInfo->feature_2_icon ? (str_starts_with($companyInfo->feature_2_icon, 'img/') ? asset($companyInfo->feature_2_icon) : asset('storage/' . $companyInfo->feature_2_icon)) : asset('img/icon/icon-09-primary.png') }}"
                                                alt="">
                                            <h5 class="mb-0">{{ $companyInfo->feature_2_title }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-4">{{ $companyInfo->about_description }}</p>
                                <div class="border-top mt-4 pt-4">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center">
                                                <div class="btn-lg-square bg-primary rounded-circle me-3">
                                                    <i class="fa fa-phone-alt text-white"></i>
                                                </div>
                                                <h5 class="mb-0">{{ $companyInfo->phone }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="d-flex align-items-center">
                                                <div class="btn-lg-square bg-primary rounded-circle me-3">
                                                    <i class="fa fa-envelope text-white"></i>
                                                </div>
                                                <h5 class="mb-0">{{ $companyInfo->email }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-3">
                                <div class="col-6 text-end">
                                    <img class="img-fluid w-75 wow zoomIn" data-wow-delay="0.1s"
                                        src="{{ $companyInfo->about_image_1 ? (str_starts_with($companyInfo->about_image_1, 'img/') ? asset($companyInfo->about_image_1) : asset('storage/' . $companyInfo->about_image_1)) : asset('img/about-1.jpg') }}"
                                        style="margin-top: 25%;">
                                </div>
                                <div class="col-6 text-start">
                                    <img class="img-fluid w-100 wow zoomIn" data-wow-delay="0.3s"
                                        src="{{ $companyInfo->about_image_2 ? (str_starts_with($companyInfo->about_image_2, 'img/') ? asset($companyInfo->about_image_2) : asset('storage/' . $companyInfo->about_image_2)) : asset('img/about-2.jpg') }}">
                                </div>
                                <div class="col-6 text-end">
                                    <img class="img-fluid w-50 wow zoomIn" data-wow-delay="0.5s"
                                        src="{{ $companyInfo->about_image_3 ? (str_starts_with($companyInfo->about_image_3, 'img/') ? asset($companyInfo->about_image_3) : asset('storage/' . $companyInfo->about_image_3)) : asset('img/about-3.jpg') }}">
                                </div>
                                <div class="col-6 text-start">
                                    <img class="img-fluid w-75 wow zoomIn" data-wow-delay="0.7s"
                                        src="{{ $companyInfo->about_image_4 ? (str_starts_with($companyInfo->about_image_4, 'img/') ? asset($companyInfo->about_image_4) : asset('storage/' . $companyInfo->about_image_4)) : asset('img/about-4.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- About End -->


            @if($companyInfo && $companyInfo->facts_enabled)
                <!-- Facts Start -->
                <div class="container-fluid facts my-5 py-5" data-parallax="scroll"
                    data-image-src="{{ $companyInfo->facts_bg_image ? (str_starts_with($companyInfo->facts_bg_image, 'img/') ? asset($companyInfo->facts_bg_image) : asset('storage/' . $companyInfo->facts_bg_image)) . '?v=' . time() : asset('img/carousel-1.jpg') }}">
                    <div class="container py-5">
                        <div class="row g-5">
                            <div class="col-sm-6 col-lg-3 wow fadeIn text-center" data-wow-delay="0.1s">
                                <h1 class="display-4 text-white" data-toggle="counter-up">
                                    {{ $companyInfo->facts_clients_count ?? '1234' }}
                                </h1>
                                <span
                                    class="text-primary">{{ $companyInfo->facts_clients_label ?? 'Clientes Satisfechos' }}</span>
                            </div>
                            <div class="col-sm-6 col-lg-3 wow fadeIn text-center" data-wow-delay="0.3s">
                                <h1 class="display-4 text-white" data-toggle="counter-up">
                                    {{ $companyInfo->facts_projects_count ?? '567' }}
                                </h1>
                                <span
                                    class="text-primary">{{ $companyInfo->facts_projects_label ?? 'Proyectos Completados' }}</span>
                            </div>
                            <div class="col-sm-6 col-lg-3 wow fadeIn text-center" data-wow-delay="0.5s">
                                <h1 class="display-4 text-white" data-toggle="counter-up">
                                    {{ $companyInfo->facts_experts_count ?? '89' }}
                                </h1>
                                <span
                                    class="text-primary">{{ $companyInfo->facts_experts_label ?? 'Técnicos Expertos' }}</span>
                            </div>
                            <div class="col-sm-6 col-lg-3 wow fadeIn text-center" data-wow-delay="0.7s">
                                <h1 class="display-4 text-white" data-toggle="counter-up">
                                    {{ $companyInfo->facts_support_count ?? '24' }}
                                </h1>
                                <span class="text-primary">{{ $companyInfo->facts_support_label ?? 'Soporte 24/7' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Facts End -->
            @endif


            <!-- Features Start -->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="row g-5">
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                            <h1 class="display-6 mb-5">
                                {{ $companyInfo->features_title ?? '¡Algunas Razones Por Las Que La Gente Nos Elige!' }}
                            </h1>
                            <p class="mb-5">
                                {{ $companyInfo->features_description ?? 'Somos una empresa comprometida con la excelencia en el servicio, ofreciendo soluciones integrales de climatización con la mejor relación calidad-precio del mercado.' }}
                            </p>
                            <div class="d-flex mb-5">
                                <div class="flex-shrink-0 btn-square bg-primary rounded-circle"
                                    style="width: 90px; height: 90px;">
                                    <img class="img-fluid"
                                        src="{{ $companyInfo->feature_description_1_icon ? (str_starts_with($companyInfo->feature_description_1_icon, 'img/') ? asset($companyInfo->feature_description_1_icon) : asset('storage/' . $companyInfo->feature_description_1_icon)) : asset('img/icon/icon-08-light.png') }}"
                                        alt="">
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-3">
                                        {{ $companyInfo->feature_1_title ?? 'Centro de Servicio Confiable' }}
                                    </h5>
                                    <span>{{ $companyInfo->feature_1_description ?? 'Más de 5 años de experiencia nos respaldan como el centro de servicio más confiable de la región.' }}</span>
                                </div>
                            </div>
                            <div class="d-flex mb-5">
                                <div class="flex-shrink-0 btn-square bg-primary rounded-circle"
                                    style="width: 90px; height: 90px;">
                                    <img class="img-fluid"
                                        src="{{ $companyInfo->feature_description_2_icon ? (str_starts_with($companyInfo->feature_description_2_icon, 'img/') ? asset($companyInfo->feature_description_2_icon) : asset('storage/' . $companyInfo->feature_description_2_icon)) : asset('img/icon/icon-10-light.png') }}"
                                        alt="">
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-3">{{ $companyInfo->feature_2_title ?? 'Precio Razonable' }}</h5>
                                    <span>{{ $companyInfo->feature_2_description ?? 'Ofrecemos los mejores precios del mercado sin comprometer la calidad de nuestros servicios.' }}</span>
                                </div>
                            </div>
                            <div class="d-flex mb-0">
                                <div class="flex-shrink-0 btn-square bg-primary rounded-circle"
                                    style="width: 90px; height: 90px;">
                                    <img class="img-fluid"
                                        src="{{ $companyInfo->feature_description_3_icon ? (str_starts_with($companyInfo->feature_description_3_icon, 'img/') ? asset($companyInfo->feature_description_3_icon) : asset('storage/' . $companyInfo->feature_description_3_icon)) : asset('img/icon/icon-06-light.png') }}"
                                        alt="">
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-3">{{ $companyInfo->feature_3_title ?? 'Soporte 24/7' }}</h5>
                                    <span>{{ $companyInfo->feature_3_description ?? 'Estamos disponibles las 24 horas del día, los 7 días de la semana para atender tus emergencias.' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="position-relative rounded overflow-hidden h-100" style="min-height: 400px;">
                                <img class="position-absolute w-100 h-100"
                                    src="{{ $companyInfo->features_image ? (str_starts_with($companyInfo->features_image, 'img/') ? asset($companyInfo->features_image) : asset('storage/' . $companyInfo->features_image)) : asset('img/feature.jpg') }}"
                                    alt="" style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Features End -->


        @if($companyInfo && $companyInfo->services_enabled && $services->count() > 0)
            <!-- Service Start -->
            <sectcion id="servicios">
                <div class="container-xxl py-5">
                    <div class="container">
                        <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                            <h1 class="display-6 mb-5">
                                {{ $companyInfo->services_title ?? 'Brindamos Servicios Profesionales de Refrigeración y Más' }}
                            </h1>
                            @if ($companyInfo->services_subtitle)
                                <p class="mb-4">{{ $companyInfo->services_subtitle }}</p>
                            @endif
                        </div>
                        <div class="row g-4 justify-content-center">
                            @foreach ($services as $index => $service)
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($index % 3) * 0.2 }}s">
                                    <div class="service-item">
                                        <img class="img-fluid"
                                            src="{{ $service->image ? (str_starts_with($service->image, 'img/') ? asset($service->image) : asset('storage/' . $service->image)) : asset('img/service-1.jpg') }}"
                                            alt="{{ $service->name }}">
                                        <div class="d-flex align-items-center bg-light">
                                            <div class="service-icon flex-shrink-0 bg-primary">
                                                <img class="img-fluid"
                                                    src="{{ $service->icon ? (str_starts_with($service->icon, 'img/') ? asset($service->icon) : asset('storage/' . $service->icon)) : asset('img/icon/icon-01-primary.png') }}"
                                                    alt="">
                                            </div>
                                            <a class="h4 mx-4 mb-0" href="#">{{ $service->name }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        @endif
            <!-- Service End -->


            <!-- Quote Start -->
            <div class="container-fluid overflow-hidden my-5 px-lg-0">
                <div class="container quote px-lg-0">
                    <div class="row g-0 mx-lg-0">
                        <div class="col-lg-6 quote-text" data-parallax="scroll"
                            data-image-src="{{ $companyInfo->quote_bg_image_1 ? (str_starts_with($companyInfo->quote_bg_image_1, 'img/') ? asset($companyInfo->quote_bg_image_1) : asset('storage/' . $companyInfo->quote_bg_image_1)) : asset('img/carousel-1.jpg') }}">
                            <div class="h-100 px-4 px-sm-5 ps-lg-0 wow fadeIn" data-wow-delay="0.1s">
                                <h1 class="text-white mb-4">
                                    {{ $companyInfo->quote_title ?? 'Para Particulares y Organizaciones' }}
                                </h1>
                                <p class="text-light mb-5">
                                    {{ $companyInfo->quote_description ?? 'Ofrecemos servicios especializados tanto para hogares como para empresas, adaptándonos a las necesidades específicas de cada cliente con soluciones personalizadas.' }}
                                </p>
                                @if($companyInfo->quote_button_text)
                                    <a href="{{ $companyInfo->quote_button_url ?? '#' }}"
                                        class="align-self-start btn btn-primary py-3 px-5">{{ $companyInfo->quote_button_text }}</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6 quote-form" data-parallax="scroll"
                            data-image-src="{{ $companyInfo->quote_bg_image_2 ? (str_starts_with($companyInfo->quote_bg_image_2, 'img/') ? asset($companyInfo->quote_bg_image_2) : asset('storage/' . $companyInfo->quote_bg_image_2)) : asset('img/carousel-2.jpg') }}">
                            <div class="h-100 px-4 px-sm-5 pe-lg-0 wow fadeIn" data-wow-delay="0.5s">
                                <div class="bg-white p-4 p-sm-5">
                                    <form id="quoteForm">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="gname" name="name"
                                                        placeholder="Nombre" required>
                                                    <label
                                                        for="gname">{{ $companyInfo->quote_form_name_label ?? 'Tu Nombre' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="gmail" name="email"
                                                        placeholder="Email" required>
                                                    <label
                                                        for="gmail">{{ $companyInfo->quote_form_email_label ?? 'Tu Email' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="cname" name="phone"
                                                        placeholder="Móvil" required>
                                                    <label
                                                        for="cname">{{ $companyInfo->quote_form_phone_label ?? 'Tu Móvil' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="cage" name="service"
                                                        placeholder="Servicio" required>
                                                    <label
                                                        for="cage">{{ $companyInfo->quote_form_service_label ?? 'Tipo de Servicio' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Mensaje" id="message"
                                                        name="message" style="height: 80px" required></textarea>
                                                    <label
                                                        for="message">{{ $companyInfo->quote_form_message_label ?? 'Mensaje' }}</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div id="quoteFormMessage"></div>
                                            </div>
                                            <div class="col-12">
                                                <button class="btn btn-primary py-3 px-5" type="submit"
                                                    id="quoteSubmitBtn">
                                                    <span
                                                        id="btnText">{{ $companyInfo->quote_form_button_text ?? 'Obtener Cotización Gratuita' }}</span>
                                                    <span id="btnSpinner" class="d-none">
                                                        <span class="spinner-border spinner-border-sm me-2"
                                                            role="status" aria-hidden="true"></span>
                                                        Enviando...
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
            <!-- Quote End -->


            <!-- Team Start -->
            @if($companyInfo && $companyInfo->testimonials_enabled && $testimonials->count() > 0)
                <sectcion id="equipo">
                    <!-- Testimonial Start -->
                    <div class="container-xxl py-5">
                        <div class="container">
                            <div class="text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                                <h1 class="display-6 mb-5">
                                    {{ $companyInfo->testimonials_title ?? 'Lo Que Dicen Sobre Nuestros Servicios' }}
                                </h1>
                            </div>
                            <div class="row g-5">
                                <div class="col-lg-3 d-none d-lg-block">
                                    <div class="testimonial-left h-100">
                                        @foreach($testimonials->take(3) as $testimonial)
                                            <img class="img-fluid animated pulse infinite"
                                                src="{{ $testimonial->image ? (str_starts_with($testimonial->image, 'img/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : asset('img/testimonial-1.jpg') }}"
                                                alt="{{ $testimonial->client_name }}">
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                    <div class="owl-carousel testimonial-carousel">
                                        @foreach ($testimonials as $testimonial)
                                            <div class="testimonial-item text-center">
                                                <img class="img-fluid mx-auto mb-4"
                                                    src="{{ $testimonial->image ? (str_starts_with($testimonial->image, 'img/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : asset('img/testimonial-1.jpg') }}"
                                                    alt="{{ $testimonial->client_name }}">
                                                <p class="fs-5">{{ $testimonial->content }}</p>
                                                <h5>{{ $testimonial->client_name }}</h5>
                                                <span>{{ $testimonial->client_position }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-3 d-none d-lg-block">
                                    <div class="testimonial-right h-100">
                                        @foreach($testimonials->take(3) as $testimonial)
                                            <img class="img-fluid animated pulse infinite"
                                                src="{{ $testimonial->image ? (str_starts_with($testimonial->image, 'img/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : asset('img/testimonial-1.jpg') }}"
                                                alt="{{ $testimonial->client_name }}">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </section>
            @endif
                <!-- Testimonial End -->


                <!-- Footer Start -->
                @include('partials.footer')
                <!-- Footer End -->


                <!-- Back to Top -->
                <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i
                        class="bi bi-arrow-up"></i></a>


                <!-- JavaScript Libraries -->
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="lib/wow/wow.min.js"></script>
                <script src="lib/easing/easing.min.js"></script>
                <script src="lib/waypoints/waypoints.min.js"></script>
                <script src="lib/owlcarousel/owl.carousel.min.js"></script>
                <script src="lib/counterup/counterup.min.js"></script>
                <script src="lib/parallax/parallax.min.js"></script>

                <!-- Template Javascript -->
                <script src="js/main.js"></script>

                <!-- Quote Form Handler -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const quoteForm = document.getElementById('quoteForm');
                        const submitBtn = document.getElementById('quoteSubmitBtn');
                        const btnText = document.getElementById('btnText');
                        const btnSpinner = document.getElementById('btnSpinner');
                        const messageDiv = document.getElementById('quoteFormMessage');

                        quoteForm.addEventListener('submit', function (e) {
                            e.preventDefault();

                            // Show loading state
                            submitBtn.disabled = true;
                            btnText.classList.add('d-none');
                            btnSpinner.classList.remove('d-none');
                            messageDiv.innerHTML = '';

                            // Collect form data
                            const formData = new FormData(quoteForm);

                            // Send AJAX request
                            fetch('{{ route("quote.send") }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    // Hide loading state
                                    submitBtn.disabled = false;
                                    btnText.classList.remove('d-none');
                                    btnSpinner.classList.add('d-none');

                                    if (data.success) {
                                        // Show success message
                                        messageDiv.innerHTML = `
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <i class="fa fa-check-circle me-2"></i>${data.message}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    `;

                                        // Reset form
                                        quoteForm.reset();

                                        // Auto-hide success message after 5 seconds
                                        setTimeout(() => {
                                            const alert = messageDiv.querySelector('.alert');
                                            if (alert) {
                                                const bsAlert = new bootstrap.Alert(alert);
                                                bsAlert.close();
                                            }
                                        }, 5000);
                                    } else {
                                        // Show error message
                                        messageDiv.innerHTML = `
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fa fa-exclamation-triangle me-2"></i>${data.message || 'Ocurrió un error al enviar el formulario.'}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    `;
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);

                                    // Hide loading state
                                    submitBtn.disabled = false;
                                    btnText.classList.remove('d-none');
                                    btnSpinner.classList.add('d-none');

                                    // Show error message
                                    messageDiv.innerHTML = `
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fa fa-exclamation-triangle me-2"></i>Error de conexión. Por favor, intente nuevamente.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                `;
                                });
                        });
                    });
                </script>
</body>

</html>