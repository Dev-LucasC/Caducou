<script setup>
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Bell,
    CheckCircle2,
    Clock3,
    CreditCard,
    FileText,
    Filter,
    LayoutDashboard,
    LockKeyhole,
    Mail,
    Plus,
    Search,
    ShieldCheck,
    SlidersHorizontal,
    Users,
    WalletCards,
} from '@lucide/vue';

defineProps({
    summary: Object,
    debts: Array,
    statusBreakdown: Array,
});

const navItems = [
    { label: 'Painel', icon: LayoutDashboard, href: '/' },
    { label: 'Devedores', icon: Users, href: '/devedores' },
    { label: 'Dividas', icon: FileText, href: '/dividas', active: true },
    { label: 'Pagamentos', icon: CreditCard, href: '#' },
    { label: 'Cobrancas', icon: Bell, href: '#' },
];

const statCards = [
    { label: 'Saldo em aberto', key: 'openAmount', icon: WalletCards, helper: 'Total ainda pendente' },
    { label: 'Saldo vencido', key: 'overdueAmount', icon: Bell, helper: 'Exige acao revisada' },
    { label: 'Parcialmente pago', key: 'partialAmount', icon: CheckCircle2, helper: 'Com historico de baixa' },
    { label: 'Rascunhos', key: 'draftCount', icon: FileText, helper: 'Ainda incompletos' },
];

