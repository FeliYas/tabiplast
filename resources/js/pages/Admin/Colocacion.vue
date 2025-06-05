<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'path', 'titulo', 'descripcion'];

// Definición de rutas
const createRoute = route('colocacion.store');
const updateRoute = (id) => route('colocacion.update', { id });
const deleteRoute = (id) => route('colocacion.destroy', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    colocaciones: {
        type: Array,
        required: true
    },
    producto: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Colocacion de {{ producto.titulo }}</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        <DataTable :columns="columns" :data="colocaciones" :createRoute="createRoute" :updateRoute="updateRoute"
            :deleteRoute="deleteRoute" :productoId="producto.id" />
    </div>
</template>
