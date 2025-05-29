<script setup>
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import QuillEditor from '@/components/QuillEditor.vue';

defineOptions({
    layout: DashboardLayout
});

// Inyectar el sistema de notificaciones global
const notification = inject('noti');

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    calidad: {
        type: Object,
        required: true
    }
});

const imagePreview = ref('');
const iso1FileName = ref('');
const iso2FileName = ref('');

// Initialize the form with calidad data
const form = useForm({
    titulo: props.calidad.titulo,
    tituloen: props.calidad.tituloen,
    tituloport: props.calidad.tituloport,
    descripcion: props.calidad.descripcion,
    descripcionen: props.calidad.descripcionen,
    descripcionport: props.calidad.descripcionport,
    path: null,
    iso1: null,
    iso2: null,

});

// Set initial image preview
onMounted(() => {
    imagePreview.value = props.calidad.path;
});

// Preview the selected image
const previewImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.path = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};
const previewIso1 = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.type === 'application/pdf' && file.size <= 10 * 1024 * 1024) { // 10MB max
            form.iso1 = file;
            iso1FileName.value = file.name;
        } else {
            notification({ message: "El archivo debe ser PDF y menor a 10MB", type: "error" });
            event.target.value = '';
        }
    }
};

const previewIso2 = (event) => {
    const file = event.target.files[0];
    if (file) {
        if (file.type === 'application/pdf' && file.size <= 10 * 1024 * 1024) { // 10MB max
            form.iso2 = file;
            iso2FileName.value = file.name;
        } else {
            notification({ message: "El archivo debe ser PDF y menor a 10MB", type: "error" });
            event.target.value = '';
        }
    }
};

