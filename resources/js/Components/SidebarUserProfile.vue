<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { CheckCircle2, LogIn, ShieldCheck, UserRound } from '@lucide/vue';
import { computed } from 'vue';

const page = usePage();

const user = computed(() => page.props.auth?.user);
const initials = computed(() => {
    if (!user.value?.name) {
        return 'VC';
    }

    return user.value.name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((part) => part[0])
        .join('')
        .toUpperCase();
});
</script>

<template>
    <Link
        v-if="user"
        href="/perfil"
        class="block rounded-lg border border-zinc-200 bg-zinc-50 p-3 transition hover:border-zinc-300 hover:bg-white"
    >
        <div class="flex items-center gap-3">
            <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-950 text-sm font-semibold text-white">
                {{ initials }}
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-zinc-950">{{ user.name }}</p>
                <p class="truncate text-xs text-zinc-500">{{ user.email }}</p>
            </div>
        </div>

        <div class="mt-3 flex items-center justify-between gap-2">
            <span class="truncate text-xs font-medium text-zinc-500">{{ user.accountType }}</span>
            <span
                :class="[
                    'inline-flex shrink-0 items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold ring-1',
                    user.emailVerified
                        ? 'bg-emerald-50 text-emerald-700 ring-emerald-200'
                        : 'bg-amber-50 text-amber-800 ring-amber-200',
                ]"
            >
                <CheckCircle2 v-if="user.emailVerified" class="size-3" />
                <ShieldCheck v-else class="size-3" />
                {{ user.emailVerified ? 'Validado' : 'Pendente' }}
            </span>
        </div>
    </Link>

    <Link
        v-else
        href="/login"
        class="block rounded-lg border border-zinc-200 bg-zinc-50 p-3 transition hover:border-zinc-300 hover:bg-white"
    >
        <div class="flex items-center gap-3">
            <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-zinc-950 text-white">
                <UserRound class="size-5" />
            </div>
            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-zinc-950">Sessao visitante</p>
                <p class="truncate text-xs text-zinc-500">Entre para ver seu perfil</p>
            </div>
        </div>

        <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-teal-700">
            <LogIn class="size-3.5" />
            Acessar conta
        </div>
    </Link>
</template>
