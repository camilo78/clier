<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-r dark:border-neutral-800">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('img/auth-bg.jpg') }}')"></div>
             
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium">
                    @php $companyInfo = \App\Models\CompanyInfo::first(); @endphp
                    @if($companyInfo && $companyInfo->logo)
                        <img src="{{ $companyInfo->logo ? (str_starts_with($companyInfo->logo, 'img/') ? asset($companyInfo->logo) : asset('storage/' . $companyInfo->logo)) : asset('img/logo.png') }}" alt="{{ $companyInfo->name }}" class="h-10 w-auto">
                    @else
                        <span class="flex h-10 w-10 items-center justify-center rounded-md">
                            <x-app-logo-icon class="h-7 fill-current text-white" />
                        </span>
                    @endif
                </a>

                @php
                    $quotes = [
                        'El éxito es ir de fracaso en fracaso sin perder el entusiasmo. - Winston Churchill',
                        'La única forma de hacer un gran trabajo es amar lo que haces. - Steve Jobs',
                        'No esperes por el momento perfecto, toma el momento y hazlo perfecto. - Zoey Sayward',
                        'El futuro pertenece a quienes creen en la belleza de sus sueños. - Eleanor Roosevelt',
                        'La vida es lo que pasa mientras estás ocupado haciendo otros planes. - John Lennon',
                        'No cuentes los días, haz que los días cuenten. - Muhammad Ali',
                        'La mejor venganza es un éxito masivo. - Frank Sinatra',
                        'Si puedes soñarlo, puedes hacerlo. - Walt Disney',
                        'El camino hacia el éxito y el camino hacia el fracaso son casi exactamente el mismo. - Colin R. Davis',
                        'No tengas miedo de renunciar a lo bueno para ir por lo grandioso. - John D. Rockefeller',
                        'La innovación distingue entre un líder y un seguidor. - Steve Jobs',
                        'El éxito no es definitivo, el fracaso no es fatal: es el coraje para continuar lo que cuenta. - Winston Churchill',
                        'Tu tiempo es limitado, no lo desperdicies viviendo la vida de alguien más. - Steve Jobs',
                        'La manera de empezar es dejar de hablar y empezar a hacer. - Walt Disney',
                        'Si no construyes tu sueño, alguien más te contratará para construir el suyo. - Dhirubhai Ambani',
                        'El pesimista ve dificultad en cada oportunidad. El optimista ve oportunidad en cada dificultad. - Winston Churchill',
                        'No es el más fuerte de las especies el que sobrevive, sino el más adaptable al cambio. - Charles Darwin',
                        'La única manera de hacer un trabajo excelente es amar lo que haces. - Steve Jobs',
                        'El éxito es la suma de pequeños esfuerzos repetidos día tras día. - Robert Collier',
                        'La diferencia entre lo ordinario y lo extraordinario es ese pequeño extra. - Jimmy Johnson'
                    ];
                    [$message, $author] = str(collect($quotes)->random())->explode(' - ');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <p class="text-lg text-black italic">&ldquo;{{ trim($message) }}&rdquo;</p>
                        <footer class="text-sm text-black">{{ trim($author) }}</footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden">
                        @php $companyInfo = \App\Models\CompanyInfo::first(); @endphp
                        @if($companyInfo && $companyInfo->logo)
                            <img src="{{ $companyInfo->logo ? (str_starts_with($companyInfo->logo, 'img/') ? asset($companyInfo->logo) : asset('storage/' . $companyInfo->logo)) : asset('img/logo.png') }}" alt="{{ $companyInfo->name }}" class="h-9 w-auto">
                            <span class="sr-only">{{ $companyInfo->name }}</span>
                        @else
                            <span class="flex h-9 w-9 items-center justify-center rounded-md">
                                <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                            </span>
                            <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                        @endif
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