function statusClass(tone) {
    return {
        ok: 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        warn: 'bg-amber-50 text-amber-700 ring-amber-200',
        risk: 'bg-red-50 text-red-700 ring-red-200',
        neutral: 'bg-zinc-100 text-zinc-700 ring-zinc-200',
    }[tone] || 'bg-zinc-100 text-zinc-700 ring-zinc-200';
}
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

                <section class="rounded-lg border border-zinc-200 bg-zinc-50 p-4">
                    <div class="mb-3 flex items-center gap-2 text-sm font-semibold text-zinc-900">
                        <LockKeyhole class="size-4 text-teal-700" />
                        Integridade financeira
                    </div>
                    <p class="text-xs leading-5 text-zinc-600">
                        Valores exibidos sao demonstrativos. Calculos reais exigem spec, testes e auditoria.
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
                            <p class="truncate text-sm text-zinc-500">Controle financeiro</p>
                            <h1 class="truncate text-lg font-semibold text-zinc-950 sm:text-xl">Dividas</h1>
                        </div>
                    </div>

                    <button type="button" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-zinc-950 px-4 text-sm font-semibold text-white transition hover:bg-zinc-800">
                        <Plus class="size-4" />
                        Nova divida
                    </button>
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
                            <div class="flex flex-col gap-4 border-b border-zinc-200 p-4">
                                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <h2 class="text-base font-semibold text-zinc-950">Carteira de dividas</h2>
                                        <p class="mt-1 text-sm text-zinc-500">Acompanhe status, saldo e proxima acao sem alterar historico.</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" class="flex size-10 items-center justify-center rounded-lg border border-zinc-200 text-zinc-700 transition hover:bg-zinc-100" title="Filtros">
                                            <Filter class="size-4" />
                                        </button>
                                        <button type="button" class="flex size-10 items-center justify-center rounded-lg border border-zinc-200 text-zinc-700 transition hover:bg-zinc-100" title="Ordenacao">
                                            <SlidersHorizontal class="size-4" />
                                        </button>
                                    </div>
                                </div>

                                <label class="flex h-11 items-center gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 text-sm text-zinc-500">
                                    <Search class="size-4" />
                                    <input class="w-full bg-transparent outline-none placeholder:text-zinc-400" placeholder="Buscar por codigo, devedor ou descricao" />
                                </label>
                            </div>

                            <div class="divide-y divide-zinc-100">
                                <article
                                    v-for="debt in debts"
                                    :key="debt.id"
                                    class="grid grid-cols-1 gap-4 p-4 transition hover:bg-zinc-50 xl:grid-cols-[1.2fr_1.3fr_auto]"
                                >
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-md bg-zinc-100 px-2 py-1 text-xs font-semibold text-zinc-700">{{ debt.id }}</span>
                                            <span :class="['rounded-full px-2.5 py-1 text-xs font-semibold ring-1', statusClass(debt.tone)]">
                                                {{ debt.status }}
                                            </span>
                                        </div>
                                        <h3 class="mt-3 font-semibold text-zinc-950">{{ debt.debtor }}</h3>
                                        <p class="mt-1 text-sm text-zinc-500">{{ debt.description }}</p>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-sm md:grid-cols-3">
                                        <div>
                                            <p class="text-xs text-zinc-500">Original</p>
                                            <p class="mt-1 font-semibold text-zinc-950">{{ debt.originalAmount }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Atual</p>
                                            <p class="mt-1 font-semibold text-zinc-950">{{ debt.currentAmount }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Pago</p>
                                            <p class="mt-1 font-semibold text-zinc-950">{{ debt.paidAmount }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Origem</p>
                                            <p class="mt-1 font-medium text-zinc-800">{{ debt.originDate }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Vencimento</p>
                                            <p class="mt-1 font-medium text-zinc-800">{{ debt.dueDate }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-zinc-500">Proxima acao</p>
                                            <p class="mt-1 font-medium text-zinc-800">{{ debt.nextAction }}</p>
                                        </div>
                                    </div>

                                    <button type="button" class="flex h-10 items-center justify-center gap-2 rounded-lg border border-zinc-200 px-3 text-sm font-semibold text-zinc-800 transition hover:bg-zinc-100">
                                        Abrir
                                        <ArrowRight class="size-4" />
                                    </button>
                                </article>
                            </div>
                        </section>
                    </div>

                    <aside class="flex flex-col gap-6">
                        <section class="rounded-lg border border-zinc-200 bg-white p-5">
                            <div class="mb-5 flex items-center justify-between gap-3">
                                <div>
                                    <h2 class="text-base font-semibold text-zinc-950">Nova divida</h2>
                                    <p class="mt-1 text-sm text-zinc-500">Rascunho visual sem gravacao.</p>
                                </div>
                                <FileText class="size-5 text-teal-700" />
                            </div>

                            <form class="flex flex-col gap-4">
                                <label class="flex flex-col gap-1.5">
                                    <span class="text-sm font-medium text-zinc-700">Devedor</span>
                                    <input class="h-11 rounded-lg border border-zinc-200 px-3 text-sm outline-none transition focus:border-zinc-400" placeholder="Selecione ou busque" />
                                </label>
                                <label class="flex flex-col gap-1.5">
                                    <span class="text-sm font-medium text-zinc-700">Valor original</span>
                                    <input class="h-11 rounded-lg border border-zinc-200 px-3 text-sm outline-none transition focus:border-zinc-400" placeholder="R$ 0,00" />
                                </label>
                                <label class="flex flex-col gap-1.5">
                                    <span class="text-sm font-medium text-zinc-700">Data de origem</span>
                                    <input class="h-11 rounded-lg border border-zinc-200 px-3 text-sm outline-none transition focus:border-zinc-400" placeholder="Obrigatoria para ativar" />
                                </label>
                                <label class="flex flex-col gap-1.5">
                                    <span class="text-sm font-medium text-zinc-700">Vencimento</span>
                                    <input class="h-11 rounded-lg border border-zinc-200 px-3 text-sm outline-none transition focus:border-zinc-400" placeholder="Recomendado" />
                                </label>
                                <button type="button" class="mt-1 flex h-11 items-center justify-center gap-2 rounded-lg bg-zinc-950 text-sm font-semibold text-white transition hover:bg-zinc-800">
                                    <Plus class="size-4" />
                                    Salvar rascunho
                                </button>
                            </form>
                        </section>

                        <section class="rounded-lg border border-zinc-200 bg-zinc-950 p-5 text-white">
                            <div class="flex items-center gap-2 text-sm font-semibold">
                                <ShieldCheck class="size-4 text-teal-300" />
                                Status controlado
                            </div>
                            <div class="mt-5 flex flex-col gap-3">
                                <div
                                    v-for="item in statusBreakdown"
                                    :key="item.label"
                                    class="flex items-center justify-between rounded-lg bg-white/10 px-3 py-2 text-sm"
                                >
                                    <span class="text-zinc-200">{{ item.label }}</span>
                                    <span class="font-semibold">{{ item.value }}</span>
                                </div>
                            </div>
                        </section>

                        <section class="rounded-lg border border-amber-200 bg-amber-50 p-5">
                            <div class="flex items-center gap-2 text-sm font-semibold text-amber-800">
                                <Clock3 class="size-4" />
                                Juros e multa
                            </div>
                            <p class="mt-3 text-sm leading-6 text-amber-800">
                                Calculo automatico nao esta ativo no MVP. Qualquer regra de acrescimo precisa de spec juridica e testes financeiros.
                            </p>
                        </section>
                    </aside>
                </section>
            </div>
        </section>
    </main>
</template>
