<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head ,Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-gray-800 text-xl leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <div class="p-6 text-gray-900">You're logged in! See <Link href="/users">Users</Link></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
