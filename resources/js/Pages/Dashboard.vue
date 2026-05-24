<script setup>
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Bell,
    CheckCircle2,
    CircleDollarSign,
    Clock3,
    CreditCard,
    FileText,
    LayoutDashboard,
    LockKeyhole,
    Mail,
    Plus,
    Search,
    ShieldCheck,
    Users,
    WalletCards,
} from '@lucide/vue';

defineProps({
    summary: Object,
    debts: Array,
    timeline: Array,
});

const quickActions = [
    { label: 'Novo devedor', icon: Users },
    { label: 'Nova divida', icon: Plus },
    { label: 'Registrar pagamento', icon: CircleDollarSign },
    { label: 'Preparar cobranca', icon: Mail },
];

const navItems = [
    { label: 'Painel', icon: LayoutDashboard, href: '/', active: true },
    { label: 'Devedores', icon: Users, href: '/devedores' },
    { label: 'Dividas', icon: FileText, href: '/dividas' },
    { label: 'Pagamentos', icon: CreditCard, href: '#' },
    { label: 'Cobrancas', icon: Bell, href: '#' },
];

const statCards = [
    { label: 'Em aberto', key: 'openAmount', icon: WalletCards, helper: 'Saldo total acompanhado' },
    { label: 'Vencido', key: 'overdueAmount', icon: Clock3, helper: 'Requer revisao manual' },
    { label: 'Recebido no mes', key: 'receivedThisMonth', icon: CheckCircle2, helper: 'Pagamentos confirmados' },
    { label: 'Recuperacao', key: 'recoveryRate', icon: ShieldCheck, helper: 'Indicador operacional' },
];

function statusClass(tone) {
    return {
        ok: 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        warn: 'bg-amber-50 text-amber-700 ring-amber-200',
        risk: 'bg-red-50 text-red-700 ring-red-200',
    }[tone] || 'bg-zinc-100 text-zinc-700 ring-zinc-200';
}
</script>

