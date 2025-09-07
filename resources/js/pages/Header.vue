<template>
    <header class="fixed top-0 left-0 w-full z-50 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md shadow-md">
        <div class="container mx-auto flex items-center justify-between px-4 py-3 sm:px-6">

            <Link href="/inicio" class="flex items-center">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8 text-pink-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16z" />
                </svg>
                <span class="text-xl font-bold text-zinc-900 dark:text-white">Caducou</span>
            </div>
            </Link>
            <!-- Center: Links (desktop) -->
            <nav class="hidden sm:flex items-center gap-4">
                <Link href="dinheiroemprestado"
                    class="px-3 py-1 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
                Dinheiro Emprestado
                </Link>
                <Link href="vendasrealizadas"
                    class="px-3 py-1 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
                Vendas Realizadas
                </Link>
            </nav>

            <!-- Center: Usuário + Logout (desktop) -->
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-zinc-700 dark:text-zinc-200 font-medium">Olá, {{ username }}</span>
                <button @click="logout"
                    class="px-3 py-1 bg-rose-500 hover:bg-rose-600 text-white rounded-lg transition">
                    Logout
                </button>
            </div>

            <!-- Right: Dark/Light Mode + Hamburger (mobile) -->
            <div class="flex items-center gap-2">
                <!-- Dark mode -->
                <button @click="toggleDarkMode"
                    class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-800 transition"
                    :title="darkMode ? 'Modo Claro' : 'Modo Escuro'">
                    <svg v-if="darkMode" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8-8h1M3 12H2m15.364-6.364l.707.707M5.636 18.364l.707.707M18.364 18.364l-.707.707M5.636 5.636l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z" />
                    </svg>
                    <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                </button>

                <!-- Hamburger menu (mobile) -->
                <button @click="menuOpen = !menuOpen"
                    class="sm:hidden p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-zinc-800 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-zinc-900 dark:text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path v-if="!menuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div v-if="menuOpen" class="sm:hidden bg-white dark:bg-zinc-900/95 backdrop-blur-md shadow-md mt-1">
            <nav class="flex flex-col p-4 gap-2">
                <Link href="dinheiroemprestado"
                    class="px-3 py-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
                Dinheiro Emprestado
                </Link>
                <Link href="vendasrealizadas"
                    class="px-3 py-2 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-800 transition">
                Vendas Realizadas
                </Link>
                <button @click="logout"
                    class="px-3 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg transition">
                    Logout
                </button>
            </nav>
        </div>
    </header>
</template>

<script setup lang="ts">
import { computed, ref, watchEffect } from 'vue';
import { Link, router } from '@inertiajs/vue3';

interface User {
    id: number;
    name: string;
    email: string;
    totalEmprestimos: number;
    totalVendas: number;
    valorTotalEmprestimos: number;
    valorTotalVendas: number;
}

const props = defineProps<{ user: User | null }>();

const username = computed(() => props.user ? props.user.name : 'Usuário');

const darkMode = ref(true);
const menuOpen = ref(false);

// Função de logout
function logout() {
    router.post('/logout');
}

// Dark mode
watchEffect(() => {
    if (darkMode.value) {
        document.documentElement.classList.add('dark');
        localStorage.setItem('darkMode', 'true');
    } else {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('darkMode', 'false');
    }
});

if (localStorage.getItem('darkMode') === 'true') darkMode.value = true;

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
}
</script>

<style scoped>
:global(body) {
    padding-top: 64px;
}
</style>
