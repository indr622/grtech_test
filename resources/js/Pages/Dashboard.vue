<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <h3>Welcome , {{ $page.props.auth.user.name }}</h3>
    </AuthenticatedLayout>
</template>
