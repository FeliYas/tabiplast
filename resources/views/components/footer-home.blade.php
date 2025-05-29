@props(['logos', 'contactos'])

<footer class="text-white">
    <div class="bg-main-color">
        <div
            class="flex flex-col lg:flex-row gap-10 lg:gap-0 justify-between max-w-[80%] xl:max-w-[1224px] mx-auto pb-12 pt-18">
            <div class="flex gap-22 lg:gap-32 lg:w-1/3">
                <div>
                    @if (Route::currentRouteName() == 'home')
                        <img src="{{ asset($logos[2]->path) }}" alt="">
                    @else
                        <img src="{{ asset($logos[1]->path) }}" alt="">
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold text-[15px] text-white">{{ __('SECCIONES') }}</h3>
                    <div class="flex flex-col mt-1.5 text-sm text-[#FFE2E2] font-light">
                        <a href="{{ route('nosotros') }}" class="hover:underline">{{ __('NOSOTROS') }}</a>
                        <a href="{{ route('productos') }}" class="hover:underline">{{ __('PRODUCTOS') }}</a>
                        <a href="{{ route('aplicaciones') }}" class="hover:underline">{{ __('APLICACIONES') }}</a>
                        <a href="{{ route('colores') }}" class="hover:underline">{{ __('CARTA DE COLORES') }}</a>
                        <a href="{{ route('novedades') }}" class="hover:underline">{{ __('NOVEDADES') }}</a>
                        <a href="{{ route('contacto') }}" class="hover:underline">{{ __('CONTACTO') }}</a>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/3 flex flex-col items-center">
                <div>
                    <h3 class="font-semibold text-[15px] text-white w-[260px]">{{ __('SUSCRIBITE AL NEWSLETTER') }}
                    </h3>
                </div>
                <form id="newsletterForm" class="w-full flex flex-col items-center">
                    @csrf
                    <div
                        class="w-[276px] h-[39px] bg-[#9E2C2C] rounded-[20px] mt-1 flex justify-between text-[#FFDDDD]">
                        <input type="email" name="email" placeholder="{{ __('Ingresa tu mail') }}"
                            class="bg-transparent border-none outline-none text-[#FFDDDD] placeholder-[#FFDDDD] text-xs p-3 w-full"
                            required>
                        <button type="submit"
                            class="bg-[#CA1D22] flex items-center justify-center rounded-r-[20px] px-3 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                fill="none">
                                <path
                                    d="M16.442 6.83145L2.36915 0.991854C2.08025 0.872002 1.76368 0.834956 1.45491 0.884865C1.14615 0.934774 0.857372 1.06967 0.620941 1.27443C0.38451 1.4792 0.209761 1.74575 0.11627 2.04423C0.0227787 2.3427 0.0142383 2.66131 0.0916052 2.96437L1.34392 7.87872H7.47753C7.61304 7.87872 7.74299 7.93255 7.83881 8.02837C7.93463 8.12418 7.98846 8.25414 7.98846 8.38964C7.98846 8.52515 7.93463 8.65511 7.83881 8.75092C7.74299 8.84674 7.61304 8.90057 7.47753 8.90057H1.34476L0.0924525 13.8149C0.016396 14.1175 0.0258883 14.4353 0.119871 14.7329C0.213853 15.0304 0.388632 15.296 0.624718 15.5C0.860805 15.704 1.14892 15.8384 1.45693 15.8883C1.76495 15.9381 2.08076 15.9015 2.36915 15.7824L16.442 9.94275C16.7494 9.81508 17.0121 9.59918 17.197 9.3223C17.3818 9.04543 17.4804 8.72 17.4804 8.3871C17.4804 8.05421 17.3818 7.72877 17.197 7.4519C17.0121 7.17502 16.7494 6.95912 16.442 6.83145Z"
                                    fill="#F9F9F9" />
                            </svg>
                        </button>
                    </div>
                    <div id="newsletterMessage" class="text-xs mt-2"></div>
                </form>
            </div>
            <div class="lg:w-1/3 flex flex-col items-center">
                <div class="text-left w-[210px]">
                    <h3 class="font-semibold text-[15px] text-white">{{ __('CONTACTANOS') }}</h3>
                </div>
                <div
                    class="flex flex-col gap-2.5 items-start justify-center text-[13px] font-semibold text-[#FFE2E2] mt-3 text-left">
                    @foreach ($contactos as $contacto)
                        @if ($contacto->direccion)
                            <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                                class="block no-underline text-inherit hover:text-main-color">
                                <p class="max-w-[190px]">
                                    {{ $contacto->direccion }}
                                </p>
                            </a>
                        @endif
                        @if ($contacto->email)
                            <a href="mailto:{{ $contacto->email }}"
                                class="block no-underline text-inherit hover:text-main-color">
                                <p>
                                    {{ $contacto->email }}
                                </p>
                            </a>
                        @endif
                        @if ($contacto->telefono)
                            <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                                class="block no-underline text-inherit hover:text-main-color">
                                <p>
                                    {{ $contacto->telefono }} / {{ $contacto->telefono2 }}
                                </p>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#323232]">
        <div
            class="flex flex-row justify-between items-center max-w-[90%] lg:max-w-[1224px] mx-auto py-3 text-xs lg:text-sm">
            <p>{{ __('© Copyright 2025 Tabiplast. Todos los derechos reservados') }}</p>
            <p>{{ __('By') }}
                <a href="https://osole.com.ar/#" class="font-bold hover:underline hover:text-blue-600">
                    Osole
                </a>
            </p>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('newsletterForm');
            const messageDiv = document.getElementById('newsletterMessage');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Obtenemos el token CSRF del meta tag en lugar del input
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const email = this.querySelector('input[name="email"]')
                        .value; // Mostrar mensaje de carga
                    messageDiv.innerHTML = '<span class="text-blue-300">{{ __('Enviando...') }}</span>';

                    // Usar Axios que ya está disponible en la página
                    axios.post('{{ route('newsletter.store') }}', {
                            email: email,
                            _token: token
                        })
                        .then(function(response) {
                            // Éxito - resetear el formulario y mostrar mensaje de éxito
                            messageDiv.innerHTML =
                                '<span class="text-green-500">{{ __('Suscripción exitosa') }}</span>';
                            form.reset();

                            // Ocultar el mensaje después de 3 segundos
                            setTimeout(function() {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        })
                        .catch(function(error) {
                            console.error('Error:', error);

                            // Manejo de diferentes tipos de errores
                            if (error.response) {
                                // El servidor respondió con un código de estado diferente de 2xx
                                if (error.response.data.message) {
                                    messageDiv.innerHTML = '<span class="text-red-500">' + error
                                        .response.data.message + '</span>';
                                } else {
                                    messageDiv.innerHTML =
                                        '<span class="text-red-500">Error al procesar la solicitud</span>';
                                }
                            } else if (error.request) {
                                // La solicitud se realizó pero no se recibió respuesta
                                messageDiv.innerHTML =
                                    '<span class="text-red-500">No se recibió respuesta del servidor</span>';
                            } else {
                                // Algo sucedió al configurar la solicitud
                                messageDiv.innerHTML =
                                    '<span class="text-red-500">Error al enviar la solicitud</span>';
                            }

                            // Ocultar el mensaje de error después de 3 segundos
                            setTimeout(function() {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        });
                });
            }
        });
    </script>
</footer>
