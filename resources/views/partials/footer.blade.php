<!-- Footer Start -->
<div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-1">
        <div class="row g-5">
            <div class="col-md-6">
                @if(isset($companyInfo) && $companyInfo)
                <img class="img-fluid me-3 mb-4" width="175px" style="filter: brightness(0) invert(1);" src="{{ $companyInfo->logo ? asset('storage/' . $companyInfo->logo) : asset('img/logo.png') }}" alt="">
                <p>{{ $companyInfo->description }}</p>
                @else
                <h1 class="text-white mb-4"><img class="img-fluid me-3" src="{{ asset('img/logo.png') }}" alt="">AirCon</h1>
                <span>Descripción de la empresa</span>
                @endif
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Ponte en Contacto</h5>
                <p><i class="fa fa-map-marker-alt me-3"></i>{{ isset($companyInfo) ? ($companyInfo->address ?? 'Dirección') : 'Dirección' }}</p>
                <p>
                @if(isset($companyInfo) && $companyInfo->phone)
                    @foreach(explode('|', $companyInfo->phone) as $phone)
                        <i class="fa fa-phone-alt me-3"></i>{{trim($phone)}}<br>
                    @endforeach
                @else
                    Teléfono
                @endif
                </p>
                <p><i class="fa fa-envelope me-3"></i>{{ isset($companyInfo) ? ($companyInfo->email ?? 'Email') : 'Email' }}</p>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-light mb-4">Enlaces Rápidos</h5>
                <a class="btn btn-link" href="{{ route('home') }}">Inicio</a>
                <a class="btn btn-link" href="{{ route('home') }}#nosotros">Nosotros</a>
                <a class="btn btn-link" href="{{ route('home') }}#servicios">Servicios</a>
                <a class="btn btn-link" href="{{ route('contact') }}">Contacto</a>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; {{ date('Y') }} <a href="#">{{ isset($companyInfo) ? ($companyInfo->name ?? 'Clier') : 'Clier' }}</a>, Todos los Derechos Reservados.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    Diseñado Por <a href="#">Emprende en la Web.</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->