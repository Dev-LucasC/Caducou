<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
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

interface Venda {
  id: number;
  nome_cliente: string;
  valor: number;
  data: string;
  produto: string;
}

const props = defineProps<{
  user: User;
  vendas: Venda[];
}>();

// Estados para modais
const showEdit = ref(false);
const showCreate = ref(false);
const selected = ref<Venda | null>(null);
const novaVenda = ref<Partial<Venda>>({
  nome_cliente: '',
  valor: 0,
  data: '',
  produto: '',
});

// Função criar
function createItem() {
  router.post(`/vendasrealizadas`, novaVenda.value, {
    onSuccess: () => {
      showCreate.value = false;
      novaVenda.value = { nome_cliente: '', valor: 0, data: '', produto: '' };
    },
  });
}

// Função editar
function editItem(item: Venda) {
  selected.value = { ...item };
  showEdit.value = true;
}

// Função salvar edição
function updateItem() {
  if (!selected.value) return;
  router.put(`/vendasrealizadas/${selected.value.id}`, selected.value, {
    onSuccess: () => {
      showEdit.value = false;
    },
  });
}

// Função excluir
function deleteItem(id: number) {
  if (confirm('Tem certeza que deseja excluir esta venda?')) {
    router.delete(`/vendasrealizadas/${id}`);
  }
}

// Função para datas no padrão BR
const formatDateBR = (date: string) => {
  const [year, month, day] = date.split('-');
  return `${day}/${month}/${year}`;
};
</script>

<template>
  <Head>
    <title>Vendas Realizadas</title>
  </Head>

  <Header :user="user" />

  <!-- Botão Criar -->
  <div class="mt-6 px-4">
    <button @click="showCreate = true"
      class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      + Nova Venda
    </button>
  </div>

  <!-- Tabela + Cards -->
  <div class="overflow-x-auto mt-4 px-4">
    <table class="min-w-full text-sm hidden md:table">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th class="px-6 py-3">Nome do Cliente</th>
          <th class="px-6 py-3">Valor</th>
          <th class="px-6 py-3">Data</th>
          <th class="px-6 py-3">Produto</th>
          <th class="px-6 py-3">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="venda in props.vendas" :key="venda.id"
            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
          <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ venda.nome_cliente }}</td>
          <td class="px-6 py-4">R$ {{ venda.valor.toFixed(2) }}</td>
          <td class="px-6 py-4">{{ formatDateBR(venda.data) }}</td>
          <td class="px-6 py-4">{{ venda.produto }}</td>
          <td class="px-6 py-4 space-x-2">
            <button @click="editItem(venda)" class="text-blue-600 hover:underline">Editar</button>
            <button @click="deleteItem(venda.id)" class="text-red-600 hover:underline">Excluir</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Cards mobile -->
    <div class="md:hidden space-y-4">
      <div v-for="venda in props.vendas" :key="'mobile-'+venda.id"
           class="bg-white dark:bg-gray-800 p-4 rounded shadow">
        <div class="font-bold text-gray-900 dark:text-white">{{ venda.nome_cliente }}</div>
        <div>Valor: R$ {{ venda.valor.toFixed(2) }}</div>
        <div>Data: {{ formatDateBR(venda.data) }}</div>
        <div>Produto: {{ venda.produto }}</div>
        <div class="mt-2 flex space-x-2">
          <button @click="editItem(venda)" class="px-2 py-1 bg-blue-600 text-white rounded">Editar</button>
          <button @click="deleteItem(venda.id)" class="px-2 py-1 bg-red-600 text-white rounded">Excluir</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modais Criar / Editar -->
  <ModalCreateEdit v-if="showCreate" @close="showCreate=false" @save="createItem" :model="novaVenda" />
  <ModalCreateEdit v-if="showEdit && selected" @close="showEdit=false" @save="updateItem" :model="selected" />
</template>

