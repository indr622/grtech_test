<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';

import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div class="login-container">

            <Head title="Log in" />

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <a-form layout="vertical" @submit.prevent="submit" class="login-form">
                <a-form-item label="Email">
                    <a-input id="email" type="email" class="mt-1 block w-full" v-model:value="form.email" required
                        autofocus autocomplete="username" placeholder="Email Address" />
                    <InputError class="mt-2" :message="form.errors.email" />
                </a-form-item>

                <a-form-item label="Password">
                    <a-input id="password" type="password" class="mt-1 block w-full" v-model:value="form.password"
                        required autocomplete="current-password" placeholder="Password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </a-form-item>



                <div class="flex items-center justify-end mt-4">
                    <a-button html-type="submit" :loading="form.processing" class="ml-4" type="primary">Login</a-button>
                </div>
            </a-form>
        </div>
    </GuestLayout>
</template>

<style scoped>
.login-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 20px;
    background-color: #f9fafb;
}

.login-form {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
</style>
