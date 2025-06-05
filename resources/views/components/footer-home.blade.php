@props(['logos', 'contactos'])

<footer class="text-white">
    <div class="bg-[#231F20]">
        <div
            class="flex flex-col lg:flex-row gap-10 lg:gap-0 justify-between max-w-[80%] xl:max-w-[1224px] mx-auto pb-12 pt-18">
            <div class="lg:w-1/4 flex justify-center lg:justify-start">
                <img src="{{ asset($logos[0]->path) }}" alt="logo"
                    class="object-contain h-auto max-h-16 w-full max-w-[230px]">
            </div>


            <div class="lg:w-1/4 text-center lg:text-left">
                <h3 class="font-semibold text-[15px] text-white">{{ __('Secciones') }}</h3>
                <div
                    class="flex flex-row mt-4 font-light justify-between lg:justify-none lg:gap-x-8 items-center lg:items-left">
                    <div class="flex flex-col gap-y-1">
                        <a href="{{ route('nosotros') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Nosotros') }}</a>
                        <a href="{{ route('categorias') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Productos') }}</a>
                        <a href="{{ route('internacional') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Internacional') }}</a>
                    </div>
                    <div class="flex flex-col gap-y-1">
                        <a href="{{ route('novedades') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Novedades') }}</a>
                        <a href="{{ route('presupuesto') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Solicitud de presupuesto') }}</a>
                        <a href="{{ route('contacto') }}"
                            class="hover:text-[#F79E1C] transition-colors duration-300">{{ __('Contacto') }}</a>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 flex flex-col items-center text-center lg:text-start gap-8">
                <div class="flex flex-col items-center gap-4">
                    <div>
                        <h3 class="font-semibold text-[15px] text-white w-[260px]">{{ __('Suscribete al Newsletter') }}
                        </h3>
                    </div>
                    <form id="newsletterForm" class="w-full flex flex-col items-center">
                        @csrf
                        <div
                            class="w-[276px] h-[39px] border border-white rounded-[20px] flex justify-between text-white">
                            <input type="email" name="email" placeholder="{{ __('Email') }}"
                                class="bg-transparent border-none outline-none text-xs p-3 w-full" required>
                            <button type="submit"
                                class="flex items-center justify-center rounded-r-[20px] px-3 cursor-pointer transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none">
                                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="#F79E10" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div id="newsletterMessage" class="text-xs mt-2"></div>
                    </form>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div>
                        <h3 class="font-semibold text-[15px] text-white w-[260px]">{{ __('Redes sociales') }}</h3>
                    </div>
                    <div class="flex gap-3 justify-center lg:justify-start w-full">
                        @foreach ($contactos as $contacto)
                            @if ($contacto->facebook)
                                <a href="{{ $contacto->facebook }}"
                                    class="group hover:text-[#F79E1C] transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M14.9997 1.66675H12.4997C11.3946 1.66675 10.3348 2.10573 9.5534 2.88714C8.772 3.66854 8.33301 4.72835 8.33301 5.83341V8.33341H5.83301V11.6667H8.33301V18.3334H11.6663V11.6667H14.1663L14.9997 8.33341H11.6663V5.83341C11.6663 5.6124 11.7541 5.40044 11.9104 5.24416C12.0667 5.08788 12.2787 5.00008 12.4997 5.00008H14.9997V1.66675Z"
                                            fill="currentColor" />
                                    </svg>
                                </a>
                            @endif
                            @if ($contacto->instagram)
                                <a href="{{ $contacto->instagram }}"
                                    class="group hover:text-[#F79E1C] transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_9778_455)">
                                            <path
                                                d="M14.5837 5.41675H14.592M5.83366 1.66675H14.167C16.4682 1.66675 18.3337 3.53223 18.3337 5.83341V14.1667C18.3337 16.4679 16.4682 18.3334 14.167 18.3334H5.83366C3.53247 18.3334 1.66699 16.4679 1.66699 14.1667V5.83341C1.66699 3.53223 3.53247 1.66675 5.83366 1.66675ZM13.3337 9.47508C13.4365 10.1686 13.318 10.8769 12.9951 11.4993C12.6722 12.1216 12.1613 12.6263 11.535 12.9415C10.9087 13.2567 10.199 13.3664 9.50681 13.255C8.8146 13.1436 8.17513 12.8168 7.67936 12.321C7.18359 11.8253 6.85677 11.1858 6.74538 10.4936C6.63399 9.80137 6.74371 9.09166 7.05893 8.46539C7.37415 7.83913 7.87881 7.3282 8.50115 7.00528C9.12348 6.68237 9.83179 6.5639 10.5253 6.66675C11.2328 6.77165 11.8877 7.1013 12.3934 7.607C12.8991 8.1127 13.2288 8.76764 13.3337 9.47508Z"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_9778_455">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            @endif
                            @if ($contacto->linkedin)
                                <a href="{{ $contacto->linkedin }}"
                                    class="ml-1 group hover:text-[#F79E1C] transition-colors duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_9798_964)">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M4.16634 0.833252C3.28229 0.833252 2.43444 1.18444 1.80932 1.80956C1.1842 2.43468 0.833008 3.28253 0.833008 4.16659V15.8333C0.833008 16.7173 1.1842 17.5652 1.80932 18.1903C2.43444 18.8154 3.28229 19.1666 4.16634 19.1666H15.833C16.7171 19.1666 17.5649 18.8154 18.19 18.1903C18.8152 17.5652 19.1663 16.7173 19.1663 15.8333V4.16659C19.1663 3.28253 18.8152 2.43468 18.19 1.80956C17.5649 1.18444 16.7171 0.833252 15.833 0.833252H4.16634ZM5.17051 6.59159C5.54734 6.59159 5.90873 6.44189 6.17519 6.17543C6.44165 5.90897 6.59134 5.54758 6.59134 5.17075C6.59134 4.79392 6.44165 4.43253 6.17519 4.16607C5.90873 3.89961 5.54734 3.74992 5.17051 3.74992C4.79368 3.74992 4.43229 3.89961 4.16583 4.16607C3.89937 4.43253 3.74967 4.79392 3.74967 5.17075C3.74967 5.54758 3.89937 5.90897 4.16583 6.17543C4.43229 6.44189 4.79368 6.59159 5.17051 6.59159ZM6.59051 16.2499V7.72742H3.74967V16.2499H6.59051ZM10.2838 7.72742H7.72717V16.2499H10.2838V11.1083C10.613 10.5733 11.1813 9.99992 11.988 9.99992C13.1247 9.99992 13.4088 11.1366 13.4088 11.7049V16.2499H16.2497V11.7049C16.2497 10.1816 15.5855 7.72742 13.1247 7.72742C11.5597 7.72742 10.6913 8.29825 10.283 8.83325L10.2838 7.72742Z"
                                                fill="currentColor" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_9798_964">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="lg:w-1/4 flex flex-col items-center">
                <div class="text-left w-full">
                    <h3 class="font-semibold text-[15px] text-white text-center lg:text-left">{{ __('Contacto') }}</h3>
                </div>
                <div
                    class="flex flex-col gap-4 items-center lg:items-start justify-center mt-4 text-center lg:text-left text-sm lg:text-base">
                    @foreach ($contactos as $contacto)
                        @if ($contacto->direccion)
                            <a href="https://maps.google.com/?q={{ urlencode($contacto->direccion) }}" target="_blank"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M16.6663 8.33341C16.6663 13.3334 9.99967 18.3334 9.99967 18.3334C9.99967 18.3334 3.33301 13.3334 3.33301 8.33341C3.33301 6.5653 4.03539 4.86961 5.28563 3.61937C6.53587 2.36913 8.23156 1.66675 9.99967 1.66675C11.7678 1.66675 13.4635 2.36913 14.7137 3.61937C15.964 4.86961 16.6663 6.5653 16.6663 8.33341Z"
                                            stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M10 10.8333C11.3807 10.8333 12.5 9.71396 12.5 8.33325C12.5 6.95254 11.3807 5.83325 10 5.83325C8.61929 5.83325 7.5 6.95254 7.5 8.33325C7.5 9.71396 8.61929 10.8333 10 10.8333Z"
                                            stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <p class="hover:text-[#F79E1C] transition-colors duration-300">
                                        {{ $contacto->direccion }}
                                    </p>
                                </div>
                            </a>
                        @endif
                        @if ($contacto->email)
                            <a href="mailto:{{ $contacto->email }}"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <g clip-path="url(#clip0_9778_440)">
                                            <path
                                                d="M18.3332 14.0999V16.5999C18.3341 16.832 18.2866 17.0617 18.1936 17.2744C18.1006 17.487 17.9643 17.6779 17.7933 17.8348C17.6222 17.9917 17.4203 18.1112 17.2005 18.1855C16.9806 18.2599 16.7477 18.2875 16.5165 18.2666C13.9522 17.988 11.489 17.1117 9.32486 15.7083C7.31139 14.4288 5.60431 12.7217 4.32486 10.7083C2.91651 8.53426 2.04007 6.05908 1.76653 3.48325C1.7457 3.25281 1.77309 3.02055 1.84695 2.80127C1.9208 2.58199 2.03951 2.38049 2.1955 2.2096C2.3515 2.03871 2.54137 1.90218 2.75302 1.80869C2.96468 1.7152 3.19348 1.6668 3.42486 1.66658H5.92486C6.32928 1.6626 6.72136 1.80582 7.028 2.06953C7.33464 2.33324 7.53493 2.69946 7.59153 3.09992C7.69705 3.89997 7.89274 4.68552 8.17486 5.44158C8.28698 5.73985 8.31125 6.06401 8.24478 6.37565C8.17832 6.68729 8.02392 6.97334 7.79986 7.19992L6.74153 8.25825C7.92783 10.3445 9.65524 12.072 11.7415 13.2583L12.7999 12.1999C13.0264 11.9759 13.3125 11.8215 13.6241 11.755C13.9358 11.6885 14.2599 11.7128 14.5582 11.8249C15.3143 12.107 16.0998 12.3027 16.8999 12.4083C17.3047 12.4654 17.6744 12.6693 17.9386 12.9812C18.2029 13.2931 18.3433 13.6912 18.3332 14.0999Z"
                                                stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_9778_440">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <p class="hover:text-[#F79E1C] transition-colors duration-300">
                                        {{ $contacto->email }}
                                    </p>
                                </div>
                            </a>
                        @endif
                        @if ($contacto->telefono)
                            <a href="tel:{{ preg_replace('/\s+/', '', $contacto->telefono) }}"
                                class="block no-underline text-inherit hover:text-main-color transition-colors duration-300">
                                <div class="flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none">
                                        <path
                                            d="M16.667 3.33325H3.33366C2.41318 3.33325 1.66699 4.07944 1.66699 4.99992V14.9999C1.66699 15.9204 2.41318 16.6666 3.33366 16.6666H16.667C17.5875 16.6666 18.3337 15.9204 18.3337 14.9999V4.99992C18.3337 4.07944 17.5875 3.33325 16.667 3.33325Z"
                                            stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M18.3337 5.83325L10.8587 10.5833C10.6014 10.7444 10.3039 10.8299 10.0003 10.8299C9.69673 10.8299 9.39927 10.7444 9.14199 10.5833L1.66699 5.83325"
                                            stroke="#F79E10" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <p class="hover:text-[#F79E1C] transition-colors duration-300">
                                        {{ $contacto->telefono }}
                                    </p>
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="bg-[#201C1D]">
        <div
            class="flex flex-row justify-between items-center max-w-[90%] lg:max-w-[1224px] mx-auto py-3 text-xs lg:text-sm">
            <p>{{ __('© Copyright 2025 Tabiplast. Todos los derechos reservados') }}</p>
            <p>{{ __('By') }}
                <a href="https://osole.com.ar/#"
                    class="font-bold hover:text-[#F79E1C] transition-colors duration-300">
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
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const email = this.querySelector('input[name="email"]').value;
                    messageDiv.innerHTML = '<span class="text-blue-300">{{ __('Enviando...') }}</span>';
                    axios.post('{{ route('newsletter.store') }}', {
                            email,
                            _token: token
                        })
                        .then(function() {
                            messageDiv.innerHTML =
                                '<span class="text-green-500">{{ __('Suscripción exitosa') }}</span>';
                            form.reset();
                            setTimeout(() => {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        })
                        .catch(function(error) {
                            let msg = '<span class="text-red-500">';
                            if (error.response?.data?.message) msg += error.response.data.message;
                            else if (error.request) msg += 'No se recibió respuesta del servidor';
                            else msg += 'Error al enviar la solicitud';
                            msg += '</span>';
                            messageDiv.innerHTML = msg;
                            setTimeout(() => {
                                messageDiv.innerHTML = '';
                            }, 3000);
                        });
                });
            }
        });
    </script>
</footer>
