<script setup>
import QuillEditor from '@/components/QuillEditor.vue';
const props = defineProps({
    show: Boolean,
    columns: Array,
    categorias: Array,
    formData: Object,
    fileInputLabel: String,
    fichaInputLabel: String,
    videoInputLabel: String,
    recomendacion: String,
    showPassword: Boolean,
});
const emit = defineEmits(['close', 'submit', 'file-change', 'ficha-change', 'video-change', 'toggle-password']);

</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-black opacity-60 backdrop-blur-sm" @click="$emit('close')"></div>
            <Transition name="modal-content">
                <div class="relative w-full max-w-md z-50 bg-white rounded-lg shadow-lg max-h-[90vh] overflow-y-auto">
                    <form @submit.prevent="$emit('submit')" enctype="multipart/form-data">
                        <!-- Header -->
                        <div class="bg-main-color bg-opacity-10 px-6 py-4 border-b border-main-color border-opacity-20">
                            <h2 class="text-white text-xl font-semibold flex items-center gap-2">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4V20M4 12H20" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                Crear
                            </h2>
                        </div>
                        <!-- Formulario -->
                        <div class="p-6 text-black">
                            <div v-for="column in columns" :key="column" class="mb-4 ">
                                <template v-if="column === 'destacado'"></template>
                                <template v-else-if="column === 'path'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Imagen</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                            {{ fileInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('file-change', $event)"
                                            class="hidden">
                                        <p class="text-xs text-gray-400 mt-1">
                                            Formatos permitidos: JPEG, PNG, JPG, SVG. <br>
                                            Recomendacion: {{ recomendacion }}px
                                        </p>
                                    </div>
                                </template>
                                <template v-else-if="column === 'categoria_id'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Categoria
                                    </label>
                                    <select :id="column" v-model="formData[column]"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color"
                                        required>
                                        <option value="" disabled>Seleccione una categoría</option>
                                        <option v-for="categoria in categorias" :key="categoria.id"
                                            :value="categoria.id">
                                            {{ categoria.titulo }}
                                        </option>
                                    </select>
                                </template>
                                <template v-else-if="column === 'ficha'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Ficha Técnica -
                                        PDF (Opcional)</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                            {{ fichaInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('ficha-change', $event)"
                                            accept="application/pdf" class="hidden">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 2MB, formato PDF</p>
                                </template>
                                <template v-else-if="column === 'video'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">Video
                                        (Opcional)</label>
                                    <div class="relative w-full">
                                        <label :for="column"
                                            class="block border border-main-color rounded-md bg-white px-4 py-2 w-full text-gray-600 cursor-pointer text-center">
                                            {{ videoInputLabel }}
                                        </label>
                                        <input type="file" :id="column" @change="$emit('video-change', $event)"
                                            accept="video/mp4,video/avi,video/mov,video/webm,video/ogg" class="hidden">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Máximo 100MB, formatos: mp4, avi, mov, webm,
                                        ogg</p>
                                </template>
                                <template v-else-if="column === 'role'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Role
                                    </label>
                                    <select :id="column" v-model="formData[column]"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color"
                                        required>
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </template>
                                <template v-else-if="column === 'password'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Password
                                    </label>
                                    <div class="relative">
                                        <input :type="showPassword ? 'text' : 'password'" :id="column"
                                            v-model="formData[column]"
                                            class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color pr-10"
                                            required>
                                        <button type="button"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 cursor-pointer"
                                            @click="$emit('toggle-password')">
                                            <!-- Iconos de ojo -->
                                            <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268-2.943-9.543-7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                                <template v-else-if="column === 'descripcion'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Descripcion
                                    </label>
                                    <QuillEditor :unique_ref="`create_${column}`" placeholder="Descripcion"
                                        :initial_content="formData[column]"
                                        v-on:text_changed="formData[column] = $event" />
                                </template>
                                <template v-else-if="column === 'especificaciones'">
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        Especificaciones (Opcional)
                                    </label>
                                    <QuillEditor :unique_ref="`create_${column}`" placeholder="Especificaciones"
                                        :initial_content="formData[column]"
                                        v-on:text_changed="formData[column] = $event" />
                                </template>
                                <template v-else>
                                    <label :for="column" class="block font-medium text-gray-700 mb-1">
                                        {{ column.charAt(0).toUpperCase() + column.slice(1) }}
                                    </label>
                                    <input :id="column" :name="column" v-model="formData[column]" type="text"
                                        class="w-full border border-main-color px-4 py-2 rounded-md focus:ring-2 focus:ring-opacity-50 focus:ring-main-color focus:border-main-color"
                                        required>
                                </template>
                            </div>
                        </div>
                        <!-- Footer con botones -->
                        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3">
                            <button type="button" @click="$emit('close')"
                                class="btn-secondary px-4 py-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancelar
                            </button>
                            <button type="submit" class="btn-primary px-4 py-2 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Crear
                            </button>
                        </div>
                    </form>
                </div>
            </Transition>
        </div>
    </Transition>
</template>
