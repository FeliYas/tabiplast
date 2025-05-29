@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection
@section('title', __('Productos'))

@section('content')
    <div>
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('productos') }}" class="hover:underline">{{ __('PRODUCTOS') }}</a>
                </div>
            </div>
        </div>
        <!-- Main content with sidebar and products -->
        <div class="flex flex-col lg:flex-row gap-6 lg:py-30 lg:mb-27 max-w-[90%] lg:max-w-[1224px] mx-auto">
            <div class="w-full lg:w-1/4">
                <div class="border-gray-200 text-black">
                    @foreach ($categorias as $cat)
                        <a href="{{ route('productos', ['id' => $cat->id]) }}"
                            class="block py-3 px-2 border-b border-gray-200 hover:bg-gray-100 hover:pl-3 transition-all duration-300 ease-in-out text-[15px] font-semibold">
                            {{ getLocalizedField($cat, 'titulo') }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="w-full lg::w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-4 lg:py-0">
                    @forelse($productos as $producto)
                        <div class="transition-transform transform hover:-translate-y-1 duration-300 h-[282px]">
                            <a href="{{ route('producto', ['id' => $producto->id]) }}">
                                @if ($producto->imagenes->count() > 0)
                                    <img src="{{ $producto->imagenes->first()->path }}"
                                        alt="{{ getLocalizedField($producto, 'titulo') }}"
                                        class="border border-gray-200 overflow-hidden bg-white w-full h-[229px] object-contain transition-transform duration-500 hover:scale-105 px-5 py-3">
                                @else
                                    <div
                                        class="w-full h-72 bg-gray-100 flex items-center justify-center text-gray-500 transition-colors duration-300 hover:text-gray-700">
                                        <span>{{ __('Sin imagen') }}</span>
                                    </div>
                                @endif
                                <div class="py-2 transition-colors duration-300 hover:bg-gray-50">
                                    <p class="text-gray-800 transition-colors duration-300 line-clamp-2 text-[17px]">
                                        {{ getLocalizedField($producto, 'titulo') }}
                                    </p>
                                </div>
                            </a>
                    </div> @empty
                        <div class="col-span-3 py-8 text-center text-gray-500">
                            {{ __('No hay productos disponibles en esta categoría.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
