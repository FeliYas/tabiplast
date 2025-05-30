@extends('layouts.guest')
@section('title', __('Home'))

@section('content')
    <div>
        <div class="relative overflow-hidden">
            <!-- Slider Track -->
            <div class="slider-track flex transition-transform duration-500 ease-in-out">
                @foreach ($sliders as $slider)
                    <div class="slider-item min-w-full relative h-[500px] lg:h-[488px]">
                        <div class="absolute inset-0 bg-black z-0">
                            @php
                                $extension = pathinfo($slider->path, PATHINFO_EXTENSION);
                            @endphp
                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset($slider->path) }}" alt="Slider Image" class="w-full h-full object-cover"
                                    data-duration="6000">
                            @elseif (in_array($extension, ['mp4', 'webm', 'ogg']))
                                <video class="w-full h-full object-cover" autoplay muted onended="nextSlide()">
                                    <source src="{{ asset($slider->path) }}" type="video/{{ $extension }}">
                                    {{ __('Tu navegador no soporta el formato de video.') }}
                                </video>
                            @endif
                        </div>

                        <div class="absolute bg-black opacity-30 z-50"></div>
                        <div class="absolute inset-0 flex z-20 max-w-[90%] lg:max-w-[1224px] mx-auto">
                            <div class="flex flex-col gap-6 lg:gap-19 w-full justify-center">
                                <div class="text-white ">
                                    <div class="flex flex-col gap-4 max-w-[650px]">
                                        <h1 class="text-xl lg:text-2xl">
                                            {{ getLocalizedField($slider, 'titulo') }}
                                        </h1>
                                        <div class="custom-summernote text-2xl lg:text-4xl font-bold">
                                            <p>
                                                {!! getLocalizedField($slider, 'descripcion') !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Main elements
                const sliderTrack = document.querySelector('.slider-track');
                const sliderItems = document.querySelectorAll('.slider-item');
                const dots = document.querySelectorAll('.dot');

                let currentIndex = 0;
                let autoSlideTimeout;
                let isTransitioning = false;

                // Global function for next slide (needed for video onended attribute)
                window.nextSlide = function() {
                    if (isTransitioning) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = (currentIndex + 1) % sliderItems.length;
                    updateSlider();
                };

                // Go to specific slide (for dot navigation)
                window.goToSlide = function(index) {
                    if (isTransitioning || index === currentIndex) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = index;
                    updateSlider();
                };

                // Initialize slider
                function initSlider() {
                    // Configure videos
                    sliderItems.forEach(item => {
                        const video = item.querySelector('video');
                        if (video) {
                            // Remove loop attribute
                            video.removeAttribute('loop');

                            // Make sure onended is properly set
                            video.onended = window.nextSlide;
                        }
                    });

                    // Show first active slide
                    updateSlider();
                }

                // Update slider to current position
                function updateSlider() {
                    isTransitioning = true;

                    // Stop all playing videos
                    sliderItems.forEach(item => {
                        const video = item.querySelector('video');
                        if (video) {
                            video.pause();
                        }
                    });

                    // Update track position
                    sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;

                    // Update navigation dots
                    dots.forEach((dot, index) => {
                        if (index === currentIndex) {
                            dot.classList.add('opacity-90');
                            dot.classList.remove('opacity-50');
                        } else {
                            dot.classList.add('opacity-50');
                            dot.classList.remove('opacity-90');
                        }
                    });

                    // Schedule next slide
                    scheduleNextSlide();

                    // End transition after animation duration
                    setTimeout(() => {
                        isTransitioning = false;
                    }, 500); // Should match CSS transition duration (duration-500)
                }

                // Schedule next slide based on content type
                function scheduleNextSlide() {
                    clearTimeout(autoSlideTimeout);

                    const currentSlide = sliderItems[currentIndex];
                    const video = currentSlide.querySelector('video');

                    if (video) {
                        // If it's a video, set to start from beginning
                        video.currentTime = 0;
                        video.play();
                        // No need to add listener here as we use the onended attribute
                        console.log("Video started, waiting for it to end before going to next slide");
                    } else {
                        // If it's an image, use specified duration or default 6000ms
                        const img = currentSlide.querySelector('img');
                        const duration = img && img.dataset.duration ? parseInt(img.dataset.duration) : 6000;

                        console.log("Image displayed, will change in " + duration / 1000 + " seconds");
                        autoSlideTimeout = setTimeout(window.nextSlide, duration);
                    }
                }

                // Start slider
                initSlider();
            });
        </script>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-8">
            <div class="flex flex-col items-center gap-7">
                <h2 class="font-medium text-[26px] text-[#c87800]">{{ __('NUESTROS PRODUCTOS') }}</h2>
                <div class="grid lg:grid-cols-4 gap-6 w-full">
                    @foreach ($productos as $producto)
                        <div class="flex flex-col gap-2.5">
                            @if ($producto->imagenPrincipal)
                                <img src="{{ $producto->imagenPrincipal->path }}"
                                    alt="{{ __('imagen de producto') }} {{ getLocalizedField($producto, 'titulo') }}"
                                    class="h-[230px] w-full border border-[#DDE3E8] py-2.5 px-9.5">
                            @else
                                <div class="bg-gray-200 w-full h-40 flex items-center justify-center">
                                    <span class="text-gray-500">{{ __('Sin imagen') }}</span>
                                </div>
                            @endif
                            <h3 class="text-black text-[17px] font-semibold">{{ getLocalizedField($producto, 'titulo') }}
                            </h3>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('productos') }}" class="btn-primary w-[213px] mb-4.5">{{ __('VER TODOS') }}</a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-13.5 mb-11">
            <img src="{{ $contenido[0]->path }}" alt="{{ __('Contenido de la pagina') }}"
                class="lg:w-1/2 h-[400px] lg:h-[491px] object-cover opacity-0 -translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-left">
            <div
                class="lg:w-1/2 pr-[5%] pl-[5%] lg:pl-[0%] lg:pr-[18%] lg:mt-8 flex flex-col gap-6 lg:gap-5 opacity-0 translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-right items-center lg:items-start text-black">
                <h2 class="font-medium text-[26px]">{{ getLocalizedField($contenido[0], 'titulo') }}</h2>
                <div class="custom-summernote font-light text-center lg:text-left">
                    <p>{!! getLocalizedField($contenido[0], 'descripcion') !!}</p>
                </div>
                <a href="{{ route('nosotros') }}" class="btn-primary w-[245px]">{{ __('MAS INFORMACIÓN') }}</a>
            </div>
        </div>
        <div>
            <div class="relative">
                <img src="{{ $contenido[1]->path }}" alt="{{ __('Contenido de la pagina') }}" class="w-full h-[400px]">
                <div class="absolute inset-0">
                    <div
                        class="flex flex-col gap-6.5 text-center items-center justify-center max-w-[90%] lg:max-w-[48%] mx-auto h-full">
                        <h2 class="lg:text-[36px] font-semibold">{{ getLocalizedField($contenido[1], 'titulo') }}</h2>
                        <div class="custom-summernote font-medium text-center lg:text-[30px] leading-9">
                            <p>{!! getLocalizedField($contenido[1], 'descripcion') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-20 ">
            <div class="flex flex-col lg:flex-row gap-6 w-full">
                @foreach ($novedades as $novedad)
                    <x-tarjeta-novedades :novedad="$novedad" />
                @endforeach
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', '-translate-x-20',
                            'translate-x-20');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.scroll-fade-left, .scroll-fade-right').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
@endsection
