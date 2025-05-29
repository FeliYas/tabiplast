<script setup>
import DashboardLayout from '@/layouts/DashboardLayout.vue';
import DataTable from '@/components/DataTable.vue';

defineOptions({
    layout: DashboardLayout
});

// Definición de las columnas
const columns = ['orden', 'titulo', 'categoria_id'];

// Definición de rutas
const aggProdRoute = route('relacionados.store');
const deleteRoute = (id) => route('relacionados.destroy', { id });

const props = defineProps({
    logo: {
        type: String,
        required: true
    },
    productosRelacionados: {
        type: Array,
        required: true
    },
    productos: {
        type: Array,
        required: true
    },
    aplicacion: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div>
        <div class="py-3 text-xl text-gray-700">
            <h1>Productos relacionados de {{ aplicacion.titulo }}</h1>
        </div>
        <!-- Línea -->
        <hr class="border-t-[3px] border-main-color rounded">
        
        <DataTable :columns="columns" :data="productosRelacionados" :aggProdRoute="aggProdRoute" :deleteRoute="deleteRoute"
            :aplicacionId="aplicacion.id" :productos="productos" />
    </div>
</template>
