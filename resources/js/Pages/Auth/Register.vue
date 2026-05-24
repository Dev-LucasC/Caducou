<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import {
    ArrowRight,
    Building2,
    CheckCircle2,
    Eye,
    LockKeyhole,
    Mail,
    Phone,
    ShieldCheck,
    UserRound,
    WalletCards,
} from '@lucide/vue';

const checklist = [
    'Cadastro com dados minimos',
    'Cobrancas sempre revisadas no MVP',
    'Dados financeiros isolados por conta',
];

const form = useForm({
    name: '',
    email: '',
    phone: '',
    account_type: 'individual',
    password: '',
    password_confirmation: '',
    terms_accepted: false,
});

function submit() {
    form.post('/criar-conta', {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <main class="min-h-screen bg-[#f7f8f8] text-zinc-950">
        <section class="grid min-h-screen grid-cols-1 lg:grid-cols-[0.9fr_1fr]">
            <aside class="hidden border-r border-zinc-200 bg-zinc-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <Link href="/" class="flex items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-white text-zinc-950">
                            <WalletCards class="size-5" />
                        </div>
                        <div>
                            <p class="text-base font-semibold">Caducou</p>
                            <p class="text-xs text-zinc-400">Controle de dividas</p>
                        </div>
                    </Link>

                    <div class="mt-16 max-w-xl">
                        <div class="mb-5 inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-teal-200">
                            <ShieldCheck class="size-3.5" />
                            Conta segura desde o inicio
                        </div>
                        <h1 class="text-4xl font-semibold leading-tight">
                            Organize dividas, pagamentos e cobrancas sem transformar isso em burocracia.
                        </h1>
                        <p class="mt-5 text-sm leading-6 text-zinc-300">
                            O cadastro inicial coleta apenas o necessario para criar a conta do credor. Dados adicionais entram somente quando houver finalidade clara.
                        </p>
                    </div>
                </div>

                <div class="grid gap-3">
                    <div
                        v-for="item in checklist"
                        :key="item"
                        class="flex items-center gap-3 rounded-lg bg-white/10 p-4 text-sm font-medium text-zinc-100"
                    >
                        <CheckCircle2 class="size-4 text-teal-300" />
                        {{ item }}
                    </div>
                </div>
            </aside>

            <div class="flex min-h-screen flex-col px-4 py-5 sm:px-6 lg:px-10">
                <header class="flex items-center justify-between gap-4">
                    <Link href="/" class="flex items-center gap-3 lg:hidden">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-zinc-950 text-white">
                            <WalletCards class="size-5" />
                        </div>
                        <div>
                            <p class="text-base font-semibold">Caducou</p>
                            <p class="text-xs text-zinc-500">Controle de dividas</p>
                        </div>
                    </Link>

                    <div class="hidden lg:block"></div>

                    <Link href="/login" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 text-sm font-semibold text-zinc-800 transition hover:bg-zinc-100">
                        Ja tenho conta
                        <ArrowRight class="size-4" />
                    </Link>
                </header>

                <div class="mx-auto flex w-full max-w-xl flex-1 flex-col justify-center py-10">
                    <div class="mb-8">
                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-800">
                            <UserRound class="size-3.5" />
                            Criar conta
                        </div>
                        <h2 class="text-3xl font-semibold leading-tight text-zinc-950">Comece com seu acesso de credor</h2>
                        <p class="mt-3 text-sm leading-6 text-zinc-600">
                            Crie sua conta com validacao de e-mail obrigatoria antes de usar recursos sensiveis de cobranca.
                        </p>
                    </div>

                    <form class="rounded-lg border border-zinc-200 bg-white p-5 shadow-sm" @submit.prevent="submit">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="flex flex-col gap-1.5 sm:col-span-2">
                                <span class="text-sm font-medium text-zinc-700">Nome completo</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <UserRound class="size-4 text-zinc-400" />
                                    <input
                                        type="text"
                                        v-model="form.name"
                                        autocomplete="name"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="Seu nome"
                                    />
                                </span>
                                <span v-if="form.errors.name" class="text-xs font-medium text-red-600">{{ form.errors.name }}</span>
                            </label>

                            <label class="flex flex-col gap-1.5 sm:col-span-2">
                                <span class="text-sm font-medium text-zinc-700">E-mail</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <Mail class="size-4 text-zinc-400" />
                                    <input
                                        type="email"
                                        v-model="form.email"
                                        autocomplete="email"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="voce@empresa.com"
                                    />
                                </span>
                                <span v-if="form.errors.email" class="text-xs font-medium text-red-600">{{ form.errors.email }}</span>
                            </label>

                            <label class="flex flex-col gap-1.5">
                                <span class="text-sm font-medium text-zinc-700">Telefone</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <Phone class="size-4 text-zinc-400" />
                                    <input
                                        type="tel"
                                        v-model="form.phone"
                                        autocomplete="tel"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="Opcional"
                                    />
                                </span>
                                <span v-if="form.errors.phone" class="text-xs font-medium text-red-600">{{ form.errors.phone }}</span>
                            </label>

                            <label class="flex flex-col gap-1.5">
                                <span class="text-sm font-medium text-zinc-700">Tipo de uso</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <Building2 class="size-4 text-zinc-400" />
                                    <select v-model="form.account_type" class="w-full bg-transparent text-sm outline-none">
                                        <option value="individual">Pessoa fisica</option>
                                        <option value="small_business">Pequeno negocio</option>
                                        <option value="service_provider">Prestador de servico</option>
                                    </select>
                                </span>
                                <span v-if="form.errors.account_type" class="text-xs font-medium text-red-600">{{ form.errors.account_type }}</span>
                            </label>

                            <label class="flex flex-col gap-1.5 sm:col-span-2">
                                <span class="text-sm font-medium text-zinc-700">Senha</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <LockKeyhole class="size-4 text-zinc-400" />
                                    <input
                                        type="password"
                                        v-model="form.password"
                                        autocomplete="new-password"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="Crie uma senha segura"
                                    />
                                    <button type="button" class="flex size-8 items-center justify-center rounded-md text-zinc-500 transition hover:bg-zinc-100" title="Mostrar senha">
                                        <Eye class="size-4" />
                                    </button>
                                </span>
                                <span v-if="form.errors.password" class="text-xs font-medium text-red-600">{{ form.errors.password }}</span>
                            </label>

                            <label class="flex flex-col gap-1.5 sm:col-span-2">
                                <span class="text-sm font-medium text-zinc-700">Confirmar senha</span>
                                <span class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 px-3 transition focus-within:border-zinc-400">
                                    <LockKeyhole class="size-4 text-zinc-400" />
                                    <input
                                        type="password"
                                        v-model="form.password_confirmation"
                                        autocomplete="new-password"
                                        class="w-full text-sm outline-none placeholder:text-zinc-400"
                                        placeholder="Repita a senha"
                                    />
                                </span>
                            </label>

                            <label class="flex items-start gap-3 rounded-lg border border-zinc-200 bg-zinc-50 p-3 sm:col-span-2">
                                <input v-model="form.terms_accepted" type="checkbox" class="mt-1 size-4 rounded border-zinc-300 text-zinc-950" />
                                <span class="text-sm leading-5 text-zinc-600">
                                    Entendo que dados de devedores serao tratados somente para controle de dividas e cobrancas autorizadas.
                                </span>
                            </label>
                            <span v-if="form.errors.terms_accepted" class="text-xs font-medium text-red-600 sm:col-span-2">{{ form.errors.terms_accepted }}</span>

                            <button type="submit" :disabled="form.processing" class="flex h-11 items-center justify-center gap-2 rounded-lg bg-zinc-950 text-sm font-semibold text-white transition hover:bg-zinc-800 disabled:cursor-not-allowed disabled:opacity-60 sm:col-span-2">
                                {{ form.processing ? 'Criando conta...' : 'Criar conta' }}
                                <ArrowRight class="size-4" />
                            </button>
                        </div>
                    </form>

                    <p class="mt-5 text-center text-sm text-zinc-600">
                        Ja tem acesso?
                        <Link href="/login" class="font-semibold text-teal-700 hover:text-teal-800">Entrar na conta</Link>
                    </p>
                </div>
            </div>
        </section>
    </main>
</template>
