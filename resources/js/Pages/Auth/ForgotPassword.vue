<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Mail, ShieldCheck, WalletCards } from '@lucide/vue';

const page = usePage();
const form = useForm({ email: '' });

function submit() {
    form.post('/esqueci-senha');
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
                    <ShieldCheck class="size-4" /> Recuperação de acesso
                </div>
                <h1 class="text-2xl font-semibold">Esqueceu sua senha?</h1>
                <p class="mt-2 text-sm leading-6 text-zinc-600">Informe seu e-mail. Se houver uma conta, enviaremos um link seguro para redefinir a senha.</p>
                <p v-if="page.props.flash?.status" role="status" class="mt-4 rounded-lg bg-teal-50 p-3 text-sm text-teal-800">{{ page.props.flash.status }}</p>
                <form class="mt-6 grid gap-4" @submit.prevent="submit">
                    <label class="grid gap-1.5 text-sm font-medium text-zinc-700" for="email">E-mail
                        <span class="flex items-center gap-2 rounded-lg border border-zinc-200 px-3">
                            <Mail class="size-4 text-zinc-400" />
                            <input id="email" v-model="form.email" type="email" required autocomplete="email" placeholder="voce@empresa.com" class="h-11 w-full outline-none" />
                        </span>
                    </label>
                    <p v-if="form.errors.email" role="alert" class="text-sm text-red-700">{{ form.errors.email }}</p>
                    <button type="submit" :disabled="form.processing" class="h-11 rounded-lg bg-zinc-950 text-sm font-semibold text-white hover:bg-zinc-800 disabled:opacity-60">
                        {{ form.processing ? 'Solicitando...' : 'Enviar link de recuperação' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</template>
