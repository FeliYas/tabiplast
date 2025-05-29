@extends('layouts.guest')
@section('title', __('Aplicaciones'))

@section('content')
    <div>
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1 ">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('aplicaciones') }}" class="hover:underline">{{ __('APLICACIONES') }}</a>
                    <span>|</span>
                    <a href="{{ route('aplicacion', ['id' => $aplicacion->id]) }}"
                        class="hover:underline">{{ getLocalizedField($aplicacion, 'titulo') }}</a>
                </div>
            </div>
        </div>
        <div class="lg:mt-[36px]">
            <div class="relative">
                <img src="{{ $aplicacion->path }}" alt="{{ __('banner') }}" class="w-full h-[300px] object-cover">
                <span class="absolute inset-0 bg-black opacity-50"></span>
                <h3 class="absolute inset-0 max-w-[90%] lg:max-w-[1224px] mx-auto flex items-center font-semibold text-2xl">
                    {{ getLocalizedField($aplicacion, 'titulo') }}</h3>
            </div>
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20">
                <div class="grid lg:grid-cols-3 gap-6">
                    @forelse($productos as $producto)
                        <div class="transition-transform transform hover:-translate-y-1 duration-300 h-[282px]">
                            <a href="{{ route('producto', ['id' => $producto->id]) }}">
                                @if ($producto->imagenes->count() > 0)
                                    <img src="{{ $producto->imagenes->first()->path }}" alt="{{ $producto->titulo }}"
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
                            {{ __('No hay productos disponibles en esta aplicación.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
