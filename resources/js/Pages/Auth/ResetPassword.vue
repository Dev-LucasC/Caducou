<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ArrowLeft, LockKeyhole, ShieldCheck, WalletCards } from '@lucide/vue';

const props = defineProps({
    token: { type: String, required: true },
    email: { type: String, default: '' },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/redefinir-senha', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <main class="flex min-h-screen flex-col bg-[#f7f8f8] px-4 py-8 text-zinc-950">
        <div class="mx-auto w-full max-w-md">
            <Link href="/login" class="inline-flex items-center gap-2 text-sm font-semibold text-zinc-700 hover:text-zinc-950">
                <ArrowLeft class="size-4" /> Voltar para login
            </Link>
            <div class="mt-14 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm">
                <div class="mb-5 flex size-11 items-center justify-center rounded-lg bg-zinc-950 text-white">
                    <WalletCards class="size-5" />
                </div>
                <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-teal-700">
                    <ShieldCheck class="size-4" /> Acesso protegido
                </div>
                <h1 class="text-2xl font-semibold">Crie uma nova senha</h1>
                <p class="mt-2 text-sm text-zinc-600">Use pelo menos 10 caracteres, incluindo letras e números.</p>
                <form class="mt-6 grid gap-4" @submit.prevent="submit">
                    <label for="email" class="grid gap-1.5 text-sm font-medium text-zinc-700">
                        E-mail
                        <input id="email" v-model="form.email" type="email" autocomplete="email" required class="h-11 rounded-lg border border-zinc-200 px-3 outline-none focus:border-zinc-500" />
                    </label>
                    <p v-if="form.errors.email" role="alert" class="text-sm text-red-700">{{ form.errors.email }}</p>
                    <label for="password" class="grid gap-1.5 text-sm font-medium text-zinc-700">
                        Nova senha
                        <span class="flex items-center gap-2 rounded-lg border border-zinc-200 px-3">
                            <LockKeyhole class="size-4 text-zinc-400" />
                            <input id="password" v-model="form.password" type="password" autocomplete="new-password" required class="h-11 w-full outline-none" />
                        </span>
                    </label>
                    <p v-if="form.errors.password" role="alert" class="text-sm text-red-700">{{ form.errors.password }}</p>
                    <label for="password_confirmation" class="grid gap-1.5 text-sm font-medium text-zinc-700">
                        Confirme a senha
                        <input id="password_confirmation" v-model="form.password_confirmation" type="password" autocomplete="new-password" required class="h-11 rounded-lg border border-zinc-200 px-3 outline-none focus:border-zinc-500" />
                    </label>
                    <button type="submit" :disabled="form.processing" class="h-11 rounded-lg bg-zinc-950 text-sm font-semibold text-white hover:bg-zinc-800 disabled:opacity-60">
                        {{ form.processing ? 'Atualizando...' : 'Redefinir senha' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</template>
