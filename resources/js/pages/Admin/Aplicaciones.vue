<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'titulo', 'tituloen', 'tituloport', 'productos relacionados'];

// Definición de rutas dinámicas
const createRoute = route('aplicaciones.store');
const updateRoute = (id) => route('aplicaciones.update', { id });
const deleteRoute = (id) => route('aplicaciones.destroy', { id });
const productosRoute = (id) => route('relacionados.dashboard', {id});

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    aplicaciones: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Aplicaciones</h1>
        </div>

        <hr class="border-t-[3px] border-main-color rounded">

        <DataTable :columns="columns" :data="aplicaciones" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" :productosRoute="productosRoute" recomendacion="400x250"/>
    </div>
</template>
