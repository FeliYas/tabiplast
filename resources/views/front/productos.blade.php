@extends('layouts.guest')
@section('title', __('Productos'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black flex gap-1 text-xs mt-6">
                <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                <span class="font-bold">></span>
                <a href="{{ route('categorias') }}" class="font-bold hover:underline">{{ __('Productos') }}</a>
                <span>></span>
                <a href="{{ route('productos', ['id' => $categoria->id]) }}" class="hover:underline">{{ $categoria->titulo }}</a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6 lg:py-15 lg:mb-27 max-w-[90%] lg:max-w-[1224px] mx-auto mt-6 lg:mt-0">
            <div class="w-full lg:w-1/4 text-black">
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

            <div class="w-full lg::w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-4 lg:py-0">
                    @forelse($productos as $producto)
                        <a href="{{ route('producto', ['id' => $producto->id]) }}"
                            class="h-[422px] rounded-[10px] border border-gray-200 block transition-transform duration-300 hover:shadow-xl hover:-translate-y-1 transform">
                            <img src="{{ $producto->imagen }}" alt="{{ $producto->titulo }}"
                                class="w-full h-[288px] object-cover rounded-t-[10px] p-1 transition-transform duration-300 hover:scale-105">
                            <hr class="border-t-[1.5px] border-gray-200 mx-4.5">
                            <div class="p-3.5 flex flex-col gap-2.5">
                                <p class="text-main-color font-bold uppercase line-clamp-1">
                                    {{ $producto->categoria->titulo }}
                                </p>
                                <h3 class="font-bold text-lg line-clamp-2 text-black max-w-3/4">{{ $producto->titulo }}
                                </h3>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-3 py-8 text-center text-gray-500">
                            {{ __('No hay productos disponibles en esta categoría.') }}
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
