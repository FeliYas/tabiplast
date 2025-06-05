@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Productos'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('categorias') }}" class="hover:underline">{{ __('Productos') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class=" font-bold text-[40px]">{{ __('Productos') }}</h2>
                </div>
            </div>
            <img src="{{ $banner->path }}" alt="{{ __('Banner de productos') }}" class="w-full h-[310px] object-cover">
        </div>
        <div class="py-20 grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-[90%] lg:max-w-[1224px] mx-auto">
            @foreach ($categorias as $categoria)
                <a href="{{ route('productos', $categoria->id) }}"
                    class="relative overflow-hidden rounded-[20px] shadow-lg hover:shadow-xl transition-transform duration-300 ease-in-out flex items-center justify-center translate-y-0 hover:translate-y-[-5px]">
                    <img src="{{ $categoria->path }}" alt="{{ $categoria->titulo }}">
                    <div class="absolute inset-0 bg-black opacity-20"></div>
                    <h3 class="absolute bottom-8 font-bold text-2xl text-white">{{ $categoria->titulo }}</h3>
                </a>
            @endforeach
        </div>
    </div>
@endsection
