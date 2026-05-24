<script setup>
import { Link } from '@inertiajs/vue3';
import SidebarUserProfile from '../Components/SidebarUserProfile.vue';
import {
    Bell,
    CheckCircle2,
    CreditCard,
    FileText,
    LayoutDashboard,
    Mail,
    Phone,
    ShieldCheck,
    UserRound,
    Users,
    WalletCards,
} from '@lucide/vue';

defineProps({
    user: Object,
});

const navItems = [
    { label: 'Painel', icon: LayoutDashboard, href: '/' },
    { label: 'Perfil', icon: UserRound, href: '/perfil', active: true },
    { label: 'Devedores', icon: Users, href: '/devedores' },
    { label: 'Dividas', icon: FileText, href: '/dividas' },
    { label: 'Pagamentos', icon: CreditCard, href: '#' },
    { label: 'Cobrancas', icon: Bell, href: '#' },
];
</script>

<template>
    <main class="min-h-screen bg-[#f7f8f8]">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-64 border-r border-zinc-200 bg-white px-4 py-5 lg:block">
            <div class="flex h-full flex-col justify-between gap-8">
                <div class="flex flex-col gap-7">
                    <Link href="/" class="flex items-center gap-3 rounded-lg px-2">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-zinc-950 text-white">
                            <WalletCards class="size-5" />
                        </div>
                        <div>
                            <p class="text-base font-semibold text-zinc-950">Caducou</p>
                            <p class="text-xs text-zinc-500">Controle de dividas</p>
                        </div>
                    </Link>

                    <nav class="flex flex-col gap-1">
                        <Link
                            v-for="item in navItems"
                            :key="item.label"
                            :href="item.href"
                            :class="[
                                'flex h-11 items-center gap-3 rounded-lg px-3 text-sm font-medium transition',
                                item.active
                                    ? 'bg-zinc-950 text-white'
                                    : 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-950',
                            ]"
                        >
                            <component :is="item.icon" class="size-4" />
                            <span>{{ item.label }}</span>
                        </Link>
                    </nav>
                </div>

                <SidebarUserProfile />
            </div>
        </aside>

        <section class="lg:pl-64">
            <header class="sticky top-0 z-10 border-b border-zinc-200 bg-white/90 backdrop-blur">
                <div class="flex min-h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-zinc-950 text-white lg:hidden">
                            <WalletCards class="size-5" />
                        </div>
                        <div class="min-w-0">
                            <p class="truncate text-sm text-zinc-500">Conta ativa</p>
                            <h1 class="truncate text-lg font-semibold text-zinc-950 sm:text-xl">Perfil do usuario</h1>
                        </div>
                    </div>
                </div>
            </header>

            <div class="mx-auto flex w-full max-w-5xl flex-col gap-6 px-4 py-5 sm:px-6 lg:px-8">
                <section class="rounded-lg border border-zinc-200 bg-white p-5">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <div class="flex size-14 items-center justify-center rounded-lg bg-zinc-950 text-white">
                                <UserRound class="size-7" />
                            </div>
                            <div>
                                <p class="text-2xl font-semibold text-zinc-950">{{ user.name }}</p>
                                <p class="mt-1 text-sm text-zinc-500">{{ user.email }}</p>
                            </div>
                        </div>

                        <span
                            :class="[
                                'inline-flex h-9 items-center gap-2 rounded-lg px-3 text-sm font-semibold ring-1',
                                user.emailVerified
                                    ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                                    : 'bg-amber-50 text-amber-800 ring-amber-200',
                            ]"
                        >
                            <CheckCircle2 v-if="user.emailVerified" class="size-4" />
                            <ShieldCheck v-else class="size-4" />
                            {{ user.emailVerified ? 'E-mail validado' : 'E-mail pendente' }}
                        </span>
                    </div>
                </section>

                <section class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <article class="rounded-lg border border-zinc-200 bg-white p-5">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold text-zinc-950">Dados da conta</h2>
                                <p class="mt-1 text-sm text-zinc-500">Informacoes minimas do usuario credor.</p>
                            </div>
                            <UserRound class="size-5 text-teal-700" />
                        </div>

                        <dl class="grid gap-4">
                            <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                                <dt class="text-xs font-medium text-zinc-500">Tipo de uso</dt>
                                <dd class="mt-1 text-sm font-semibold text-zinc-950">{{ user.accountType }}</dd>
                            </div>
                            <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                                <dt class="text-xs font-medium text-zinc-500">Conta criada em</dt>
                                <dd class="mt-1 text-sm font-semibold text-zinc-950">{{ user.createdAt }}</dd>
                            </div>
                            <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                                <dt class="text-xs font-medium text-zinc-500">Termos aceitos em</dt>
                                <dd class="mt-1 text-sm font-semibold text-zinc-950">{{ user.termsAcceptedAt || 'Pendente' }}</dd>
                            </div>
                        </dl>
                    </article>

                    <article class="rounded-lg border border-zinc-200 bg-white p-5">
                        <div class="mb-5 flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold text-zinc-950">Comunicacao</h2>
                                <p class="mt-1 text-sm text-zinc-500">Canais usados para acesso e avisos importantes.</p>
                            </div>
                            <Mail class="size-5 text-teal-700" />
                        </div>

                        <dl class="grid gap-4">
                            <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                                <dt class="flex items-center gap-2 text-xs font-medium text-zinc-500">
                                    <Mail class="size-3.5" />
                                    E-mail
                                </dt>
                                <dd class="mt-1 break-all text-sm font-semibold text-zinc-950">{{ user.email }}</dd>
                            </div>
                            <div class="rounded-lg border border-zinc-100 bg-zinc-50 p-3">
                                <dt class="flex items-center gap-2 text-xs font-medium text-zinc-500">
                                    <Phone class="size-3.5" />
                                    Telefone
                                </dt>
                                <dd class="mt-1 text-sm font-semibold text-zinc-950">{{ user.phone || 'Nao informado' }}</dd>
                            </div>
                        </dl>
                    </article>
                </section>

                <section class="rounded-lg border border-teal-200 bg-teal-50 p-5">
                    <div class="flex items-start gap-3">
                        <ShieldCheck class="mt-0.5 size-5 text-teal-700" />
                        <div>
                            <h2 class="text-sm font-semibold text-teal-900">Verificacao documental</h2>
                            <p class="mt-2 text-sm leading-6 text-teal-900">
                                Esta conta pode explorar o Caducou. Fluxos de cobranca interna com envio ao devedor exigirao verificacao documental em etapa futura.
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </main>
</template>
