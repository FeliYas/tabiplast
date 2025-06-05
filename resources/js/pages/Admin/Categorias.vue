<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';
import { ref, onMounted, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';

const notification = inject('noti');

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'titulo', 'destacado'];

// Definición de rutas dinámicas
const createRoute = route('categorias.store');
const updateRoute = (id) => route('categorias.update', { id });
const deleteRoute = (id) => route('categorias.destroy', { id });
const destacadoRoute = (id) => route('categorias.toggleDestacado', { id });
const bannerPreview = ref('');

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    categorias: {
        type: Array,
        required: true
    },
    banner: {
        type: String,
        required: true
    }
});

const form = useForm({
    banner: null // This will hold the banner file object
});

onMounted(() => {
    bannerPreview.value = props.banner.path;
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
// Submit the form for update
const submit = () => {
    form.post(route('categorias.banner', props.banner.id), {
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
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Categorias</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <div class="bg-gray-100 rounded-lg p-4 my-6">
            <form @submit.prevent="submit" class="space-y-4">
                <p class="text-black py-1">Banner</p>
                <div
                    class="relative overflow-hidden rounded-lg border-2 border-gray-200 group-hover:border-main-color transition-all duration-300">
                    <img v-if="bannerPreview" :src="bannerPreview" alt="Banner preview"
                        class="w-full h-100 object-cover rounded-md transition-all duration-500">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-0 flex items-center justify-center transition-all duration-300 opacity-0 hover:bg-opacity-20 hover:opacity-100">
                        <label for="banner"
                            class="cursor-pointer bg-white bg-opacity-80 text-main-color py-2 px-4 rounded-full flex items-center transform transition-transform duration-300 hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Cambiar banner
                        </label>
                    </div>
                </div>
                <span class="text-xs text-gray-400 mt-2 italic">Recomendación: 1400x400 px</span>
                <input type="file" class="hidden" id="banner" @change="previewBanner" accept="image/*">
                <div class="mb-6.5 mt-4">
                    <button type="submit" class="btn-primary flex items-center justify-center"
                        :disabled="form.processing">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        {{ form.processing ? 'Actualizando...' : 'Actualizar banner' }}
                    </button>
                </div>
            </form>
        </div>
        <DataTable :columns="columns" :data="categorias" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" :toggleDestacadoRoute="destacadoRoute" />
    </div>
</template>