<template>
    <main class="min-h-screen bg-[#f7f8f8]">
        <aside class="fixed inset-y-0 left-0 z-20 hidden w-64 border-r border-zinc-200 bg-white px-4 py-5 lg:block">
            <div class="flex h-full flex-col justify-between gap-8">
                <div class="flex flex-col gap-7">
                    <div class="flex items-center gap-3 px-2">
                        <div class="flex size-10 items-center justify-center rounded-lg bg-zinc-950 text-white">
                            <WalletCards class="size-5" />
                        </div>
                        <div>
                            <p class="text-base font-semibold text-zinc-950">Caducou</p>
                            <p class="text-xs text-zinc-500">Controle de dividas</p>
                        </div>
                    </div>

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

                <section class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900">
                        <LockKeyhole class="size-4 text-teal-700" />
                        LGPD ativo
                    </div>
                    <p class="text-xs leading-5 text-zinc-600">
                        Coleta minima, revisao humana para cobrancas e trilha de auditoria nas acoes sensiveis.
                    </p>
                </section>
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
                            <p class="truncate text-sm text-zinc-500">Hoje</p>
                            <h1 class="truncate text-lg font-semibold text-zinc-950 sm:text-xl">Painel financeiro</h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="hidden h-10 items-center gap-2 rounded-lg border border-zinc-200 bg-white px-3 text-sm text-zinc-500 md:flex">
                            <Search class="size-4" />
                            <input class="w-56 outline-none placeholder:text-zinc-400" placeholder="Buscar devedor ou divida" />
                        </label>
                        <button type="button" class="flex size-10 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-700 transition hover:bg-zinc-100" title="Notificacoes">
                            <Bell class="size-4" />
                        </button>
                    </div>
                </div>
            </header>

            <div class="mx-auto flex w-full max-w-7xl flex-col gap-6 px-4 py-5 sm:px-6 lg:px-8">
                <section class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
                    <article
                        v-for="card in statCards"
                        :key="card.label"
                        class="rounded-lg border border-zinc-200 bg-white p-4"
                    >
                        <div class="mb-4 flex items-center justify-between gap-3">
                            <p class="text-sm font-medium text-zinc-500">{{ card.label }}</p>
                            <component :is="card.icon" class="size-5 text-teal-700" />
                        </div>
                        <p class="text-2xl font-semibold text-zinc-950">{{ summary[card.key] }}</p>
                        <p class="mt-2 text-xs text-zinc-500">{{ card.helper }}</p>
                    </article>
                </section>

                <section class="grid grid-cols-1 gap-6 xl:grid-cols-[1fr_360px]">
                    <div class="flex flex-col gap-6">
                        <section class="rounded-lg border border-zinc-200 bg-white">
                            <div class="flex flex-col gap-3 border-b border-zinc-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h2 class="text-base font-semibold text-zinc-950">Dividas prioritarias</h2>
                                    <p class="mt-1 text-sm text-zinc-500">Ordene a proxima acao sem perder o historico.</p>
                                </div>
                                <button type="button" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-zinc-950 px-4 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                    <Plus class="size-4" />
                                    Nova divida
                                </button>
                            </div>

                            <div class="divide-y divide-zinc-100">
                                <article
                                    v-for="debt in debts"
                                    :key="debt.debtor"
                                    class="grid grid-cols-1 gap-4 p-4 transition hover:bg-zinc-50 md:grid-cols-[1.4fr_1fr_auto]"
                                >
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="font-semibold text-zinc-950">{{ debt.debtor }}</h3>
                                            <span :class="['rounded-full px-2.5 py-1 text-xs font-semibold ring-1', statusClass(debt.tone)]">
                                                {{ debt.status }}
                                            </span>
                                        </div>
                                        <p class="mt-1 text-sm text-zinc-500">{{ debt.description }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <p class="text-xs text-zinc-500">Valor atual</p>
                                            <p class="mt-1 font-semibold text-zinc-950">{{ debt.amount }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Ja pago</p>
                                            <p class="mt-1 font-semibold text-zinc-950">{{ debt.paid }}</p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="text-xs text-zinc-500">Vencimento</p>
                                            <p class="mt-1 font-medium text-zinc-800">{{ debt.due }}</p>
                                        </div>
                                    </div>

                                    <button type="button" class="flex h-10 items-center justify-center gap-2 rounded-lg border border-zinc-200 px-3 text-sm font-semibold text-zinc-800 transition hover:bg-zinc-100">
                                        Abrir
                                        <ArrowRight class="size-4" />
                                    </button>
                                </article>
                            </div>
                        </section>

                        <section class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                            <button
                                v-for="action in quickActions"
                                :key="action.label"
                                type="button"
                                class="flex min-h-24 items-start justify-between gap-4 rounded-lg border border-zinc-200 bg-white p-4 text-left transition hover:border-zinc-300 hover:bg-zinc-50"
                            >
                                <span class="text-sm font-semibold text-zinc-900">{{ action.label }}</span>
                                <component :is="action.icon" class="size-5 text-teal-700" />
                            </button>
                        </section>
                    </div>

                    <aside class="flex flex-col gap-6">
                        <section class="rounded-lg border border-zinc-200 bg-zinc-950 p-5 text-white">
                            <div class="flex items-center gap-2 text-sm font-semibold">
                                <ShieldCheck class="size-4 text-teal-300" />
                                Proxima acao recomendada
                            </div>
                            <p class="mt-4 text-2xl font-semibold leading-tight">Revisar cobranca antes do envio</p>
                            <p class="mt-3 text-sm leading-6 text-zinc-300">
                                O MVP mantem cobrancas manuais ou semi-automaticas, com confirmacao do usuario e historico de envio.
                            </p>
                            <button type="button" class="mt-5 flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-white text-sm font-semibold text-zinc-950 transition hover:bg-zinc-100">
                                <Mail class="size-4" />
                                Revisar mensagem
                            </button>
                        </section>

                        <section class="rounded-lg border border-zinc-200 bg-white p-4">
                            <div class="mb-4 flex items-center justify-between gap-3">
                                <h2 class="text-base font-semibold text-zinc-950">Historico recente</h2>
                                <Clock3 class="size-4 text-zinc-500" />
                            </div>
                            <div class="flex flex-col gap-3">
                                <article
                                    v-for="item in timeline"
                                    :key="item.title"
                                    class="rounded-lg border border-zinc-100 bg-zinc-50 p-3"
                                >
                                    <p class="text-sm font-semibold text-zinc-900">{{ item.title }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">{{ item.meta }}</p>
                                </article>
                            </div>
                        </section>
                    </aside>
                </section>
            </div>
        </section>
    </main>
</template>