// Submit the form for update
const submit = () => {
    form.post(route('calidad.update', props.calidad.id), {
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
            <h1>Calidad</h1>
        </div>
        <!-- Línea expandible -->
        <hr class="border-t-[3px] border-main-color transition-all duration-500 ease-in-out opacity-70 rounded">

        <div class="w-full flex flex-col gap-8 py-4">
            <form @submit.prevent="submit"
                class="w-full transition-all duration-300 hover:shadow-lg hover:border-main-color transform hover:-translate-y-1">
                <div
                    class="w-full bg-gray-100 p-6 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 group">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Contenedor de la imagen con vista previa -->
                        <div class="md:w-1/3 flex flex-col">
                            <h3
                                class="block text-sm font-medium text-gray-700 mb-2 group-hover:text-main-color transition-colors duration-300">
                                Imagen principal</h3>
                            <div
                                class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-main-color transition-all duration-300">
                                <img :src="imagePreview" alt="Imagen"
                                    class="w-full h-auto object-cover rounded-md transition-all duration-500">

                                <!-- Overlay con efecto al hover -->
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 flex items-center justify-center transition-all duration-300 opacity-0 hover:bg-opacity-20 hover:opacity-100">
                                    <label for="path"
                                        class="cursor-pointer bg-white bg-opacity-80 text-main-color py-2 px-4 rounded-full flex items-center transform transition-transform duration-300 hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Cambiar imagen
                                    </label>
                                </div>
                            </div>

                            <!-- Recomendación de tamaño -->
                            <span class="text-xs text-gray-400 mt-2 italic">Recomendación: 600x400 px</span>

                            <!-- Input file oculto -->
                            <input type="file" class="hidden" id="path" @change="previewImage">
                        </div>

                        <!-- Contenedor de formulario -->
                        <div class="flex flex-col justify-between w-full md:w-2/3 text-black">
                            <div class="flex flex-col lg:flex-row gap-6 mb-4">
                                <div class="relative group w-full">
                                    <label for="titulo"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Título</label>
                                    <input type="text" id="titulo" v-model="form.titulo"
                                        class="p-2 bg-white block border border-gray-300 w-full rounded-lg shadow-sm transition-all duration-200 focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20"
                                        required>
                                </div>
                                <div class="relative group w-full">
                                    <label for="tituloen"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Título
                                        en ingles</label>
                                    <input type="text" id="tituloen" v-model="form.tituloen"
                                        class="p-2 bg-white block border border-gray-300 w-full rounded-lg shadow-sm transition-all duration-200 focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20"
                                        required>
                                </div>
                                <div class="relative group w-full">
                                    <label for="tituloport"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Título
                                        en portugues</label>
                                    <input type="text" id="tituloport" v-model="form.tituloport"
                                        class="p-2 bg-white block border border-gray-300 w-full rounded-lg shadow-sm transition-all duration-200 focus:border-main-color focus:ring focus:ring-main-color focus:ring-opacity-20"
                                        required>
                                </div>
                            </div>
                            <div class="flex flex-col lg:flex-row gap-6">
                                <div class="lg:max-w-1/3">
                                    <label for="descripcion"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Descripción</label>
                                    <QuillEditor unique_ref="descripcion_editor" placeholder="Descripción"
                                        :initial_content="form.descripcion"
                                        v-on:text_changed="form.descripcion = $event">
                                    </QuillEditor>
                                </div>
                                <div class="lg:max-w-1/3">
                                    <label for="descripcionen"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Descripción
                                        en ingles</label>
                                    <QuillEditor unique_ref="descripcionen_editor" placeholder="Descripción"
                                        :initial_content="form.descripcionen"
                                        v-on:text_changed="form.descripcionen = $event">
                                    </QuillEditor>
                                </div>
                                <div class="lg:max-w-1/3">
                                    <label for="descripcionport"
                                        class="block text-sm font-medium text-gray-700 mb-1 transition-colors duration-200 group-focus-within:text-main-color">Descripción
                                        en portuges</label>
                                    <QuillEditor unique_ref="descripcionport_editor" placeholder="Descripción"
                                        :initial_content="form.descripcionport"
                                        v-on:text_changed="form.descripcionport = $event">
                                    </QuillEditor>
                                </div>
                            </div>

                            <div class="flex flex-col lg:flex-row gap-6 mt-6 mb-6">
                                <div class="relative group w-full">
                                    <label for="iso1"
                                        class="block text-sm font-medium text-gray-700 mb-2 transition-colors duration-200 group-focus-within:text-main-color">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M9 12l2 2 4-4"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M6 4v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2z"/>
                                            </svg>
                                            Certificación ISO 1
                                        </div>
                                    </label>
                                    <div class="relative">
                                        <input type="file" id="iso1" @change="previewIso1" accept=".pdf"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="flex items-center justify-between p-3 bg-white border border-gray-300 rounded-lg shadow-sm transition-all duration-200 hover:border-gray-400 group-focus-within:border-main-color">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 bg-red-50 rounded-lg">
                                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" v-if="iso1FileName">
                                                        {{ iso1FileName }}
                                                    </p>
                                                    <p class="text-sm text-gray-500" v-else>
                                                        Seleccionar archivo PDF
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        Formato: PDF • Máx: 10MB
                                                    </p>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Mostrar archivo actual si existe -->
                                    <div v-if="props.calidad.iso1" class="mt-2 flex items-center gap-2 text-sm text-blue-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                        </svg>
                                        <a :href="props.calidad.iso1" target="_blank" class="hover:underline">
                                            Ver archivo actual
                                        </a>
                                    </div>
                                </div>

                                <div class="relative group w-full">
                                    <label for="iso2"
                                        class="block text-sm font-medium text-gray-700 mb-2 transition-colors duration-200 group-focus-within:text-main-color">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z M9 12l2 2 4-4"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M6 4v16a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H8a2 2 0 00-2 2z"/>
                                            </svg>
                                            Certificación ISO 2
                                        </div>
                                    </label>
                                    <div class="relative">
                                        <input type="file" id="iso2" @change="previewIso2" accept=".pdf"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="flex items-center justify-between p-3 bg-white border border-gray-300 rounded-lg shadow-sm transition-all duration-200 hover:border-gray-400 group-focus-within:border-main-color">
                                            <div class="flex items-center gap-3">
                                                <div class="p-2 bg-red-50 rounded-lg">
                                                    <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900" v-if="iso2FileName">
                                                        {{ iso2FileName }}
                                                    </p>
                                                    <p class="text-sm text-gray-500" v-else>
                                                        Seleccionar archivo PDF
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        Formato: PDF • Máx: 10MB
                                                    </p>
                                                </div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <!-- Mostrar archivo actual si existe -->
                                    <div v-if="props.calidad.iso2" class="mt-2 flex items-center gap-2 text-sm text-blue-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                        </svg>
                                        <a :href="props.calidad.iso2" target="_blank" class="hover:underline">
                                            Ver archivo actual
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón de actualizar -->
                            <div class="mb-6.5 mt-4">
                                <button type="submit" class="btn-primary w-full flex items-center justify-center"
                                    :disabled="form.processing">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    {{ form.processing ? 'Actualizando...' : 'Actualizar calidad' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>