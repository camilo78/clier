    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center">
            @if($companyInfo)
            <h1 class="m-0"><img class="img-fluid me-3" src="{{ $companyInfo->logo ? asset('storage/' . $companyInfo->logo) : asset('img/logo.png') }}" alt=""></h1>
            @else
            <h1 class="m-0"><img class="img-fluid me-3" src="{{ asset('img/logo.png') }}" alt="">AirCon</h1>
            @endif
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto bg-light pe-4 py-3 py-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link">Inicio</a>
                <a href="{{ route('home') }}#nosotros" class="nav-item nav-link">Nosotros</a>
                <a href="{{ route('home') }}#servicios" class="nav-item nav-link">Nuestros Servicios</a>
                <a href="{{ route('home') }}#equipo" class="nav-item nav-link">Nuestro Equipo</a>               
                <a href="{{ route('contact') }}" class="nav-item nav-link active">Contáctanos</a>
            </div>
             @include('partials.social-links')
        </div>
    </nav>
    <!-- Navbar End -->