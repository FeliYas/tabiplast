<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';

defineOptions({
    layout: DashboardLayout
});

// Inyectar el sistema de notificaciones global
const notification = inject('noti');

const props = defineProps({
    logo: {
        type: Object,
        required: true
    },
    contacto: {
        type: Object,
        required: true
    },
    mapa: {
        type: String,
        required: true
    }
});

// Crear una referencia para el div que muestra el mapa
const mapPreview = ref(null);

// Initialize the form with contacto data
const form = useForm({
    direccion: props.contacto.direccion,
    email: props.contacto.email,
    telefono: props.contacto.telefono,
    whatsapp: props.contacto.whatsapp,
    iframe: props.contacto.iframe,
    instagram: props.contacto.instagram,
    facebook: props.contacto.facebook,
    linkedin: props.contacto.linkedin,
    banner: null // This will hold the file object
});

const bannerPreview = ref('');

// Set initial banner preview
onMounted(() => {
    updateMapPreview();
    bannerPreview.value = props.contacto.banner;
});

// Preview the selected banner image
const previewBanner = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.banner = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            bannerPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

// Actualizar la vista previa del mapa cuando se cambia el iframe
const updateMapPreview = () => {
    if (mapPreview.value) {
        // Limpiar el contenido anterior
        mapPreview.value.innerHTML = '';

        // Insertar el nuevo iframe con dimensiones ajustadas
        const iframeHtml = form.iframe
            .replace(/width="[^"]*"/g, 'width="100%"')
            .replace(/height="[^"]*"/g, 'height="300"');

        mapPreview.value.innerHTML = iframeHtml;
    }
};

// Inicializar la vista previa del mapa cuando el componente se monta
onMounted(() => {
    updateMapPreview();
});

// Submit the form for update
const submit = () => {
    form.post(route('contacto.update', props.contacto.id), {
        preserveScroll: true,
        onSuccess: (page) => {
            // Accede al mensaje flash de la respuesta
            if (page.props.flash && page.props.flash.message) {
                notification({ message: page.props.flash.message, type: "success" });
            } else {
                notification({ message: "Actualizado correctamente", type: "success" });
            }
        },
        onError: (errors) => {
            console.log(errors);
            notification({ message: errors[0], type: "error" });
        },
    });
};
</script>

<template>
    <div class="group relative h-full">
        <div class="py-3 text-xl text-gray-700">
            <h1>Contacto</h1>
        </div>
        <!-- Línea expandible -->
        <hr class="border-t-[3px] border-main-color transition-all duration-500 ease-in-out opacity-70 rounded">

        <div
            class="bg-gray-100 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl mt-4">
            <!-- Formulario con efectos de animación -->
            <form @submit.prevent="submit" class="p-6 text-black">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Banner con icono -->
                    <div class="relative group md:col-span-2">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="9" cy="9" r="2"></circle>
                                <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                            </svg>
                        </div>
                        <label for="banner"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Banner</label>
                        <input type="file" id="banner" @input="previewBanner" accept="image/*"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200">

                        <!-- Vista previa del banner -->
                        <div v-if="bannerPreview" class="mt-4">
                            <img :src="bannerPreview.startsWith('blob:') || bannerPreview.startsWith('data:') ? bannerPreview : `/storage/${bannerPreview}`"
                                alt="Banner preview" class="h-100 w-full object-cover rounded-lg shadow-sm border">
                            <span class="text-xs text-gray-400 italic">Recomendación: 1400x400 px</span>
                        </div>
                    </div>

                    <!-- Dirección con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <label for="direccion"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Dirección</label>
                        <input type="text" id="direccion" v-model="form.direccion"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            required>
                    </div>

                    <!-- Email con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                </path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <label for="email"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Email</label>
                        <input type="email" id="email" v-model="form.email"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            required>
                    </div>

                    <!-- Teléfono uno con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <label for="telefono"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Teléfono
                        </label>
                        <input type="tel" id="telefono" v-model="form.telefono"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            required>
                    </div>

                    <!-- Whatsapp con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </div>
                        <label for="whatsapp"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Whatsapp
                            <span class="text-gray-500">(Solo los numeros. Ej: 5491123456789)</span></label>
                        <input type="tel" id="whatsapp" v-model="form.whatsapp"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            required>
                    </div>

                    <!-- Instagram con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="m16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </div>
                        <label for="instagram"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Instagram</label>
                        <input type="url" id="instagram" v-model="form.instagram"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            placeholder="https://instagram.com/usuario">
                    </div> <!-- Facebook con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                        </div>
                        <label for="facebook"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Facebook</label>
                        <input type="url" id="facebook" v-model="form.facebook"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            placeholder="https://facebook.com/pagina">
                    </div>

                    <!-- Linkedin con icono -->
                    <div class="relative group">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mt-0.5">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 8a6 6 0 0 1 6 6v6H2v-6a6 6 0 0 1 6-6h8z"></path>
                                <circle cx="8.5" cy="13.5" r="1.5"></circle>
                                <circle cx="15.5" cy="13.5" r="1.5"></circle>
                            </svg>
                        </div>
                        <label for="linkedin"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">LinkedIn</label>
                        <input type="url" id="linkedin" v-model="form.linkedin"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            placeholder="https://linkedin.com/in/usuario">
                    </div>

                    <div class="relative group col-span-2">
                        <div
                            class="absolute left-3 top-8 text-gray-400 transition-all duration-200 group-focus-within:text-main-color">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mt-0.5">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </div>
                        <label for="iframe"
                            class="block text-sm font-medium text-gray-700 mb-1 transition-all duration-200 group-focus-within:text-main-color">Mapa
                            (iframe)</label>
                        <input type="text" id="iframe" v-model="form.iframe" @input="updateMapPreview"
                            class="pl-10 p-2 bg-white block border border-gray-300 w-full h-10 rounded-lg shadow-sm focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20 transition-all duration-200"
                            required>
                    </div>
                </div>



                <!-- Vista previa del mapa si hay iframe -->
                <div class="mt-6 rounded-lg overflow-hidden shadow-sm transition-all duration-300 hover:shadow-md h-64"
                    ref="mapPreview">
                    <!-- El iframe se insertará aquí desde JavaScript -->
                </div>

                <!-- Botones con efectos de hover -->
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="submit" class="btn-primary flex items-center" :disabled="form.processing">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="mr-1">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-pulse {
    animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {

    0%,
    100% {
        opacity: 1;
    }

    50% {
        opacity: 0.5;
    }
}

/* Ajuste adicional para asegurar que el iframe se muestre correctamente */
:deep(iframe) {
    width: 100%;
    min-height: 300px;
    border: 0;
}
</style>