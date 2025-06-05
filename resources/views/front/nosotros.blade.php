@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Nosotros'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('nosotros') }}" class="hover:underline">{{ __('Nosotros') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class=" font-bold text-[40px]">{{ __('Nosotros') }}</h2>
                </div>
            </div>
            <img src="{{ $nosotros->banner }}" alt="{{ __('Banner de Nosotros') }}" class="w-full h-[310px] object-cover">
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20 flex flex-col lg:flex-row gap-10.5">
            <div class="flex flex-col gap-4 lg:w-1/2 text-black">
                <h2 class="font-bold text-[32px]">{{ $nosotros->titulo }}</h2>
                <div class="custom-summernote leading-6">
                    <p>{!! $nosotros->descripcion !!}</p>
                </div>
            </div>
            <img src="{{ $nosotros->path }}" alt="{{ __('Imagen de Nosotros') }}"
                class="lg:w-1/2 h-[450px] rounded-[10px] object-cover">
        </div>
        <div class="bg-gray-100">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto pb-16">
                <div class="flex flex-col gap-6 py-15">
                    <h2 class="text-black text-[32px] font-bold">{{ __('¿Por qué elegirnos?') }}</h2>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        @foreach ($tarjetas as $tarjeta)
                            <x-tarjeta-nosotros :tarjeta="$tarjeta" />
                        @endforeach
                    </div>
                </div>
                <div class="relative w-full h-[688px] rounded-[10px] overflow-hidden group">
                    <video id="nosotrosVideo" src="{{ $nosotros->video }}"
                        class="w-full h-full object-cover rounded-[10px]" style="display:block;" preload="none"></video>
                    <div id="videoOverlay"
                        class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center transition-opacity duration-500 z-10 cursor-pointer">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                fill="none">
                                <path
                                    d="M39.9998 73.3333C58.4093 73.3333 73.3332 58.4094 73.3332 40C73.3332 21.5905 58.4093 6.66663 39.9998 6.66663C21.5903 6.66663 6.6665 21.5905 6.6665 40C6.6665 58.4094 21.5903 73.3333 39.9998 73.3333Z"
                                    stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M33.3332 26.6666L53.3332 40L33.3332 53.3333V26.6666Z" stroke="white"
                                    stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const video = document.getElementById('nosotrosVideo');
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
                        // video.addEventListener('pause', function () {
                        //     overlay.style.display = 'flex';
                        //     overlay.style.opacity = 1;
                        //     video.removeAttribute('controls');
                        // });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
