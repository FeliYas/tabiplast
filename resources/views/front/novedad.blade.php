@extends('layouts.guest')
@section('title', __('Novedades'))

@section('content')
    <div class="relative">
        <!-- Breadcrumb fijo -->
        <div class="fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('novedades') }}" class="hover:underline">{{ __('NOVEDADES') }}</a>
                    <span>|</span>
                    <a href="{{ route('novedad', $novedad->id) }}"
                        class="hover:underline">{{ Str::upper(getLocalizedField($novedad, 'titulo')) }}</a>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-15 flex gap-15">
            <img src="{{ $novedad->path }}" alt="{{ __('Novedad') }}" class="w-1/2 h-[400px] object-cover rounded-[10px]">
            <div class="w-1/2 flex flex-col gap-5">
                <h1 class="text-[40px] font-semibold text-black leading-10">{{ getLocalizedField($novedad, 'titulo') }}</h1>
                <div class="custom-summernote font-light text-black leading-5 text-[17px]">
                    <p>{!! getLocalizedField($novedad, 'descripcion') !!}</p>
                </div>
            </div>
        </div>
    </div>

@endsection
