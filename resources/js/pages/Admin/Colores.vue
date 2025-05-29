<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'codigo', 'titulo', 'tituloen', 'tituloport'];

// Definición de rutas dinámicas
const createRoute = route('colores.store');
const updateRoute = (id) => route('colores.update', { id });
const deleteRoute = (id) => route('colores.destroy', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    colores: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Colores</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="colores" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" recomendacion="180x50"/>
    </div>
</template>
