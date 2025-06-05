@props(['logos', 'contactos'])
<nav class="w-full z-50" x-data="navbarData">
    <!-- Versión móvil: Logo y menú hamburguesa -->
    <div class="bg-main-color lg:hidden">
        <div class="flex justify-between items-center h-[70px] max-w-[90%] lg:max-w-[1224px] mx-auto">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset(Route::currentRouteName() == 'home' ? $logos[2]->path : $logos[1]->path) }}"
                        alt="logo" class="w-38 h-16">
                </a>
            </div>
            <div class="mt-1.5">
                <button @click="mobileMenuOpen = !mobileMenuOpen" class=" focus:outline-none">
                    <i class="fa-solid fa-bars text-xl text-white"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="lg:hidden bg-white shadow-lg overflow-hidden transition-all duration-300 absolute w-full z-40"
        :class="mobileMenuOpen ? 'max-h-screen' : 'max-h-0'" x-cloak>
        <div class="flex flex-col px-4 py-2 text-black">
            <a href="{{ route('nosotros') }}" class="py-2 border-b border-gray-200">{{ __('Nosotros') }}</a>
            <a href="{{ route('categorias') }}" class="py-2 border-b border-gray-200">{{ __('Productos') }}</a>
            <a href="{{ route('internacional') }}" class="py-2 border-b border-gray-200">{{ __('Internacional') }}</a>
            <a href="{{ route('novedades') }}" class="py-2 border-b border-gray-200">{{ __('Novedades') }}</a>
            <a href="{{ route('contacto') }}" class="py-2 border-b border-gray-200">{{ __('Contacto') }}</a>
            <a href="{{ route('presupuesto') }}" class="py-2 border-b border-gray-200">{{ __('Presupuesto') }}</a>
            <div class="flex items-center py-2">
                <i class="fa-solid fa-envelope mr-2 text-gray-600"></i>
                @foreach ($contactos as $contacto)
                    @if ($contacto->email)
                        <a href="mailto:{{ $contacto->email }}">
                            <p class="text-gray-600">{{ $contacto->email }}</p>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="hidden lg:block bg-white border-b border-gray-200 fixed w-full h-[90px] ">
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto flex justify-between items-center">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset($logos[1]->path) }}" alt="logo" class="w-[220px] h-[90px]">
                </a>
            </div>
            <div class="flex lg:gap-3 2xl:gap-7.5 lg:text-[13px] 2xl:text-base items-center text-black">
                @php $currentRoute = Route::currentRouteName(); @endphp
                <a href="{{ route('nosotros') }}" class="relative {{ $currentRoute == 'nosotros' ? 'font-bold' : '' }}">
                    {{ __('Nosotros') }}
                </a>
                <a href="{{ route('categorias') }}" class="relative {{ in_array($currentRoute, ['categorias', 'productos', 'producto']) ? 'font-bold' : '' }}">
                    {{ __('Productos') }}
                </a>
                <a href="{{ route('internacional') }}" class="relative {{ $currentRoute == 'internacional' ? 'font-bold' : '' }}">
                    {{ __('Internacional') }}
                </a>
                <a href="{{ route('novedades') }}" class="relative {{ in_array($currentRoute, ['novedades', 'novedad']) ? 'font-bold' : '' }}">
                    {{ __('Novedades') }}
                </a>
                <a href="{{ route('contacto') }}" class="relative {{ $currentRoute == 'contacto' ? 'font-bold' : '' }}">
                    {{ __('Contacto') }}
                </a>
            </div>
            <div>
                <a href="{{ route('presupuesto') }}" class="btn-secondary w-[223px] font-semibold">Solicitud de presupuesto</a>
            </div>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('navbarData', () => ({
            scrolled: false,
            mobileMenuOpen: false,
        }));
    });
</script>
