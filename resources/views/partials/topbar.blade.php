<!-- Topbar Start -->
<div class="container-fluid bg-dark text-white-50 py-2 px-0 d-none d-lg-block">
    <div class="row gx-0 align-items-center">
        <div class="col-lg-7 px-5 text-start">
            @if(isset($companyInfo) && $companyInfo)
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="fa fa-phone-alt me-2"></small>
                <small>{{ $companyInfo->phone }}</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center me-4">
                <small class="far fa-envelope-open me-2"></small>
                <small>{{ $companyInfo->email }}</small>
            </div>
            @endif
        </div>
        <div class="col-lg-5 px-5 text-end">
            <ol class="breadcrumb justify-content-end mb-0">
                <li class="breadcrumb-item"><a class="text-white-50 small" href="{{ route('login') }}">{{ __('Inicia Sesión') }}</a></li>
                {{-- Registro deshabilitado - solo admins pueden crear usuarios --}}
                {{-- <li class="breadcrumb-item"><a class="text-white-50 small" href="{{ route('register') }}">{{ __('Registrate') }}</a></li> --}}
            </ol>
        </div>
    </div>
</div>
<!-- Topbar End -->