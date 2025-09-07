<template>
  <Head>
    <title>Dashboard</title>
  </Head>

  <div class="min-h-screen bg-zinc-100 dark:bg-zinc-900 text-zinc-900 dark:text-zinc-100">

<Header :user="user" />

    <!-- Page Content -->
    <main class="pt-20 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-6">
      <h1 class="text-2xl font-bold">Bem-vindo, {{ user?.name }}</h1>

      <!-- Quick Stats Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        <!-- Empréstimos -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl p-6 shadow ring-1 ring-zinc-200/10 dark:ring-zinc-700/20">
          <div class="text-sm font-medium text-rose-500">Empréstimos</div>
          <div class="mt-2 text-xl font-extrabold">R$ {{ user?.valorTotalEmprestimos.toFixed(2) }}</div>
          <div class="text-sm text-zinc-500 dark:text-zinc-400">Total de empréstimos: {{ user?.totalEmprestimos }}</div>
        </div>

        <!-- Vendas -->
        <div class="bg-white dark:bg-zinc-800 rounded-2xl p-6 shadow ring-1 ring-zinc-200/10 dark:ring-zinc-700/20">
          <div class="text-sm font-medium text-emerald-500">Vendas</div>
          <div class="mt-2 text-xl font-extrabold">R$ {{ user?.valorTotalVendas.toFixed(2) }}</div>
          <div class="text-sm text-zinc-500 dark:text-zinc-400">Total de vendas: {{ user?.totalVendas }}</div>
        </div>

        <!-- Saldo -->
        <div class="bg-black text-white rounded-2xl p-6 shadow col-span-1 sm:col-span-2">
          <div class="text-sm font-medium text-white/70">Saldo</div>
          <div class="mt-2 text-2xl font-extrabold">R$ {{ saldo.toFixed(2) }}</div>
        </div>
      </div>

      <!-- Placeholder para gráfico -->
      <div class="bg-white dark:bg-zinc-800 rounded-2xl p-6 shadow ring-1 ring-zinc-200/10 dark:ring-zinc-700/20">
        <h2 class="text-xl font-bold mb-4">Gráfico de Vendas vs Empréstimos</h2>
        <div class="h-64 bg-zinc-100 dark:bg-zinc-700 rounded-lg flex items-center justify-center text-zinc-400 dark:text-zinc-300">
          Gráfico Aqui
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Header from './Header.vue';

interface User {
  id: number;
  name: string;
  email: string;
  totalEmprestimos: number;
  totalVendas: number;
  valorTotalEmprestimos: number;
  valorTotalVendas: number;
}

const props = defineProps<{
  user: User | null;
}>();

const darkMode = ref(false);

function logout() {
  router.post('/logout');
}

const saldo = computed(() => {
  if (!props.user) return 0;
  return props.user.valorTotalVendas - props.user.valorTotalEmprestimos;
});
</script>

<style scoped>
/* Somente para destacar texto, se necessário */
.text-outline {
  text-shadow:
    -1px -1px 0 #000,
     1px -1px 0 #000,
    -1px  1px 0 #000,
     1px  1px 0 #000;
}
</style>
