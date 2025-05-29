@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Aplicaciones'))

@section('content')
    <div>
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('aplicaciones') }}" class="hover:underline">{{ __('APLICACIONES') }}</a>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-10 mt-6">
            <div class="grid lg:grid-cols-3 gap-6">
                @foreach ($aplicaciones as $aplicacion)
                    <a href="{{ route('aplicacion', ['id' => $aplicacion->id]) }}"
                        class="relative transition-transform transform hover:-translate-y-1 duration-300 shadow-lg hover:shadow-xl">
                        <img src="{{ $aplicacion->path }}"
                            alt="{{ __('Aplicación') }} {{ getLocalizedField($aplicacion, 'titulo') }}"
                            class="w-full h-[242px] object-cover rounded-[10px] bg-black">
                        <span class="absolute inset-0 bg-black opacity-30 rounded-[10px]"></span>
                        <h3 class="absolute inset-0 flex items-center justify-center font-semibold text-2xl">
                            {{ getLocalizedField($aplicacion, 'titulo') }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
