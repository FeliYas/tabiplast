@extends('layouts.guest')
@section('meta')
    <meta name="{{ $metadatos->seccion }}" content="{{ $metadatos->keyword }}">
@endsection

@section('title', __('Contacto'))

@section('content')
    <div class="relative">
        <div class="hidden lg:block w-full bg-[#F2F2F2] opacity-[0.643]">
            <div class="max-w-[90%] lg:max-w-[1224px] mx-auto text-black text-[13px] font-medium py-2">
                <div class="flex gap-1">
                    <a href="{{ route('home') }}" class="hover:underline">{{ __('INICIO') }}</a>
                    <span>|</span>
                    <a href="{{ route('contacto') }}" class="hover:underline">{{ __('CONTACTO') }}</a>
                </div>
            </div>
        </div>
        <div>
            <div class="w-full h-[390px]">
                {!! preg_replace(['/width="[^"]*"/', '/height="[^"]*"/'], ['width="100%"', 'height="100%"'], $mapa) !!}
            </div>
        </div>
        <div class="max-w-[90%] lg:max-w-[1224px] mx-auto py-15 flex flex-col lg:flex-row gap-10 lg:gap-30">
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

            <div class="lg:w-1/3 text-black flex flex-col gap-5">
                @foreach ($contactos as $contacto)
                    @if ($contacto->direccion)
                        <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                            class="no-underline text-inherit hover:text-main-color flex gap-3 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 11 16"
                                fill="none">
                                <path
                                    d="M9.85502 2.63696C9.40643 1.85062 8.76132 1.19426 7.98283 0.732178C7.20434 0.270096 6.31918 0.0181521 5.41404 0.000976562C5.33504 0.000976562 5.25604 0.000976562 5.17704 0.000976562C4.27173 0.0179802 3.38639 0.269844 2.60771 0.731934C1.82903 1.19402 1.1837 1.85048 0.735026 2.63696C0.265223 3.43863 0.0117623 4.34861 -0.000508863 5.27771C-0.0127801 6.20681 0.216613 7.12316 0.66508 7.93695L4.48405 14.928L4.48905 14.937C4.57025 15.0789 4.68751 15.1969 4.82896 15.2789C4.97041 15.3609 5.13101 15.4041 5.29454 15.4041C5.45806 15.4041 5.61866 15.3609 5.76011 15.2789C5.90156 15.1969 6.01888 15.0789 6.10008 14.937L6.10502 14.928L9.92503 7.93695C10.3735 7.12316 10.6028 6.20681 10.5906 5.27771C10.5783 4.34861 10.3248 3.43863 9.85502 2.63696ZM5.29502 6.97897C4.86663 6.97897 4.44791 6.85193 4.09172 6.61392C3.73552 6.37592 3.45786 6.03763 3.29392 5.64185C3.12999 5.24606 3.08712 4.81057 3.17069 4.39041C3.25427 3.97025 3.46055 3.58429 3.76347 3.28137C4.06639 2.97845 4.45231 2.77217 4.87248 2.6886C5.29264 2.60502 5.72816 2.64789 6.12394 2.81183C6.51973 2.97577 6.85798 3.25339 7.09599 3.60959C7.33399 3.96579 7.46104 4.38456 7.46104 4.81296C7.46051 5.38725 7.23212 5.93787 6.82603 6.34396C6.41994 6.75005 5.86932 6.97844 5.29502 6.97897Z"
                                    fill="#E12328" />
                            </svg>
                            <p>
                                {{ $contacto->direccion }}
                            </p>
                        </a>
                    @endif
                    @if ($contacto->email)
                        <a href="mailto:{{ $contacto->email }}"
                            class="no-underline text-inherit hover:text-main-color flex gap-2 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="15" viewBox="0 0 19 15"
                                fill="none">
                                <path d="M18.1301 2.60303V11.542L12.4102 7.16501L18.1301 2.60303Z" fill="#E12328" />
                                <path d="M5.72009 7.16501L0 11.542V2.60303L5.72009 7.16501Z" fill="#E12328" />
                                <path
                                    d="M18.0911 1.09198C18.0489 0.790956 17.8999 0.515102 17.6714 0.314667C17.4429 0.114231 17.15 0.00257279 16.8461 0H1.28308C0.979068 0.00236632 0.685959 0.11395 0.457397 0.314423C0.228836 0.514895 0.0800688 0.79087 0.0380859 1.09198L9.06409 7.83197L18.0911 1.09198Z"
                                    fill="#E12328" />
                                <path
                                    d="M9.41797 9.13702C9.31307 9.20577 9.19036 9.24237 9.06494 9.24237C8.93953 9.24237 8.81693 9.20577 8.71204 9.13702L6.896 7.93701L0.0410156 13.037C0.0844963 13.3362 0.233598 13.6098 0.461426 13.8085C0.689254 14.0071 0.98069 14.1177 1.28296 14.1201H16.8459C17.1482 14.1175 17.4396 14.0069 17.6674 13.8083C17.8951 13.6097 18.0443 13.3361 18.088 13.037L11.233 7.93701L9.41797 9.13702Z"
                                    fill="#E12328" />
                            </svg>
                            <p>
                                {{ $contacto->email }}
                            </p>
                        </a>
                    @endif
                    @if ($contacto->telefono)
                        <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                            class="no-underline text-inherit hover:text-main-color flex gap-3 items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="16" viewBox="0 0 11 16"
                                fill="none">
                                <path
                                    d="M9.52921 10.7092C9.46729 10.5721 9.37659 10.4499 9.26334 10.3509C9.15009 10.2519 9.01697 10.1784 8.87284 10.1353C8.72871 10.0923 8.57701 10.0807 8.42801 10.1014C8.27902 10.122 8.13615 10.1745 8.00919 10.2552C7.54819 10.5012 7.08714 10.7482 6.63114 11.0022C6.60866 11.0203 6.58282 11.0339 6.55509 11.042C6.52736 11.0501 6.49836 11.0527 6.46964 11.0495C6.44092 11.0464 6.41303 11.0375 6.38773 11.0236C6.36243 11.0096 6.34017 10.9908 6.32218 10.9682C6.12918 10.7742 5.91514 10.5992 5.73514 10.3962C4.91831 9.43835 4.26436 8.35293 3.79923 7.18319C3.54668 6.60658 3.37829 5.99668 3.29923 5.37218C3.28649 5.3188 3.29341 5.2626 3.31876 5.21392C3.34411 5.16524 3.38612 5.12733 3.43717 5.10717C3.89517 4.87017 4.34716 4.62118 4.80216 4.37218C4.94488 4.31137 5.07245 4.21981 5.1757 4.10402C5.27894 3.98824 5.35532 3.85107 5.39945 3.70235C5.44358 3.55363 5.45433 3.397 5.43094 3.24364C5.40756 3.09028 5.35065 2.94398 5.2642 2.81517C5.0702 2.45117 4.87421 2.09418 4.68021 1.73018C4.48621 1.36618 4.28024 0.983178 4.08024 0.613178C4.01728 0.476882 3.92596 0.355566 3.81241 0.257343C3.69887 0.159121 3.56561 0.0862477 3.42167 0.0435674C3.27773 0.000887185 3.12643 -0.0106071 2.9777 0.00984551C2.82896 0.0302981 2.68632 0.0822108 2.55924 0.162159C2.09524 0.407159 1.64418 0.662163 1.17618 0.904163C0.760079 1.11199 0.440257 1.47236 0.283239 1.91018C0.034353 2.63034 -0.0520984 3.39666 0.0301874 4.15416C0.150882 5.71372 0.541726 7.24043 1.18522 8.66616C2.01357 10.5991 3.24346 12.3338 4.79325 13.7552C5.4757 14.4221 6.28544 14.9448 7.17423 15.2922C7.46736 15.4167 7.78595 15.4694 8.10355 15.4459C8.42116 15.4224 8.72853 15.3234 9.00016 15.1572C9.40616 14.9072 9.84324 14.6992 10.2622 14.4702C10.403 14.4087 10.5287 14.3174 10.6308 14.2026C10.7328 14.0878 10.8087 13.9522 10.8532 13.8052C10.8977 13.6582 10.9097 13.5033 10.8885 13.3512C10.8672 13.1991 10.8132 13.0534 10.7301 12.9242C10.3301 12.1842 9.93019 11.4455 9.53019 10.7082L9.52921 10.7092Z"
                                    fill="#E12328" />
                            </svg>
                            <p>
                                {{ $contacto->telefono }} / {{ $contacto->telefono2 }}
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
                        <div class="w-full relative"> <input type="text" name="nombre" id="nombre"
                                placeholder="{{ __('Nombre') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                        <div class="w-full relative"> <input type="text" name="apellido" id="apellido"
                                placeholder="{{ __('Apellido') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div class="w-full relative"> <input type="email" name="email" id="email"
                                placeholder="{{ __('Email') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>

                        <div class="w-full relative"> <input type="text" name="empresa" id="empresa"
                                placeholder="{{ __('Empresa') }}"
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2 gap-6">
                        <div class="w-full relative"> <input type="text" name="localidad" id="localidad"
                                placeholder="{{ __('Localidad') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>

                        <div class="w-full relative"> <input type="text" name="pais" id="pais"
                                placeholder="{{ __('País') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full h-12 px-4 focus:border-main-color focus:outline-none transition-colors">
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-6">
                        <div class="w-full py-2 relative">
                            <textarea name="mensaje" id="mensaje" cols="30" rows="10" placeholder="{{ __('Mensaje') }}" required
                                class="border border-[#B7B7B7] rounded-[10px] w-full px-4 py-2 h-[158px] focus:border-main-color focus:outline-none transition-colors"></textarea>
                        </div>

                        <div class="w-full flex items-end justify-center gap-10 lg:mb-3">
                            <div class="mt-auto py-1 flex justify-center ">

                                <!-- Agregamos campo oculto para almacenar el token de reCAPTCHA -->
                                <input type="hidden" name="g-recaptcha-response" id="recaptchaResponse">
                                <button type="button" id="submitBtn" class="btn-primary w-full lg:w-[392px] relative">
                                    <span id="submitText" class="inline-block">{{ __('ENVIAR') }}</span>
                                    <span id="loadingIndicator"
                                        class="hidden absolute inset-0 items-center justify-center">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24">
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
    <!-- Script de reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LfnB0orAAAAADtZRBlFSM2toZh1dQpGKGMF-dCF"></script>
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
                    grecaptcha.execute('6LfnB0orAAAAADtZRBlFSM2toZh1dQpGKGMF-dCF', {
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
            border-color: #E12328 !important;
            box-shadow: 0 0 0 1px rgba(225, 35, 40, 0.2);
        }
    </style>
@endsection
