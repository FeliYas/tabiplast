@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Calidad'))

@section('content')
    <div class="relative">
        <!-- Breadcrumb fijo -->
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('calidad') }}" class="hover:underline">{{ __('CALIDAD') }}</a>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-10 lg:py-26 flex flex-col lg:flex-row gap-14">
            <div class="flex flex-col gap-4 text-black py-8">
                <h2 class="text-2xl font-semibold">{{ getLocalizedField($calidad, 'titulo') }}</h2>
                <div class="custom-summernote font-light text-black leading-5 text-[17px]">
                    <p>{!! getLocalizedField($calidad, 'descripcion') !!}</p>
                </div>
            </div>
            <img src="{{ $calidad->path }}" alt="{{ __('Imagen de calidad') }}"
                class="lg:w-1/2 h-[394px] object-cover rounded-[10px]">
        </div>
    </div>

@endsection
