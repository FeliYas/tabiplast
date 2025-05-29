@extends('layouts.guest')
@section('title', __('Producto'))

@section('content')
    <div>
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('productos') }}" class="hover:underline">{{ __('PRODUCTOS') }}</a>
                    <span>|</span>
                    <a href="{{ route('producto', ['id' => $producto->id]) }}"
                        class="hover:underline">{{ getLocalizedField($producto, 'titulo') }}</a>
                </div>
            </div>
        </div>
        <!-- Main content with sidebar and product detail -->
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto flex flex-col lg:flex-row gap-6 lg:py-30">
            <!-- Sidebar (1/4 width) -->
            <div class="w-full md:w-1/4 block">
                <div class="border-t border-gray-200 text-black">
                    @foreach ($categorias as $cat)
                        <a href="{{ route('productos', ['id' => $cat->id]) }}"
                            class="block py-3 px-2 border-b border-gray-200 hover:bg-gray-100 transition 
                                  {{ $cat->id == $producto->categoria_id ? 'font-bold bg-gray-50' : '' }}">
                            {{ getLocalizedField($cat, 'titulo') }}
                            @if ($cat->productos_count)
                                <span class="ml-1 px-2 py-1 bg-red-500 text-white text-xs rounded-full">
                                    {{ $cat->productos_count }}
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Product Detail (3/4 width) -->
            <div class="w-full md:w-3/4">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image Gallery -->
                    <div class="w-full md:w-1/2">
                        <!-- Main Image -->
                        <div class="mb-6 flex items-center justify-center">
                            @if ($producto->imagenes->first())
                                <img id="mainImage" src="{{ asset($producto->imagenes->first()->path) }}"
                                    alt="{{ getLocalizedField($producto, 'titulo') }}"
                                    class="w-full h-[280px] border border-gray-200 rounded-[10px] object-contain transition-opacity duration-300 ease-in-out px-4 py-2">
                            @else
                                <div
                                    class="w-full h-[400px] bg-gray-100 text-gray-400 flex items-center justify-center transition-opacity duration-300 ease-in-out">
                                    <span class="text-sm">{{ __('Sin imagen disponible') }}</span>
                                </div>
                            @endif
                        </div> <!-- Thumbnails -->
                        <div id="thumbnailContainer" class="flex lg:justify-start justify-center gap-2 overflow-x-auto">
                            @foreach ($producto->imagenes as $imagen)
                                <div class="border border-gray-200 w-[73px] h-[76px] rounded-[10px] cursor-pointer hover:border-red-500 p-3 flex-shrink-0 {{ $loop->first ? 'active-thumbnail' : '' }}"
                                    onclick="changeMainImage('{{ asset($imagen->path) }}', this)"> <img
                                        src="{{ asset($imagen->path) }}" alt="{{ __('Thumbnail') }}"
                                        class="w-full h-full object-contain">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="w-full md:w-1/2 text-black lg:h-[280px] flex flex-col lg:justify-between">
                        <div>
                            <h1 class="text-[28px] font-semibold ">{{ getLocalizedField($producto, 'titulo') }}</h1>
                            <div class="prose max-w-none custom-summernote mt-4">
                                {!! getLocalizedField($producto, 'descripcion') !!}
                            </div>
                        </div>
                        <div class="flex flex-col justify-end mt-10 lg:mt-0">
                            @if ($producto->ficha)
                                <div class="flex items-center justify-center gap-6"> <a
                                        href="{{ asset($producto->ficha) }}" download="{{ basename($producto->ficha) }}"
                                        class="btn-primary">
                                        {{ __('FICHA TECNICA') }}
                                    </a>
                                    <a href="{{ route('contacto') }}" class="btn-primary">
                                        {{ __('CONSULTAR') }}
                                    </a>
                                </div>
                            @else
                                <div class="flex gap-6">
                                    <a href="{{ route('contacto') }}" class="btn-primary w-full lg:w-[243px]">
                                        {{ __('CONSULTAR') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Productos relacionados -->
                @if ($productosRelacionados->isNotEmpty())
                    <div class="pt-12">
                        <h2 class="text-xl text-black font-semibold mb-5">{{ __('PRODUCTOS RELACIONADOS') }}</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach ($productosRelacionados as $prodRelacionado)
                                <div class="transition-transform transform hover:-translate-y-1 duration-300 h-[282px]">
                                    <a href="{{ route('producto', ['id' => $prodRelacionado->id]) }}">
                                        @if ($prodRelacionado->imagenes->count() > 0)
                                            <img src="{{ $prodRelacionado->imagenes->first()->path }}"
                                                alt="{{ getLocalizedField($prodRelacionado, 'titulo') }}"
                                                class="border border-gray-200 overflow-hidden bg-white w-full h-[229px] object-contain transition-transform duration-500 hover:scale-105 px-5 py-3">
                                        @else
                                            <div
                                                class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-500 transition-colors duration-300 hover:text-gray-700">
                                                <span>{{ __('Sin imagen') }}</span>
                                            </div>
                                        @endif
                                        <div class="py-2 transition-colors duration-300 hover:bg-gray-50">
                                            <p
                                                class="text-gray-800 transition-colors duration-300 line-clamp-2 text-[17px]">
                                                {{ getLocalizedField($prodRelacionado, 'titulo') }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function changeMainImage(src, thumbnail) {
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
            border-color: #E12328 !important;
        }
    </style>
@endsection
