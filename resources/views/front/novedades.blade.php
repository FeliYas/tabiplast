@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Novedades'))

@section('content')
    <div class="relative">
        <!-- Breadcrumb fijo -->
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('novedades') }}" class="hover:underline">{{ __('NOVEDADES') }}</a>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-9 lg:mt-9 grid lg:grid-cols-3 gap-6">
            @foreach ($novedades as $novedad)
                <x-tarjeta-novedades :novedad="$novedad" />
            @endforeach
        </div>
    </div>

@endsection
