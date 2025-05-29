@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Carta de colores'))

@section('content')
    <div class="relative">
        <!-- Breadcrumb fijo -->
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('colores') }}" class="hover:underline">{{ __('CARTA DE COLORES') }}</a>
                </div>
            </div>
        </div>

        <div class="py-7.5 lg:mt-15">
            <!-- Grid de colores -->
            <div
                class="grid grid-cols-2 lg:grid-cols-6 gap-6 items-start max-w-[90%] lg:max-w-[1224px] mx-auto mb-8 min-h-[510px]">
                @foreach ($colores as $color)
                    <div class="h-[70px] flex flex-col"> <img src="{{ $color->path }}"
                            alt="{{ __('Color') }} {{ $color->codigo }}" class="w-[184px] h-[47px] object-cover">
                        <div class="flex gap-1.5 text-black text-sm text-medium">
                            <p>{{ $color->codigo }}</p>
                            <span>|</span>
                            <p>{{ getLocalizedField($color, 'titulo') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación personalizada -->
            @if ($colores->hasPages())
                <div class="flex justify-center items-center">
                    <div class="flex items-center bg-white px-4 py-2 rounded">
                        <!-- Flecha izquierda -->
                        @if ($colores->onFirstPage())
                            <span class="flex items-center justify-center w-8 h-8 mr-2 text-gray-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M9.5502 12.0001L16.9002 19.3501C17.1502 19.6001 17.2712 19.8918 17.2632 20.2251C17.2552 20.5584 17.1259 20.8501 16.8752 21.1001C16.6245 21.3501 16.3329 21.4751 16.0002 21.4751C15.6675 21.4751 15.3759 21.3501 15.1252 21.1001L7.4252 13.4251C7.2252 13.2251 7.0752 13.0001 6.9752 12.7501C6.8752 12.5001 6.8252 12.2501 6.8252 12.0001C6.8252 11.7501 6.8752 11.5001 6.9752 11.2501C7.0752 11.0001 7.2252 10.7751 7.4252 10.5751L15.1252 2.87509C15.3752 2.62509 15.6712 2.50409 16.0132 2.51209C16.3552 2.52009 16.6509 2.64942 16.9002 2.90009C17.1495 3.15076 17.2745 3.44242 17.2752 3.77509C17.2759 4.10776 17.1509 4.39942 16.9002 4.65009L9.5502 12.0001Z"
                                        fill="black" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $colores->previousPageUrl() }}"
                                class="flex items-center justify-center w-8 h-8 mr-2 text-gray-600 hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M9.5502 12.0001L16.9002 19.3501C17.1502 19.6001 17.2712 19.8918 17.2632 20.2251C17.2552 20.5584 17.1259 20.8501 16.8752 21.1001C16.6245 21.3501 16.3329 21.4751 16.0002 21.4751C15.6675 21.4751 15.3759 21.3501 15.1252 21.1001L7.4252 13.4251C7.2252 13.2251 7.0752 13.0001 6.9752 12.7501C6.8752 12.5001 6.8252 12.2501 6.8252 12.0001C6.8252 11.7501 6.8752 11.5001 6.9752 11.2501C7.0752 11.0001 7.2252 10.7751 7.4252 10.5751L15.1252 2.87509C15.3752 2.62509 15.6712 2.50409 16.0132 2.51209C16.3552 2.52009 16.6509 2.64942 16.9002 2.90009C17.1495 3.15076 17.2745 3.44242 17.2752 3.77509C17.2759 4.10776 17.1509 4.39942 16.9002 4.65009L9.5502 12.0001Z"
                                        fill="black" />
                                </svg>
                            </a>
                        @endif

                        <!-- Números de página -->
                        <div class="flex items-center">
                            @php
                                $currentPage = $colores->currentPage();
                                $lastPage = $colores->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);

                                // Ajustar para mostrar siempre hasta 5 números si es posible
                                if ($end - $start < 4) {
                                    if ($start == 1) {
                                        $end = min($lastPage, $start + 4);
                                    } else {
                                        $start = max(1, $end - 4);
                                    }
                                }
                            @endphp

                            {{-- Mostrar primera página si no está en el rango --}}
                            @if ($start > 1)
                                <a href="{{ $colores->url(1) }}"
                                    class="px-2 py-1 text-lg text-gray-600 hover:text-black transition-colors">1</a>
                                @if ($start > 2)
                                    <span class="px-1 text-gray-400">-</span>
                                @endif
                            @endif

                            {{-- Páginas en el rango actual --}}
                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <span class="px-2 py-1 text-lg font-semibold text-black">{{ $i }}</span>
                                @else
                                    <a href="{{ $colores->url($i) }}"
                                        class="px-2 py-1 text-lg text-gray-600 hover:text-black transition-colors">{{ $i }}</a>
                                @endif

                                {{-- Separador entre números --}}
                                @if ($i < $end)
                                    <span class="text-gray-400">-</span>
                                @endif
                            @endfor

                            {{-- Mostrar última página si no está en el rango --}}
                            @if ($end < $lastPage)
                                @if ($end < $lastPage - 1)
                                    <span class="px-1 text-gray-400">-</span>
                                @endif
                                <a href="{{ $colores->url($lastPage) }}"
                                    class="px-2 py-1 text-lg text-gray-600 hover:text-black transition-colors">{{ $lastPage }}</a>
                            @endif
                        </div>

                        <!-- Flecha derecha -->
                        @if ($colores->hasMorePages())
                            <a href="{{ $colores->nextPageUrl() }}"
                                class="flex items-center justify-center w-8 h-8 ml-2 text-gray-600 hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M14.4751 12L7.12509 4.65C6.87509 4.4 6.75409 4.104 6.76209 3.762C6.77009 3.42 6.89942 3.12434 7.15009 2.875C7.40076 2.62567 7.69676 2.50067 8.03809 2.5C8.37942 2.49934 8.67509 2.62434 8.92509 2.875L16.6001 10.575C16.8001 10.775 16.9501 11 17.0501 11.25C17.1501 11.5 17.2001 11.75 17.2001 12C17.2001 12.25 17.1501 12.5 17.0501 12.75C16.9501 13 16.8001 13.225 16.6001 13.425L8.90009 21.125C8.65009 21.375 8.35842 21.496 8.02509 21.488C7.69176 21.48 7.40009 21.3507 7.15009 21.1C6.90009 20.8493 6.77509 20.5533 6.77509 20.212C6.77509 19.8707 6.90009 19.575 7.15009 19.325L14.4751 12Z"
                                        fill="black" />
                                </svg>
                            </a>
                        @else
                            <span class="flex items-center justify-center w-8 h-8 ml-2 text-gray-300 cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <path
                                        d="M14.4751 12L7.12509 4.65C6.87509 4.4 6.75409 4.104 6.76209 3.762C6.77009 3.42 6.89942 3.12434 7.15009 2.875C7.40076 2.62567 7.69676 2.50067 8.03809 2.5C8.37942 2.49934 8.67509 2.62434 8.92509 2.875L16.6001 10.575C16.8001 10.775 16.9501 11 17.0501 11.25C17.1501 11.5 17.2001 11.75 17.2001 12C17.2001 12.25 17.1501 12.5 17.0501 12.75C16.9501 13 16.8001 13.225 16.6001 13.425L8.90009 21.125C8.65009 21.375 8.35842 21.496 8.02509 21.488C7.69176 21.48 7.40009 21.3507 7.15009 21.1C6.90009 20.8493 6.77509 20.5533 6.77509 20.212C6.77509 19.8707 6.90009 19.575 7.15009 19.325L14.4751 12Z"
                                        fill="black" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection
