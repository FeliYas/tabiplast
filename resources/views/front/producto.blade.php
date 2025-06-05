@extends('layouts.guest')
@if ($producto->adword)
    @section('meta')
        <meta property="og:title" content="{{$producto->adword}}"/>
    @endsection
@endif
@section('title', __('Producto'))

@section('content')
    <div>
        <div class="hidden lg:block overflow-hidden">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black flex gap-1 text-xs mt-6">
                <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                <span class="font-bold">></span>
                <a href="{{ route('categorias') }}" class="font-bold hover:underline">{{ __('Productos') }}</a>
                <span class="font-bold">></span>
                <a href="{{ route('productos', ['id' => $producto->categoria->id]) }}"
                    class="font-bold hover:underline">{{ $producto->categoria->titulo }}</a>
                <span>></span>
                <a href="{{ route('producto', ['id' => $producto->id]) }}"
                    class="hover:underline">{{ $producto->titulo }}</a>
            </div>
        </div>
        <!-- Main content with sidebar and product detail -->
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto flex flex-col lg:flex-row gap-6 lg:py-15">
            <!-- Sidebar (1/4 width) -->
            <div class="w-full lg:w-1/4 text-black mt-6 lg:mt-0">
                <h2 class="font-bold text-xl border-b border-gray-200">{{ __('Productos') }}</h2>
                <div class="py-2">
                    @foreach ($categorias as $cat)
                        <a href="{{ route('productos', ['id' => $cat->id]) }}"
                            class="block py-1 hover:bg-gray-100 hover:pl-3 transition-all duration-300 ease-in-out{{ request('id') == $cat->id ? ' font-bold' : '' }}">
                            {{ $cat->titulo }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Product Detail (3/4 width) -->
            <div class="w-full lg:w-3/4">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image Gallery -->
                    <div class="w-full md:w-[392px]">
                        <div class="mb-4 flex items-center justify-center">
                            @if ($producto->imagenes->first())
                                <img id="mainImage" src="{{ asset($producto->imagenes->first()->path) }}"
                                    alt="{{ $producto->titulo }}"
                                    class="w-full md:w-[392px] h-[392px] border border-gray-200 rounded-[10px] object-contain transition-opacity duration-300 ease-in-out px-4 py-2">
                            @else
                                <div
                                    class="w-full md:w-[392px] h-[392px] bg-gray-100 text-gray-400 flex items-center justify-center transition-opacity duration-300 ease-in-out">
                                    <span class="text-sm">{{ __('Sin imagen disponible') }}</span>
                                </div>
                            @endif
                        </div>
                        <div id="thumbnailContainer" class="flex lg:justify-start justify-center gap-4 overflow-x-auto">
                            @foreach ($producto->imagenes as $imagen)
                                <div class="border border-gray-200 w-[80px] h-[80px] rounded-[10px] cursor-pointer hover:border-red-500 p-0.5 flex-shrink-0 {{ $loop->first ? 'active-thumbnail' : '' }}"
                                    onclick="changeMainImage('{{ asset($imagen->path) }}', this)"> <img
                                        src="{{ asset($imagen->path) }}" alt="{{ __('Thumbnail') }}"
                                        class="w-full h-full object-contain">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="w-full lg:w-3/5 text-black lg:h-[280px] flex flex-col lg:justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase text-main-color">{{ $producto->categoria->titulo }}</p>
                            <h1 class="text-[28px] font-bold border-b border-gray-200">{{ $producto->titulo }}</h1>
                            <div class="prose max-w-none custom-summernote mt-4 lg:h-[345px]">
                                {!! $producto->descripcion !!}
                            </div>
                        </div>
                        <div class="flex flex-col justify-end mt-6 lg:mt-0">
                            @if ($producto->ficha)
                                <div class="flex items-center justify-center gap-6"> <a
                                        href="{{ asset($producto->ficha) }}" download="{{ basename($producto->ficha) }}"
                                        class="btn-secondary w-[150px] lg:w-[243px] font-semibold">
                                        {{ __('Ficha técnica') }}
                                    </a>
                                    <a href="{{ route('presupuesto') }}" class="btn-primary w-[150px] lg:w-[243px] font-semibold">
                                        {{ __('Consultar') }}
                                    </a>
                                </div>
                            @else
                                <div class="flex gap-6">
                                    <a href="{{ route('presupuesto') }}"
                                        class="btn-primary w-full w-[150px] lg:w-[243px] font-semibold">
                                        {{ __('Consultar') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($producto->colocaciones->isNotEmpty())
                    <div class="py-20 text-black">
                        <h2 class="text-2xl font-bold mb-4">{{ __('Colocación') }}</h2>
                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                            @foreach ($producto->colocaciones as $colocacion)
                                <div class="flex flex-col">
                                    <img src="{{ asset($colocacion->path) }}" alt="{{ $colocacion->titulo }}"
                                        class="w-full h-[210px] object-cover border border-gray-200 rounded-[10px] p-1 mb-2">
                                    <p class="text-xl font-bold">{{ $colocacion->titulo }}</p>
                                    <div class="prose max-w-none custom-summernote">
                                        {!! $colocacion->descripcion !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($producto->video)
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-black">{{ __('Video tutorial') }}</h2>
                        <div class="relative flex items-center w-full rounded-[10px] overflow-hidden group">
                            <div class="relative" style="width:fit-content;max-width:100%;">
                                <video id="productoVideo" src="{{ $producto->video }}"
                                    class="h-[250px] max-w-full object-contain rounded-[10px] bg-black"
                                    style="aspect-ratio: 16/9; display:block;" preload="none"></video>
                                <div id="videoOverlay"
                                    class="absolute inset-0 bg-black bg-opacity-60 flex items-center rounded-[10px] justify-center transition-opacity duration-500 z-10 cursor-pointer"
                                    style="width:100%;height:100%;">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"
                                            viewBox="0 0 80 80" fill="none">
                                            <path
                                                d="M39.9998 73.3333C58.4093 73.3333 73.3332 58.4094 73.3332 40C73.3332 21.5905 58.4093 6.66663 39.9998 6.66663C21.5903 6.66663 6.6665 21.5905 6.6665 40C6.6665 58.4094 21.5903 73.3333 39.9998 73.3333Z"
                                                stroke="white" stroke-width="4" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M33.3332 26.6666L53.3332 40L33.3332 53.3333V26.6666Z" stroke="white"
                                                stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const video = document.getElementById('productoVideo');
                                const overlay = document.getElementById('videoOverlay');
                                if (video && overlay) {
                                    video.removeAttribute('controls');
                                    overlay.addEventListener('click', function() {
                                        overlay.style.opacity = 0;
                                        setTimeout(() => overlay.style.display = 'none', 500);
                                        video.setAttribute('controls', 'controls');
                                        video.play();
                                    });
                                    // Si el usuario pausa el video, vuelve a mostrar el overlay (opcional)
                                    // video.addEventListener('pause', function () {
                                    //     overlay.style.display = 'flex';
                                    //     overlay.style.opacity = 1;
                                    //     video.removeAttribute('controls');
                                    // });
                                }
                            });
                        </script>
                    </div>
                @endif
                @if ($productosRelacionados->isNotEmpty())
                    <div class="pt-19">
                        <h2 class="text-2xl text-black font-bold mb-4">{{ __('Productos relacionados') }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($productosRelacionados as $prodRelacionado)
                                <a href="{{ route('producto', ['id' => $prodRelacionado->id]) }}"
                                    class="h-[422px] rounded-[10px] border border-gray-200 block transition-transform duration-300 hover:shadow-xl hover:-translate-y-1 transform">
                                    <img src="{{ $prodRelacionado->imagenes->first()->path }}"
                                        alt="{{ $prodRelacionado->titulo }}"
                                        class="w-full h-[288px] object-cover rounded-t-[10px] p-1 transition-transform duration-300 hover:scale-105">
                                    <hr class="border-t-[1.5px] border-gray-200 mx-4.5">
                                    <div class="p-3.5 flex flex-col gap-2.5">
                                        <p class="text-main-color font-bold uppercase line-clamp-1">
                                            {{ $prodRelacionado->categoria->titulo }}
                                        </p>
                                        <h3 class="font-bold text-lg line-clamp-2 text-black max-w-3/4">
                                            {{ $prodRelacionado->titulo }}
                                        </h3>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function changeMainImage(src, thumbnail) {

            const video = document.getElementById('productoVideo');
            const overlay = document.getElementById('videoOverlay');
            // Oculta controles hasta que se hace play
            video.removeAttribute('controls');
            overlay.addEventListener('click', function() {
                overlay.style.opacity = 0;
                setTimeout(() => overlay.style.display = 'none', 500);
                video.setAttribute('controls', 'controls');
                video.play();
            });
            // Si el usuario pausa el video, vuelve a mostrar el overlay (opcional)
            video.addEventListener('pause', function() {
                overlay.style.display = 'flex';
                overlay.style.opacity = 1;
                video.removeAttribute('controls');
            });

            const mainImage = document.getElementById('mainImage');

            // Fade out effect
            mainImage.style.opacity = '0';

            // Change image after fade out completes
            setTimeout(() => {
                mainImage.src = src;

                // Fade in the new image
                mainImage.style.opacity = '1';

                // Update thumbnail active state
                document.querySelectorAll('#thumbnailContainer > div').forEach(thumb => {
                    thumb.classList.remove('active-thumbnail');
                });
                thumbnail.classList.add('active-thumbnail');
            }, 300);
        }

        // Ensure image is visible on initial load
        document.addEventListener('DOMContentLoaded', () => {
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '1';
        });
    </script>

    <style>
        #mainImage {
            opacity: 0;
        }

        .active-thumbnail {
            border-color: #c87800 !important;
        }
    </style>
@endsection
