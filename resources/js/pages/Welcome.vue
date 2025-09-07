<template>
  <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <!-- Info do site -->
    <h1 class="text-4xl font-bold mb-6">Bem-vindo ao Caducou</h1>
    <p class="text-lg text-gray-600 mb-10">
      Gerencie seus empréstimos e vendas de forma prática e rápida.
    </p>

    <!-- Botões de ação -->
    <div class="flex space-x-4">
      <Link
        v-if="canLogin"
        href="/login"
        class="px-6 py-3 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700"
      >
        Login
      </Link>

      <Link
        v-if="canRegister"
        href="/register"
        class="px-6 py-3 bg-gray-200 rounded-xl shadow hover:bg-gray-300"
      >
        Cadastre-se
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});
</script>
