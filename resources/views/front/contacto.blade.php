@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Contacto'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('contacto') }}" class="hover:underline">{{ __('Contacto') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class=" font-bold text-[40px]">{{ __('Contacto') }}</h2>
                </div>
            </div>
            <img src="{{ $contacto->banner }}" alt="{{ __('Banner de Contacto') }}" class="w-full h-[310px] object-cover">
        </div>

        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-16 flex flex-col gap-10 lg:gap-12">
            <!-- Mensajes de feedback -->
            @if (session('success'))
                <div id="successMessage"
                    class="fixed top-6 right-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __(session('success')) }}</span>
                    <button type="button" class="ml-auto" onclick="document.getElementById('successMessage').remove()">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        const message = document.getElementById('successMessage');
                        if (message) {
                            message.style.opacity = '0';
                            setTimeout(() => message.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif
            @if (session('error'))
                <div id="errorMessage"
                    class="fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __(session('error')) }}</span>
                    <button type="button" class="ml-auto" onclick="document.getElementById('errorMessage').remove()">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        const message = document.getElementById('errorMessage');
                        if (message) {
                            message.style.opacity = '0';
                            setTimeout(() => message.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif
            @if ($errors->any())
                <div id="validationErrors"
                    class="fixed top-6 right-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50 shadow-lg transition-opacity duration-500">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-bold">{{ __('Por favor corrija los siguientes errores:') }}</span>
                        <button type="button" class="ml-auto"
                            onclick="document.getElementById('validationErrors').remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ __($error) }}</li>
                        @endforeach
                    </ul>
                </div>
                <script>
                    setTimeout(function() {
                        const message = document.getElementById('validationErrors');
                        if (message) {
                            message.style.opacity = '0';
                            setTimeout(() => message.remove(), 500);
                        }
                    }, 7000);
                </script>
            @endif
            <!-- Fin mensajes de feedback -->
            <div>
                <h2 class="font-bold text-[32px] text-black">{{ __('Contactate con nosotros') }}</h2>
            </div>
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-1/3 text-black flex flex-col gap-5">
                    @foreach ($contactos as $contacto)
                        @if ($contacto->direccion)
                            <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                                class="no-underline text-inherit hover:text-main-color flex gap-3 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 20 20"
                                    fill="none">
                                    <path
                                        d="M16.6666 8.33333C16.6666 13.3333 9.99992 18.3333 9.99992 18.3333C9.99992 18.3333 3.33325 13.3333 3.33325 8.33333C3.33325 6.56522 4.03563 4.86953 5.28587 3.61929C6.53612 2.36905 8.23181 1.66667 9.99992 1.66667C11.768 1.66667 13.4637 2.36905 14.714 3.61929C15.9642 4.86953 16.6666 6.56522 16.6666 8.33333Z"
                                        stroke="#F79E10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path
                                        d="M10 10.8333C11.3807 10.8333 12.5 9.71405 12.5 8.33333C12.5 6.95262 11.3807 5.83333 10 5.83333C8.61929 5.83333 7.5 6.95262 7.5 8.33333C7.5 9.71405 8.61929 10.8333 10 10.8333Z"
                                        stroke="#F79E10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p>
                                    {{ $contacto->direccion }}
                                </p>
                            </a>
                        @endif
                        @if ($contacto->telefono)
                            <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                                class="no-underline text-inherit hover:text-main-color flex gap-3 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                    fill="none">
                                    <g clip-path="url(#clip0_9603_1371)">
                                        <path
                                            d="M18.3334 14.1V16.6C18.3344 16.8321 18.2868 17.0618 18.1939 17.2745C18.1009 17.4871 17.9645 17.678 17.7935 17.8349C17.6225 17.9918 17.4206 18.1112 17.2007 18.1856C16.9809 18.2599 16.7479 18.2876 16.5168 18.2667C13.9525 17.988 11.4893 17.1118 9.32511 15.7083C7.31163 14.4289 5.60455 12.7218 4.32511 10.7083C2.91676 8.53434 2.04031 6.05916 1.76677 3.48334C1.74595 3.25289 1.77334 3.02064 1.84719 2.80136C1.92105 2.58208 2.03975 2.38058 2.19575 2.20969C2.35174 2.0388 2.54161 1.90226 2.75327 1.80877C2.96492 1.71528 3.19372 1.66689 3.42511 1.66667H5.92511C6.32953 1.66269 6.7216 1.8059 7.02824 2.06961C7.33488 2.33332 7.53517 2.69954 7.59177 3.1C7.69729 3.90006 7.89298 4.68561 8.17511 5.44167C8.28723 5.73994 8.31149 6.0641 8.24503 6.37574C8.17857 6.68737 8.02416 6.97343 7.80011 7.2L6.74177 8.25833C7.92807 10.3446 9.65549 12.072 11.7418 13.2583L12.8001 12.2C13.0267 11.9759 13.3127 11.8215 13.6244 11.7551C13.936 11.6886 14.2602 11.7129 14.5584 11.825C15.3145 12.1071 16.1001 12.3028 16.9001 12.4083C17.3049 12.4654 17.6746 12.6693 17.9389 12.9812C18.2032 13.2932 18.3436 13.6913 18.3334 14.1Z"
                                            stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_9603_1371">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <p>
                                    {{ $contacto->telefono }}
                                </p>
                            </a>
                        @endif
                        @if ($contacto->email)
                            <a href="mailto:{{ $contacto->email }}"
                                class="no-underline text-inherit hover:text-main-color flex gap-2 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 20 20" fill="none">
                                    <path
                                        d="M16.6667 3.33334H3.33341C2.41294 3.33334 1.66675 4.07953 1.66675 5V15C1.66675 15.9205 2.41294 16.6667 3.33341 16.6667H16.6667C17.5872 16.6667 18.3334 15.9205 18.3334 15V5C18.3334 4.07953 17.5872 3.33334 16.6667 3.33334Z"
                                        stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path
                                        d="M18.3334 5.83334L10.8584 10.5833C10.6011 10.7445 10.3037 10.83 10.0001 10.83C9.69648 10.83 9.39902 10.7445 9.14175 10.5833L1.66675 5.83334"
                                        stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                                <p>
                                    {{ $contacto->email }}
                                </p>
                            </a>
                        @endif
                    @endforeach
                </div>
                <div class="lg:w-2/3">
                    <form action="{{ route('contacto.enviar') }}" method="POST" class="w-full space-y-6 text-black"
                        id="contactForm">
                        @csrf
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="w-full relative">
                                <label for="nombre" class="block mb-1">{{ __('Nombre') }} *</label>
                                <input type="text" name="nombre" id="nombre" required
                                    class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                            </div>
                            <div class="w-full relative">
                                <label for="apellido" class="block mb-1">{{ __('Apellido') }} *</label>
                                <input type="text" name="apellido" id="apellido" required
                                    class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-6">
                            <div class="w-full relative">
                                <label for="email" class="block mb-1">{{ __('Email') }} *</label>
                                <input type="email" name="email" id="email" required
                                    class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                            </div>
                            <div class="w-full relative">
                                <label for="celular" class="block mb-1">{{ __('Celular') }}</label>
                                <input type="text" name="celular" id="celular"
                                    class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                            </div>
                        </div>
                        <div class="flex flex-col lg:flex-row gap-6">
                            <div class="w-full py-2 relative">
                                <label for="mensaje" class="block mb-1">{{ __('Mensaje') }} *</label>
                                <textarea name="mensaje" id="mensaje" cols="30" rows="10" required
                                    class="border border-[#B7B7B7] rounded-[10px] w-full px-4 py-2 h-[158px] focus:border-main-color focus:outline-none transition-colors"></textarea>
                            </div>
                            <div class="w-full flex flex-col items-start justify-between gap-10 lg:mb-3">
                                <span class="mt-8">* Datos obligatorios</span>
                                <div class="mt-auto py-1 flex flex-col items-center justify-center ">
                                    <!-- Agregamos campo oculto para almacenar el token de reCAPTCHA -->
                                    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                                    <button type="button" id="submitBtn"
                                        class="btn-primary w-full lg:w-[392px] relative">
                                        <span id="submitText" class="inline-block">{{ __('Enviar consulta') }}</span>
                                        <span id="loadingIndicator"
                                            class="hidden absolute inset-0 items-center justify-center">
                                            <svg class="animate-spin h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span class="ml-2">{{ __('Enviando...') }}</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto mb-33">
            <div class="w-full h-[570px] rounded-[10px] overflow-hidden">
                {!! preg_replace(['/width="[^"]*"/', '/height="[^"]*"/'], ['width="100%"', 'height="100%"'], $mapa) !!}
            </div>
        </div>
    </div>
    <!-- Script de reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=6Lfz0lYrAAAAAAAn3kjH-eNiuYF2XN1IYiyrVMP2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar evento al botón de envío
            document.getElementById('submitBtn').addEventListener('click', handleSubmit);

            function handleSubmit(e) {
                e.preventDefault();

                // Mostrar indicador de carga
                const submitText = document.getElementById('submitText');
                const loadingIndicator = document.getElementById('loadingIndicator');
                const submitBtn = document.getElementById('submitBtn');

                // Desactivar el botón y mostrar el indicador de carga
                submitBtn.disabled = true;
                submitText.classList.add('opacity-0');
                loadingIndicator.classList.remove('hidden');
                loadingIndicator.classList.add('flex');

                // Activar reCAPTCHA
                grecaptcha.ready(function() {
                    grecaptcha.execute('6Lfz0lYrAAAAAAAn3kjH-eNiuYF2XN1IYiyrVMP2', {
                        action: 'submit_contact'
                    }).then(function(token) {
                        // Guardar el token en el campo oculto
                        document.getElementById('recaptchaResponse').value = token;

                        // Enviar el formulario
                        document.getElementById('contactForm').submit();
                    }).catch(function(error) {
                        // Restaurar el botón en caso de error
                        submitBtn.disabled = false;
                        submitText.classList.remove('opacity-0');
                        loadingIndicator.classList.add('hidden');
                        loadingIndicator.classList.remove('flex');

                        console.error('Error de reCAPTCHA:', error);
                    });
                });
            }
        });
    </script>

    <style>
        /* Estilo para el placeholder */
        ::placeholder {
            color: #666;
            opacity: 1;
            transition: opacity 0.2s;
        }

        /* Cuando el input está enfocado, hacemos que el placeholder sea más transparente */
        input:focus::placeholder,
        textarea:focus::placeholder {
            opacity: 0.5;
        }

        /* Animación al enfocar los campos */
        input:focus,
        textarea:focus {
            border-color: #c87800 !important;
            box-shadow: 0 0 0 1px rgba(225, 35, 40, 0.2);
        }
    </style>
@endsection
