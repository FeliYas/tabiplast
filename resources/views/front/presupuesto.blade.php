@extends('layouts.guest')

@section('title', __('Presupuesto'))

@section('content')
    <div>
        <div class="overflow-hidden">
            <div class="relative max-w-[90%] lg:max-w-[1224px] mx-auto">
                <div class="absolute top-6 left-0">
                    <div class="flex gap-1 text-xs">
                        <a href="{{ route('home') }}" class="font-bold hover:underline">{{ __('Inicio') }}</a>
                        <span>></span>
                        <a href="{{ route('presupuesto') }}" class="hover:underline">{{ __('Presupuesto') }}</a>
                    </div>
                </div>
                <div class="absolute top-40">
                    <h2 class="font-bold text-[40px]">{{ __('Presupuesto') }}</h2>
                </div>
            </div>
            <img src="{{ $banner->path }}" alt="{{ __('Banner de Contacto') }}" class="w-full h-[310px] object-cover">
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
            <div class="lg:px-26"> 
                <form action="{{ route('presupuesto.enviar') }}" method="POST" class="w-full text-black" id="contactForm"
                    enctype="multipart/form-data">
                    @csrf
                    <h2 class="font-bold text-2xl text-black mb-5">{{ __('Datos personales') }}</h2>
                    <hr class="border-gray-200 pb-7">
                    <div class="grid lg:grid-cols-2 gap-6 mb-6">
                        <div class="w-full relative">
                            <label for="nombre" class="block mb-2">{{ __('Nombre y Apellido') }} *</label>
                            <input type="text" name="nombre" id="nombre" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                        <div class="w-full relative">
                            <label for="email" class="block mb-2">{{ __('Email') }} *</label>
                            <input type="email" name="email" id="email" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div class="w-full relative">
                            <label for="telefono" class="block mb-2">{{ __('Telefono') }} *</label>
                            <input type="text" name="telefono" id="telefono" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                        <div class="w-full relative">
                            <label for="empresa" class="block mb-2">{{ __('Empresa') }}</label>
                            <input type="text" name="empresa" id="empresa"
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <h2 class="font-bold text-2xl text-black mb-5 mt-15">{{ __('Consulta') }}</h2>
                    <hr class="border-gray-200 pb-7">
                    <div class="grid lg:grid-cols-2 gap-6 mb-6">
                        <div class="w-full relative">
                            <label for="producto" class="block mb-2">{{ __('Producto') }} *</label>
                            <select name="producto" id="producto" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 bg-white focus:border-main-color focus:outline-none transition-colors">
                                <option value="" disabled selected>Seleccionar producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full relative">
                            <label for="cantidad" class="block mb-2">{{ __('Cantidad') }}</label>
                            <input type="number" name="cantidad" id="cantidad"
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="w-full py-2 relative">
                            <label for="mensaje" class="block mb-2">{{ __('Aclaraciones / Observaciones') }}</label>
                            <textarea name="mensaje" id="mensaje" cols="30" rows="10" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full px-4 py-2 h-[157px] focus:border-main-color focus:outline-none transition-colors"></textarea>
                        </div>
                        <div class="w-full flex flex-col items-start justify-between gap-10 lg:mb-3">
                            <div class="w-full relative">
                                <label for="archivo" class="block mb-2">{{ __('Adjuntar archivo') }}</label>
                                <div class="relative">
                                    <input type="file" name="archivo" id="archivo" class="hidden"
                                        onchange="updateFileName()">
                                    <label for="archivo"
                                        class="flex items-center border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 cursor-pointer">
                                        <span id="archivo-label" class="text-gray-400 flex-1 text-sm">Seleccionar
                                            archivo</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <g opacity="0.4">
                                                <path
                                                    d="M21 15V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V15M17 8L12 3M12 3L7 8M12 3V15"
                                                    stroke="#231F20" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </label>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row items-center justify-between w-full">
                                <div>
                                    <span class="mt-8">* Datos obligatorios</span>
                                </div>
                                <div class="mt-auto py-1 flex flex-col items-center justify-center ">
                                    <!-- Agregamos campo oculto para almacenar el token de reCAPTCHA -->
                                    <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                                    <button type="button" id="submitBtn"
                                        class="btn-primary w-full lg:w-[287px] relative">
                                        <span id="submitText"
                                            class="inline-block">{{ __('Enviar solicitud de presupuesto') }}</span>
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
                    </div>
                </form>
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
    <script>
        // Archivo personalizado
        function updateFileName() {
            const input = document.getElementById('archivo');
            const label = document.getElementById('archivo-label');
            if (input.files && input.files.length > 0) {
                label.textContent = input.files[0].name;
                label.classList.remove('text-gray-400');
                label.classList.add('text-black');
            } else {
                label.textContent = 'Seleccionar archivo';
                label.classList.remove('text-black');
                label.classList.add('text-gray-400');
            }
        }
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

        /* Estilo para el input de archivo custom */
        #archivo-label {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
