<template>
  <div
    class="bg-white rounded-xl p-6 flex flex-col gap-6 items-center shadow-sm w-full mx-auto text-black transition-all duration-300 h-[350px]">
    <div class="mb-4">
      <img v-if="tarjeta.path" :src="tarjeta.path" alt="icono" class="h-12 w-12 object-contain mx-auto" />
      <slot name="icon" v-else />
    </div>
    <transition name="card-fade-scale" mode="out-in">
      <div v-if="editando" key="edit" class="w-full flex flex-col flex-1">
        <input v-model="editTitulo"
          class="border rounded px-2 py-1 w-full text-center font-bold text-lg mb-2 transition-all duration-300" />
        <textarea v-model="editDescripcion"
          class="border rounded px-2 py-1 w-full text-center mb-4 transition-all duration-300" rows="4"></textarea>
        <div class="flex gap-2 w-full mt-auto">
          <button @click="guardarCambios" class="btn-primary flex-1">Guardar</button>
          <button @click="cancelarEdicion" class="flex-1 border border-gray-300 rounded px-2 py-1">Cancelar</button>
        </div>
      </div>
      <div v-else key="view" class="w-full flex flex-col flex-1 items-center">
        <h3 class="font-bold text-lg text-center mb-2">{{ tarjeta.titulo }}</h3>
        <p class="text-center text-gray-700 mb-4">{{ tarjeta.descripcion }}</p>
        <div class="w-full flex justify-center mt-auto">
          <button @click="editando = true"
            class="text-main-color border border-main-color px-4 py-1 rounded-full hover:bg-main-color hover:text-white transition text-sm">
            Editar
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, watch, inject } from 'vue';
import { useForm } from '@inertiajs/vue3';

const notification = inject('noti');

const props = defineProps({
  tarjeta: {
    type: Object,
    required: true
  }
});

const editando = ref(false);
const editTitulo = ref(props.tarjeta.titulo);
const editDescripcion = ref(props.tarjeta.descripcion);

watch(() => props.tarjeta, (n) => {
  editTitulo.value = n.titulo;
  editDescripcion.value = n.descripcion;
});

const guardarCambios = () => {
  const form = useForm({
    titulo: editTitulo.value,
    descripcion: editDescripcion.value
  });
  form.put(route('tarjeta.update', props.tarjeta.id), {
    preserveScroll: true,
    onSuccess: (page) => {
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

const cancelarEdicion = () => {
  editTitulo.value = props.tarjeta.titulo;
  editDescripcion.value = props.tarjeta.descripcion;
  editando.value = false;
};
</script>

<style scoped>
.btn-primary {
  background: #ffb300;
  color: #fff;
  border: none;
  border-radius: 9999px;
  padding: 0.5rem 1.5rem;
  font-weight: 600;
  transition: background 0.2s;
}

.btn-primary:hover {
  background: #ff9800;
}

/* Nueva transición más suave y moderna */
.card-fade-scale-enter-active,
.card-fade-scale-leave-active {
  transition: all 0.35s cubic-bezier(.4, 0, .2, 1);
  will-change: opacity, transform;
}

.card-fade-scale-enter-from,
.card-fade-scale-leave-to {
  opacity: 0;
  transform: scale(0.96) translateY(20px);
}

.card-fade-scale-enter-to,
.card-fade-scale-leave-from {
  opacity: 1;
  transform: scale(1) translateY(0);
}
</style>
