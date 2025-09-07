<!-- resources/js/Components/Modal.vue -->
<template>
  <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg w-full max-w-lg p-6">
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100">
          {{ title }}
        </h2>
        <button @click="$emit('close')" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
          ✕
        </button>
      </div>

      <!-- Conteúdo dinâmico -->
      <slot />

      <!-- Footer -->
      <div class="mt-6 flex justify-end gap-2">
        <button @click="$emit('close')" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500">
          Cancelar
        </button>
        <button @click="$emit('confirm')" class="px-4 py-2 bg-rose-500 text-white rounded-lg hover:bg-rose-600">
          Confirmar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const props = defineProps<{
  show: boolean;
  title: string;
}>();
defineEmits(['close', 'confirm']);
</script>
