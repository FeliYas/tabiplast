@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Nosotros'))

@section('content')
    <div class="relative">
        <!-- Breadcrumb fijo -->
        <div class="hidden lg:block fixed top-0 left-0 w-full z-50 bg-[#F2F2F2] opacity-[0.643] lg:mt-[184px]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('nosotros') }}" class="hover:underline">{{ __('NOSOTROS') }}</a>
                </div>
            </div>
        </div>

        <!-- Banner Slider -->
        <div class="relative overflow-hidden">
            <div id="bannerSlider" class="flex transition-transform duration-500 ease-in-out"
                style="transform: translateX(0%);">
                @foreach ($banners as $banner)
                    <div class="w-full flex-shrink-0">
                        <img src="{{ $banner->path }}" alt="Banner" class="w-full h-[200px] lg:h-[448px] object-cover">
                    </div>
                @endforeach
            </div>

            <!-- Indicadores circulares -->
            @if (count($banners) > 1)
                <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex gap-2">
                    @foreach ($banners as $index => $banner)
                        <button onclick="goToSlide({{ $index }})"
                            class="slider-dot w-4 h-4 rounded-full transition-all duration-300 bg-white {{ $index === 0 ? 'opacity-100' : 'opacity-60' }}"
                            data-slide="{{ $index }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-12 flex flex-col lg:flex-row gap-14">
            <div class="custom-summernote font-light text-black leading-5 text-[17px]">
                <p>{!! getLocalizedField($nosotros, 'descripcion') !!}</p>
            </div>
            <img src="{{ $nosotros->path }}" alt="{{ __('Imagen de Nosotros') }}" class="lg:w-1/2 h-[289px] object-cover">
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('bannerSlider');
            const dots = document.querySelectorAll('.slider-dot');
            const totalSlides = {{ count($banners) }};
            let currentSlide = 0;
            let slideInterval = null;
            let isHovered = false;

            window.goToSlide = function(slideIndex) {
                currentSlide = slideIndex;
                updateSlider();
                resetTimer();
            }

            function updateSlider() {
                const translateX = -currentSlide * 100;
                slider.style.transform = `translateX(${translateX}%)`;

                dots.forEach((dot, index) => {
                    if (index === currentSlide) {
                        dot.classList.add('opacity-100');
                        dot.classList.remove('opacity-60');
                    } else {
                        dot.classList.remove('opacity-100');
                        dot.classList.add('opacity-60');
                    }
                });
            }

            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlider();
            }

            function clearTimer() {
                if (slideInterval) {
                    clearInterval(slideInterval);
                    slideInterval = null;
                }
            }

            function startTimer() {
                if (!isHovered && totalSlides > 1) {
                    clearTimer();
                    slideInterval = setInterval(nextSlide, 8000);
                }
            }

            function resetTimer() {
                clearTimer();
                startTimer();
            }

            if (totalSlides > 1) {
                startTimer();
            }

            const sliderContainer = slider.parentElement;

            sliderContainer.addEventListener('mouseenter', function() {
                isHovered = true;
                clearTimer();
            });

            sliderContainer.addEventListener('mouseleave', function() {
                isHovered = false;
                startTimer();
            });
        });
    </script>
@endsection
