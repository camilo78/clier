{{-- Meta Tags Básicos --}}
@if(!empty($metaTags['title']))
    <title>{{ $metaTags['title'] }}</title>
@endif

@if(!empty($metaTags['description']))
    <meta name="description" content="{{ $metaTags['description'] }}">
@endif

@if(!empty($metaTags['keywords']))
    <meta name="keywords" content="{{ $metaTags['keywords'] }}">
@endif

@if(!empty($metaTags['robots']))
    <meta name="robots" content="{{ $metaTags['robots'] }}">
@endif

@if(!empty($metaTags['canonical']))
    <link rel="canonical" href="{{ $metaTags['canonical'] }}">
@endif

{{-- Favicon --}}
@if(!empty($favicon))
    <link rel="icon" type="image/x-icon" href="{{ $favicon }}">
    <link rel="shortcut icon" href="{{ $favicon }}">
@endif

{{-- Theme Color --}}
@if(!empty($brandColors['primary']))
    <meta name="theme-color" content="{{ $brandColors['primary'] }}">
    <meta name="msapplication-TileColor" content="{{ $brandColors['primary'] }}">
@endif

{{-- Verificaciones de Motores de Búsqueda --}}
@if(!empty($metaTags['google_site_verification']))
    <meta name="google-site-verification" content="{{ $metaTags['google_site_verification'] }}">
@endif

@if(!empty($metaTags['bing_site_verification']))
    <meta name="msvalidate.01" content="{{ $metaTags['bing_site_verification'] }}">
@endif

{{-- Open Graph Tags --}}
@if(!empty($metaTags['og_title']))
    <meta property="og:title" content="{{ $metaTags['og_title'] }}">
@endif

@if(!empty($metaTags['og_description']))
    <meta property="og:description" content="{{ $metaTags['og_description'] }}">
@endif

@if(!empty($metaTags['og_image']))
    <meta property="og:image" content="{{ $metaTags['og_image'] }}">
@endif

@if(!empty($metaTags['og_type']))
    <meta property="og:type" content="{{ $metaTags['og_type'] }}">
@endif

@if(!empty($metaTags['og_url']))
    <meta property="og:url" content="{{ $metaTags['og_url'] }}">
@endif

<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta property="og:site_name" content="{{ config('app.name') }}">

{{-- Twitter Card Tags --}}
@if(!empty($metaTags['twitter_card']))
    <meta name="twitter:card" content="{{ $metaTags['twitter_card'] }}">
@endif

@if(!empty($metaTags['twitter_site']))
    <meta name="twitter:site" content="{{ $metaTags['twitter_site'] }}">
@endif

@if(!empty($metaTags['twitter_title']))
    <meta name="twitter:title" content="{{ $metaTags['twitter_title'] }}">
@endif

@if(!empty($metaTags['twitter_description']))
    <meta name="twitter:description" content="{{ $metaTags['twitter_description'] }}">
@endif

@if(!empty($metaTags['twitter_image']))
    <meta name="twitter:image" content="{{ $metaTags['twitter_image'] }}">
@endif

{{-- Datos Estructurados (JSON-LD) --}}
@if(!empty($structuredData))
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif

{{-- Datos Estructurados de la Organización --}}
@if(!empty($organizationData))
    <script type="application/ld+json">
        {!! json_encode($organizationData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif

{{-- Google Analytics --}}
@if(!empty($trackingScripts['google_analytics_id']))
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $trackingScripts['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $trackingScripts['google_analytics_id'] }}');
    </script>
@endif

{{-- Google Tag Manager --}}
@if(!empty($trackingScripts['google_tag_manager_id']))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtag/js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{{ $trackingScripts['google_tag_manager_id'] }}');</script>
    <!-- End Google Tag Manager -->
@endif

{{-- Facebook Pixel --}}
@if(!empty($trackingScripts['facebook_pixel_id']))
    <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ $trackingScripts['facebook_pixel_id'] }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id={{ $trackingScripts['facebook_pixel_id'] }}&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
@endif
