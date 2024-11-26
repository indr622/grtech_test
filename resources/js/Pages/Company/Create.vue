<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    website: '',
    logo: '',
});

const submit = () => {
    const formData = new FormData();
    formData.append('name', form.name);
    formData.append('email', form.email);
    formData.append('website', form.website);
    if (form.logo) {
        formData.append('logo', form.logo);
    }
    form.post(route('companies.store'));
};
const handleLogoChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.logo = file;
    }
};

</script>

<template>

    <Head title="Create Company" />

    <AuthenticatedLayout>
        <a-form layout="vertical" @submit.prevent="submit">
            <a-form-item label=" Name" name="name" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.name" placeholder="Name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </a-form-item>
            <a-form-item label="Email" name="email" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.email" placeholder="Email" />
                <InputError class="mt-2" :message="form.errors.email" />
            </a-form-item>
            <a-form-item label="Website" name="website" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.website" placeholder="Website" />
                <InputError class="mt-2" :message="form.errors.website" />
            </a-form-item>

            <a-form-item label="Logo" name="logo" :wrapper-col="{ span: 10 }">
                <a-input type="file" @change="handleLogoChange" />
                <InputError class="mt-2" :message="form.errors.logo" />
            </a-form-item>
            <a-form-item :wrapper-col="{ span: 16 }">
                <a-button type="primary" html-type="submit">Submit</a-button>
            </a-form-item>
        </a-form>
    </AuthenticatedLayout>
</template>
