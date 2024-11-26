<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head } from '@inertiajs/vue3';
import { useForm, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const companies = props.companies;
const form = useForm({
    company_id: '',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
});
const submit = () => {
    form.post(route('employees.store'));
};
</script>

<template>

    <Head title="Create Employee" />

    <AuthenticatedLayout>
        <a-form layout="vertical" @submit.prevent="submit">
            <a-form-item label="Company" name="company_id" :wrapper-col="{ span: 10 }">
                <a-select v-model:value="form.company_id" placeholder="Select Company">
                    <a-select-option v-for="company in companies" :key="company.id" :value="company.id">
                        {{ company.name }}
                    </a-select-option>
                </a-select>
                <InputError class="mt-2" :message="form.errors.company_id" />
            </a-form-item>
            <a-form-item label="First Name" name="first_name" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.first_name" placeholder="First Name" />
                <InputError class="mt-2" :message="form.errors.first_name" />
            </a-form-item>

            <a-form-item label="Last Name" name="last_name" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.last_name" placeholder="Last Name" />
                <InputError class="mt-2" :message="form.errors.last_name" />
            </a-form-item>

            <a-form-item label="Email" name="email" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.email" placeholder="Email" />
                <InputError class="mt-2" :message="form.errors.email" />
            </a-form-item>

            <a-form-item label="Phone" name="phone" :wrapper-col="{ span: 10 }">
                <a-input v-model:value="form.phone" placeholder="Phone" />
                <InputError class="mt-2" :message="form.errors.phone" />
            </a-form-item>

            <a-form-item :wrapper-col="{ span: 16 }">
                <a-button type="primary" html-type="submit">Submit</a-button>
            </a-form-item>
        </a-form>
    </AuthenticatedLayout>
</template>
