@props(['logos', 'contactos'])
<nav class="w-full z-50" x-data="navbarData">
    <!-- Versión móvil: Logo y menú hamburguesa -->
    <div class="bg-main-color lg:hidden">
        <div class="flex justify-between items-center h-[70px] max-w-[90%] lg:max-w-[1224px] mx-auto">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset(Route::currentRouteName() == 'home' ? $logos[2]->path : $logos[1]->path) }}"
                        alt="logo" class="w-8 h-12">
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
            <a href="{{ route('productos') }}" class="py-2 border-b border-gray-200">{{ __('Productos') }}</a>
            <a href="{{ route('aplicaciones') }}" class="py-2 border-b border-gray-200">{{ __('Aplicaciones') }}</a>
            <a href="{{ route('colores') }}" class="py-2 border-b border-gray-200">{{ __('Carta de colores') }}</a>
            <a href="{{ route('calidad') }}" class="py-2 border-b border-gray-200">{{ __('Calidad') }}</a>
            <a href="{{ route('novedades') }}" class="py-2 border-b border-gray-200">{{ __('Novedades') }}</a>
            <a href="{{ route('contacto') }}" class="py-2 border-b border-gray-200">{{ __('Contacto') }}</a>
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
    <div class="hidden lg:block bg-white border-b border-gray-200 fixed w-full h-[184px] ">
        <div class="h-[36px] bg-main-color py-2.5">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-xs flex justify-between items-center">
                <div class="flex gap-6">
                    @foreach ($contactos as $contacto)
                        <a href="https://www.google.com/maps/search/{{ urlencode(explode(' Cdad.', $contacto->direccion)[0]) }}"
                            target="_blank" class="flex items-center gap-2 hover:text-gray-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="16" viewBox="0 0 11 16"
                                fill="none">
                                <path
                                    d="M9.856 2.64111C9.40741 1.85477 8.7623 1.19841 7.98381 0.736328C7.20531 0.274247 6.32016 0.0223025 5.41502 0.00512695C5.33602 0.00512695 5.25702 0.00512695 5.17802 0.00512695C4.27271 0.0221305 3.38736 0.273994 2.60868 0.736084C1.83 1.19817 1.18468 1.85463 0.736002 2.64111C0.266199 3.44278 0.0127389 4.35276 0.0004677 5.28186C-0.0118035 6.21096 0.217589 7.12731 0.666056 7.9411L4.48503 14.9321L4.49003 14.9411C4.57123 15.083 4.68848 15.201 4.82994 15.2831C4.97139 15.3651 5.13199 15.4083 5.29551 15.4083C5.45903 15.4083 5.61964 15.3651 5.76109 15.2831C5.90254 15.201 6.01985 15.083 6.10105 14.9411L6.106 14.9321L9.926 7.9411C10.3745 7.12731 10.6038 6.21096 10.5915 5.28186C10.5793 4.35276 10.3258 3.44278 9.856 2.64111ZM5.296 6.98312C4.86761 6.98312 4.44889 6.85608 4.09269 6.61807C3.7365 6.38007 3.45884 6.04178 3.2949 5.646C3.13096 5.25021 3.0881 4.81472 3.17167 4.39456C3.25525 3.9744 3.46152 3.58844 3.76444 3.28552C4.06737 2.9826 4.45329 2.77632 4.87345 2.69275C5.29362 2.60917 5.72913 2.65204 6.12492 2.81598C6.5207 2.97992 6.85896 3.25754 7.09696 3.61374C7.33497 3.96994 7.46202 4.38871 7.46202 4.81711C7.46149 5.3914 7.2331 5.94203 6.82701 6.34811C6.42092 6.7542 5.8703 6.98259 5.296 6.98312Z"
                                    fill="white" />
                            </svg>
                            {{ explode(' Cdad.', $contacto->direccion)[0] }} CABA
                        </a>
                        <a href="mailto:{{ $contacto->email }}"
                            class="flex items-center gap-2 hover:text-gray-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15"
                                fill="none">
                                <path d="M18.5201 2.60718V11.5462L12.8001 7.16916L18.5201 2.60718Z" fill="white" />
                                <path d="M6.11014 7.16916L0.390045 11.5462V2.60718L6.11014 7.16916Z" fill="white" />
                                <path
                                    d="M18.4811 1.09613C18.4389 0.795106 18.2899 0.519252 18.0614 0.318817C17.8329 0.118382 17.5401 0.00672318 17.2361 0.00415039H1.67313C1.36911 0.00651671 1.076 0.1181 0.847443 0.318573C0.618881 0.519046 0.470114 0.795021 0.428131 1.09613L9.45413 7.83612L18.4811 1.09613Z"
                                    fill="white" />
                                <path
                                    d="M9.80804 9.14117C9.70315 9.20992 9.58043 9.24652 9.45502 9.24652C9.3296 9.24652 9.20701 9.20992 9.10211 9.14117L7.28607 7.94116L0.431091 13.0412C0.474572 13.3403 0.623673 13.614 0.851501 13.8126C1.07933 14.0113 1.37077 14.1219 1.67303 14.1242H17.236C17.5382 14.1216 17.8296 14.0111 18.0574 13.8124C18.2852 13.6138 18.4344 13.3402 18.4781 13.0412L11.6231 7.94116L9.80804 9.14117Z"
                                    fill="white" />
                            </svg>
                            {{ $contacto->email }}
                        </a>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contacto->telefono) }}"
                            class="ml-1 flex items-center gap-2 hover:text-gray-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="16" viewBox="0 0 12 16"
                                fill="none">
                                <path
                                    d="M10.1951 10.7092C10.1332 10.5721 10.0425 10.4499 9.92924 10.3509C9.81599 10.2519 9.68286 10.1784 9.53873 10.1353C9.3946 10.0923 9.2429 10.0807 9.09391 10.1014C8.94491 10.122 8.80205 10.1745 8.67509 10.2552C8.21409 10.5012 7.75303 10.7482 7.29703 11.0022C7.27456 11.0203 7.24871 11.0339 7.22098 11.042C7.19325 11.0501 7.16426 11.0527 7.13553 11.0495C7.10681 11.0464 7.07893 11.0375 7.05363 11.0236C7.02832 11.0096 7.00606 10.9908 6.98807 10.9682C6.79507 10.7742 6.58104 10.5992 6.40104 10.3962C5.5842 9.43835 4.93025 8.35293 4.46512 7.18319C4.21257 6.60658 4.04419 5.99668 3.96512 5.37218C3.95238 5.3188 3.95931 5.2626 3.98466 5.21392C4.01001 5.16524 4.05202 5.12733 4.10306 5.10717C4.56106 4.87017 5.01305 4.62118 5.46805 4.37218C5.61077 4.31137 5.73834 4.21981 5.84159 4.10402C5.94484 3.98824 6.02121 3.85107 6.06534 3.70235C6.10947 3.55363 6.12022 3.397 6.09684 3.24364C6.07345 3.09028 6.01654 2.94398 5.93009 2.81517C5.73609 2.45117 5.54011 2.09418 5.34611 1.73018C5.15211 1.36618 4.94613 0.983178 4.74613 0.613178C4.68317 0.476882 4.59185 0.355566 4.47831 0.257343C4.36476 0.159121 4.2315 0.0862477 4.08756 0.0435674C3.94362 0.000887185 3.79232 -0.0106071 3.64359 0.00984551C3.49486 0.0302981 3.35221 0.0822108 3.22513 0.162159C2.76113 0.407159 2.31008 0.662163 1.84208 0.904163C1.42597 1.11199 1.10615 1.47236 0.949133 1.91018C0.700247 2.63034 0.613795 3.39666 0.696081 4.15416C0.816775 5.71372 1.20762 7.24043 1.85111 8.66616C2.67946 10.5991 3.90935 12.3338 5.45914 13.7552C6.14159 14.4221 6.95133 14.9448 7.84012 15.2922C8.13325 15.4167 8.45184 15.4694 8.76945 15.4459C9.08705 15.4224 9.39442 15.3234 9.66605 15.1572C10.0721 14.9072 10.5091 14.6992 10.9281 14.4702C11.0689 14.4087 11.1946 14.3174 11.2967 14.2026C11.3987 14.0878 11.4746 13.9522 11.5191 13.8052C11.5636 13.6582 11.5756 13.5033 11.5544 13.3512C11.5331 13.1991 11.4791 13.0534 11.396 12.9242C10.996 12.1842 10.5961 11.4455 10.1961 10.7082L10.1951 10.7092Z"
                                    fill="white" />
                            </svg>
                            {{ $contacto->telefono }} / {{ $contacto->telefono2 }}
                        </a>
                    @endforeach
                </div>
                <div class="relative inline-block">
                    <button id="language-selector" class="font-semibold flex items-center gap-1 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="9" viewBox="0 0 15 9"
                            fill="none">
                            <path
                                d="M7.5 8.99998C7.32063 8.99998 7.15247 8.97158 6.99551 8.91479C6.83856 8.85799 6.69282 8.76044 6.5583 8.62212L0.369955 2.30152C0.123318 2.04961 0 1.729 0 1.33969C0 0.950379 0.123318 0.629769 0.369955 0.377861C0.616591 0.125953 0.930493 0 1.31166 0C1.69282 0 2.00673 0.125953 2.25336 0.377861L7.5 5.73663L12.7466 0.377861C12.9933 0.125953 13.3072 0 13.6883 0C14.0695 0 14.3834 0.125953 14.63 0.377861C14.8767 0.629769 15 0.950379 15 1.33969C15 1.729 14.8767 2.04961 14.63 2.30152L8.4417 8.62212C8.30717 8.75952 8.16143 8.85708 8.00448 8.91479C7.84753 8.9725 7.67937 9.00089 7.5 8.99998Z"
                                fill="white" />
                        </svg>
                        {{ strtoupper(app()->getLocale()) }}
                    </button>

                    <div id="language-dropdown"
                        class="absolute right-0 mt-2 bg-white shadow-lg rounded-lg hidden text-black z-[9999]">
                        <a href="?lang=es" class="block px-4 py-2 hover:bg-gray-100">Español</a>
                        <a href="?lang=en" class="block px-4 py-2 hover:bg-gray-100">English</a>
                        <a href="?lang=pt" class="block px-4 py-2 hover:bg-gray-100">Português</a>
                    </div>
                </div>

                <script>
                    document.getElementById('language-selector').addEventListener('click', function() {
                        document.getElementById('language-dropdown').classList.toggle('hidden');
                    });

                    // Cerrar dropdown al hacer click fuera
                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('#language-selector')) {
                            document.getElementById('language-dropdown').classList.add('hidden');
                        }
                    });
                </script>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto flex justify-between items-center h-[148px]">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ asset($logos[0]->path) }}" alt="logo" class="w-[314px] h-[100px]">
                </a>
            </div>
            <div class="flex lg:gap-3 2xl:gap-7.5 lg:text-[13px] 2xl:text-sm font-semibold items-center text-black">
                @php $currentRoute = Route::currentRouteName(); @endphp
                <a href="{{ route('nosotros') }}" class="relative">
                    {{ __('NOSOTROS') }}
                    @if ($currentRoute == 'nosotros')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('productos') }}" class="relative">
                    {{ __('PRODUCTOS') }}
                    @if ($currentRoute == 'productos' || $currentRoute == 'producto')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('aplicaciones') }}" class="relative">
                    {{ __('APLICACIONES') }}
                    @if ($currentRoute == 'aplicaciones')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('colores') }}" class="relative">
                    {{ __('CARTA DE COLORES') }}
                    @if ($currentRoute == 'colores')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('calidad') }}" class="relative">
                    {{ __('CALIDAD') }}
                    @if ($currentRoute == 'calidad')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('novedades') }}" class="relative">
                    {{ __('NOVEDADES') }}
                    @if ($currentRoute == 'novedades' || $currentRoute == 'novedad')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
                <a href="{{ route('contacto') }}" class="relative">
                    {{ __('CONTACTO') }}
                    @if ($currentRoute == 'contacto')
                        <span class="absolute left-0 -bottom-10 2xl:-bottom-16 w-full h-[7px] bg-[#E12328]"></span>
                    @endif
                </a>
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
