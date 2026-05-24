<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import {
    ArrowRight,
    CheckCircle2,
    Mail,
    RotateCw,
    ShieldCheck,
    WalletCards,
} from '@lucide/vue';

const form = useForm({});

function resend() {
    form.post('/email/reenviar');
}
</script>

<template>
    <main class="min-h-screen bg-[#f7f8f8] text-zinc-950">
        <section class="mx-auto flex min-h-screen w-full max-w-xl flex-col px-4 py-5 sm:px-6">
            <header class="flex items-center justify-between gap-4">
                <Link href="/" class="flex items-center gap-3">
                    <div class="flex size-10 items-center justify-center rounded-lg bg-zinc-950 text-white">
                        <WalletCards class="size-5" />
                    </div>
                    <div>
                        <p class="text-base font-semibold">Caducou</p>
                        <p class="text-xs text-zinc-500">Controle de dividas</p>
                    </div>
                </Link>
            </header>

            <div class="flex flex-1 flex-col justify-center py-10">
                <div class="rounded-lg border border-zinc-200 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex size-12 items-center justify-center rounded-lg bg-teal-50 text-teal-700">
                        <Mail class="size-6" />
                    </div>

                    <div class="mb-6">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-800">
                            <ShieldCheck class="size-3.5" />
                            Confirme seu e-mail
                        </div>
                        <h1 class="text-3xl font-semibold leading-tight">Quase pronto</h1>
                        <p class="mt-3 text-sm leading-6 text-zinc-600">
                            Enviamos um link de validacao para o e-mail cadastrado. Clique no botao da mensagem para voltar ao Caducou ja autenticado no Dashboard.
                        </p>
                    </div>

                    <div class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                        <div class="flex items-start gap-3">
                            <CheckCircle2 class="mt-0.5 size-4 text-teal-700" />
                            <p class="text-sm leading-6 text-zinc-600">
                                Se o e-mail nao chegou, confira a caixa de spam ou solicite um novo envio.
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <button type="button" :disabled="form.processing" class="flex h-11 items-center justify-center gap-2 rounded-lg bg-zinc-950 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-60" @click="resend">
                            <RotateCw class="size-4" />
                            {{ form.processing ? 'Enviando...' : 'Reenviar e-mail' }}
                        </button>
                        <Link href="/login" class="flex h-11 items-center justify-center gap-2 rounded-lg border border-zinc-200 text-sm font-semibold text-zinc-800 transition hover:bg-zinc-100">
                            Ir para login
                            <ArrowRight class="size-4" />
                        </Link>
                    </div>
                </div>
            </div>
        </section>
    </main>
</template>
