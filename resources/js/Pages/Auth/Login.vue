<script setup>
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Eye,
    LockKeyhole,
    Mail,
    ShieldCheck,
    Smartphone,
    WalletCards,
} from '@lucide/vue';
</script>

<template>
    <main class="min-h-screen bg-[#f7f8f8] text-zinc-950">
        <section class="grid min-h-screen grid-cols-1 lg:grid-cols-[1fr_0.85fr]">
            <div class="flex min-h-screen flex-col px-4 py-5 sm:px-6 lg:px-10">
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

                    <Link href="/" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 text-sm font-semibold text-zinc-800 transition hover:bg-zinc-100">
                        Voltar
                        <ArrowRight class="size-4" />
                    </Link>
                </header>

                <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-10">
                    <div class="mb-8">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-800">
                            <ShieldCheck class="size-3.5" />
                            Acesso seguro
                        </div>
                        <h1 class="text-3xl font-semibold leading-tight text-zinc-950">Entre na sua conta</h1>
                        <p class="mt-3 text-sm leading-6 text-zinc-600">
                            Acesse sua carteira de devedores, dividas e cobrancas com uma sessao protegida.
                        </p>
                    </div>

                    <form class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm">
                        <div class="flex flex-col gap-4">
                            <label class="flex flex-col gap-1.5">
                                <span class="text-sm font-medium text-zinc-700">E-mail</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <Mail class="size-4 text-zinc-400" />
                                    <input
                                        type="email"
                                        autocomplete="email"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="voce@empresa.com"
                                    />
                                </span>
                            </label>

                            <label class="flex flex-col gap-1.5">
                                <span class="flex items-center justify-between gap-3">
                                    <span class="text-sm font-medium text-zinc-700">Senha</span>
                                    <a href="#" class="text-sm font-semibold text-teal-700 hover:text-teal-800">Esqueci minha senha</a>
                                </span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <LockKeyhole class="size-4 text-zinc-400" />
                                    <input
                                        type="password"
                                        autocomplete="current-password"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="Sua senha"
                                    />
                                    <button type="button" class="flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100" title="Mostrar senha">
                                        <Eye class="size-4" />
                                    </button>
                                </span>
                            </label>

                            <label class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-3">
                                <input type="checkbox" class="mt-1 size-4 rounded border-zinc-300 text-zinc-950" />
                                <span class="text-sm leading-5 text-zinc-600">
                                    Manter conectado neste dispositivo confiavel.
                                </span>
                            </label>

                            <button type="button" class="mt-1 flex h-11 items-center justify-center gap-2 rounded-lg bg-zinc-950 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                Entrar
                                <ArrowRight class="size-4" />
                            </button>
                        </div>
                    </form>

                    <p class="mt-5 text-center text-sm text-zinc-600">
                        Ainda nao tem conta?
                        <Link href="/criar-conta" class="font-semibold text-teal-700 hover:text-teal-800">Criar acesso</Link>
                    </p>
                </div>
            </div>

            <aside class="hidden border-l border-zinc-200 bg-zinc-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-teal-200">
                        <LockKeyhole class="size-3.5" />
                        Seguranca por padrao
                    </div>
                    <h2 class="mt-8 max-w-lg text-4xl font-semibold leading-tight">
                        Dados financeiros e pessoais precisam de acesso claro, rastreavel e protegido.
                    </h2>
                </div>

                <div class="grid gap-3">
                    <div class="rounded-lg bg-white/10 p-4">
                        <div class="mb-3 flex items-center gap-2 text-sm font-semibold">
                            <ShieldCheck class="size-4 text-teal-300" />
                            Autorizacao no backend
                        </div>
                        <p class="text-sm leading-6 text-zinc-300">
                            A interface nao substitui policies, filtros por proprietario e trilha de auditoria.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white/10 p-4">
                        <div class="mb-3 flex items-center gap-2 text-sm font-semibold">
                            <Smartphone class="size-4 text-teal-300" />
                            Mobile-first
                        </div>
                        <p class="text-sm leading-6 text-zinc-300">
                            A tela prioriza entrada rapida, contraste alto e campos objetivos para uso recorrente.
                        </p>
                    </div>
                </div>
            </aside>
        </section>
    </main>
</template>
