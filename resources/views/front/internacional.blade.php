@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Internacional'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('internacional') }}" class="hover:underline">{{ __('Internacional') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class=" font-bold text-[40px]">{{ __('Internacional') }}</h2>
                </div>
            </div>
            <img src="{{ $internacional->banner }}" alt="{{ __('Banner de internacional') }}"
                class="w-full h-[310px] object-cover">
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20 flex flex-col lg:flex-row gap-10.5">
            <img src="{{ $internacional->path }}" alt="{{ __('Imagen de Internacional') }}"
                class="lg:w-1/2 h-[450px] rounded-[10px] object-cover">
            <div class="flex flex-col justify-between lg:w-1/2 text-black">
                <div class="flex flex-col gap-4">
                    <h2 class="font-bold text-[32px]">{{ $internacional->titulo }}</h2>
                    <div class="custom-summernote leading-6">
                        <p>{!! $internacional->descripcion !!}</p>
                    </div>
                </div>
                <a href="{{ route('contacto') }}" class="btn-primary w-[236px] mt-6 lg:mt-0 mb-6">Consultar</a>
            </div>
        </div>
    </div>
@endsection
