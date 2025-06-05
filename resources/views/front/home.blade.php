@extends('layouts.guest')
@section('title', __('Home'))

@section('content')
    <div>
        <!-- Hero Slider Section -->
        <div class="overflow-hidden">
            <div class="slider-track flex transition-transform duration-500 ease-in-out">
                @foreach ($sliders as $slider)
                    @php $ext = pathinfo($slider->path, PATHINFO_EXTENSION); @endphp
                    <div class="slider-item min-w-full relative h-[400px] sm:h-[500px] lg:h-[678px]">
                        <div class="absolute inset-0 bg-black z-0">
                            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset($slider->path) }}" alt="Slider Image" class="w-full h-full object-cover"
                                    data-duration="6000">
                            @elseif (in_array($ext, ['mp4', 'webm', 'ogg']))
                                <video class="w-full h-full object-cover" autoplay muted onended="nextSlide()">
                                    <source src="{{ asset($slider->path) }}" type="video/{{ $ext }}">
                                    {{ __('Tu navegador no soporta el formato de video.') }}
                                </video>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-black opacity-30 z-10"></div>
                        <div class="absolute inset-0 flex z-20 px-4 sm:px-6 lg:max-w-[1224px] lg:mx-auto">
                            <div class="relative flex flex-col gap-4 sm:gap-6 lg:gap-19 w-full justify-center">
                                <div class="max-w-[320px] sm:max-w-[400px] lg:max-w-[480px] text-white">
                                    <h1
                                        class="text-lg sm:text-xl md:text-3xl lg:text-5xl font-bold leading-tight sm:leading-normal lg:leading-14">
                                        {{ $slider->titulo }}</h1>
                                </div>
                                <a href="{{ route('categorias') }}"
                                    class="border border-white w-[180px] sm:w-[200px] lg:w-[230px] text-center py-2 sm:py-2.5 text-sm sm:text-base rounded-full hover:bg-white hover:text-black transition duration-300">Ver
                                    productos</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Slider Navigation Dots -->
            <div class="relative px-4 sm:px-6 lg:max-w-[1224px] lg:mx-auto">
                <div class="absolute bottom-4 sm:bottom-6 lg:bottom-30 w-full z-30">
                    <div class="flex space-x-1 lg:space-x-2">
                        @foreach ($sliders as $i => $slider)
                            <button
                                class="cursor-pointer dot w-4 sm:w-6 lg:w-12 h-1 sm:h-1.5 rounded-none transition-colors duration-300 bg-white {{ $i === 0 ? 'opacity-90' : 'opacity-50' }}"
                                data-dot-index="{{ $i }}" onclick="goToSlide({{ $i }})"></button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sliderTrack = document.querySelector('.slider-track');
                const sliderItems = document.querySelectorAll('.slider-item');
                const dots = document.querySelectorAll('.dot');
                let currentIndex = 0,
                    autoSlideTimeout, isTransitioning = false;

                window.nextSlide = () => {
                    if (isTransitioning) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = (currentIndex + 1) % sliderItems.length;
                    updateSlider();
                };
                window.goToSlide = i => {
                    if (isTransitioning || i === currentIndex) return;
                    clearTimeout(autoSlideTimeout);
                    currentIndex = i;
                    updateSlider();
                };

                function updateSlider() {
                    isTransitioning = true;
                    sliderItems.forEach(item => item.querySelector('video')?.pause());
                    sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
                    dots.forEach((dot, i) => dot.classList.toggle('opacity-90', i === currentIndex) || dot.classList
                        .toggle('opacity-50', i !== currentIndex));
                    scheduleNextSlide();
                    setTimeout(() => isTransitioning = false, 500);
                }

                function scheduleNextSlide() {
                    clearTimeout(autoSlideTimeout);
                    const slide = sliderItems[currentIndex],
                        video = slide.querySelector('video'),
                        img = slide.querySelector('img');
                    if (video) {
                        video.currentTime = 0;
                        video.play();
                    } else autoSlideTimeout = setTimeout(window.nextSlide, img?.dataset.duration ? +img.dataset
                        .duration : 6000);
                }
                sliderItems.forEach(item => item.querySelector('video') && (item.querySelector('video').onended = window
                    .nextSlide));
                updateSlider();
            });
        </script>

        <!-- Products Categories Section -->
        <div class="px-4 sm:px-6 lg:max-w-[1224px] lg:mx-auto py-8 sm:py-12 lg:py-18 mb-2">
            <div class="flex flex-col items-center gap-4 sm:gap-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full gap-3 sm:gap-0">
                    <h2 class="font-bold text-xl sm:text-2xl lg:text-[32px] text-black">{{ __('Productos') }}</h2>
                    <a href="{{ route('categorias') }}"
                        class="btn-secondary text-sm sm:text-base">{{ __('Ver todos') }}</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 w-full">
                    @foreach ($categorias as $categoria)
                        <a href="{{ route('productos', $categoria->id) }}"
                            class="relative overflow-hidden rounded-[15px] sm:rounded-[20px] shadow-lg hover:shadow-xl transition-transform duration-300 ease-in-out flex items-center justify-center translate-y-0 hover:translate-y-[-5px] min-h-[200px] sm:min-h-[250px]">
                            <img src="{{ $categoria->path }}" alt="{{ $categoria->titulo }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black opacity-20"></div>
                            <h3
                                class="absolute bottom-4 sm:bottom-6 lg:bottom-8 font-bold text-lg sm:text-xl lg:text-2xl text-white px-4 text-center">
                                {{ $categoria->titulo }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="flex flex-col lg:flex-row gap-0 lg:gap-13.5 bg-[#231F20]">
            <img src="{{ $contenido->path }}" alt="{{ __('Contenido de la pagina') }}"
                class="w-full lg:w-1/2 h-[300px] sm:h-[400px] lg:h-[600px] object-cover opacity-0 -translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-left">
            <div
                class="w-full lg:w-1/2 px-4 sm:px-6 lg:pl-0 lg:pr-[18%] py-8 sm:py-12 lg:py-17 flex flex-col justify-between opacity-0 translate-x-20 transition-all duration-2000 ease-in-out scroll-fade-right items-center lg:items-start text-white gap-6 lg:gap-0">
                <div class="flex flex-col gap-4 sm:gap-6 w-full">
                    <h2 class="font-bold text-xl sm:text-2xl lg:text-[32px] text-center lg:text-left">
                        {{ $contenido->titulo }}</h2>
                    <div class="custom-summernote text-center lg:text-left text-sm sm:text-base">
                        <p>{!! $contenido->descripcion !!}</p>
                    </div>
                </div>
                <a href="{{ route('nosotros') }}"
                    class="border border-white w-[120px] sm:w-[140px] text-center py-2 sm:py-2.5 text-sm sm:text-base rounded-full hover:bg-white hover:text-black transition duration-300">{{ __('Más info') }}</a>
            </div>
        </div>

        <!-- Featured Products Section -->
        <div class="px-4 sm:px-6 lg:max-w-[1224px] lg:mx-auto py-8 sm:py-12 lg:py-14 mt-2">
            <h2 class="font-bold text-xl sm:text-2xl lg:text-[32px] text-black mb-4 sm:mb-6">
                {{ __('Productos destacados') }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 w-full">
                @foreach ($productos as $producto)
                    <a href="{{ route('producto', ['id' => $producto->id]) }}"
                        class="h-[350px] sm:h-[380px] lg:h-[422px] rounded-[10px] border border-gray-200 block transition-transform duration-300 hover:shadow-xl hover:-translate-y-1 transform">
                        <img src="{{ $producto->imagen }}" alt="{{ $producto->titulo }}"
                            class="w-full h-[220px] sm:h-[250px] lg:h-[288px] object-cover rounded-t-[10px] p-1 transition-transform duration-300 hover:scale-105">
                        <hr class="border-t-[1.5px] border-gray-200 mx-3 sm:mx-4.5">
                        <div class="p-3 sm:p-3.5 flex flex-col gap-2 sm:gap-2.5">
                            <p class="text-main-color font-bold uppercase line-clamp-1 text-xs sm:text-sm">
                                {{ $producto->categoria->titulo }}</p>
                            <h3 class="font-bold text-base sm:text-lg line-clamp-2 text-black">{{ $producto->titulo }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- News Section -->
        <div class="bg-gray-100">
            <div class="px-4 sm:px-6 lg:max-w-[1224px] lg:mx-auto pt-8 sm:pt-11 pb-12 sm:pb-18">
                <div
                    class="flex flex-col sm:flex-row justify-between items-start sm:items-center w-full gap-3 sm:gap-0 mb-4 sm:mb-6">
                    <h2 class="font-bold text-xl sm:text-2xl lg:text-[32px] text-black">{{ __('Novedades') }}</h2>
                    <a href="{{ route('novedades') }}"
                        class="btn-secondary text-sm sm:text-base">{{ __('Ver todas') }}</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 w-full">
                    @foreach ($novedades as $novedad)
                        <x-tarjeta-novedades :novedad="$novedad" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => entry.isIntersecting && entry.target.classList.remove('opacity-0',
                    '-translate-x-20', 'translate-x-20'));
            }, {
                threshold: 0.1
            });
            document.querySelectorAll('.scroll-fade-left, .scroll-fade-right').forEach(el => observer.observe(el));
        });
    </script>
@endsection
