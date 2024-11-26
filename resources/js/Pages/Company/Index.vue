<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const baseUrl = import.meta.env.VITE_APP_URL;

const form = useForm({});
const { props } = usePage();
const companies = ref(props.companies.data);
const editCompany = useForm({
    id: '',
    name: '',
    email: '',
    website: '',
    logo: '',
});
const isModalVisible = ref(false);

const pagination = ref({
    current: props.companies.current_page,
    pageSize: props.companies.per_page,
    total: props.companies.total,
});
const handleTableChange = (pagination) => {
    const { current, pageSize } = pagination;

    pagination.current = current;
    pagination.pageSize = pageSize;
    form.get(route('companies.index'), {
        page: current,  // Halaman yang dipilih
        per_page: pageSize,  // Jumlah item per halaman
        preserveState: true,  // Mempertahankan state agar pagination tetap terjaga
    });
};

const columns = [
    {
        title: 'No',
        dataIndex: 'no',
        key: 'no',
        slots: { customRender: 'no' },

    },
    {
        title: 'Logo',
        dataIndex: 'logo',
        key: 'logo',
        slots: { customRender: 'logo' },
    },
    {
        title: 'Name',
        dataIndex: 'name',
        key: 'name',
    },
    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },

    {
        title: 'Website',
        dataIndex: 'website',
        key: 'website',
        slots: { customRender: 'website' },
    },
    {
        title: 'Action',
        key: 'action',
        slots: { customRender: 'action' },
    },
];

const showEditModal = (company) => {
    editCompany.id = company.id;
    editCompany.name = company.name;
    editCompany.email = company.email;
    editCompany.website = company.website;
    isModalVisible.value = true;
};

const handleDelete = (id) => {
    form.delete(route('companies.destroy', id), {
        onSuccess: () => {
            form.get(route('companies.index'));
        }
    });
};

const updateSubmit = () => {
    editCompany.put(route('companies.update', editCompany.id), {
        onSuccess: () => {
            isModalVisible.value = false;
            form.get(route('companies.index'));
        }
    });
};

</script>

<template>

    <Head title="Company" />

    <AuthenticatedLayout>
        <div>
            <a-button type="primary" @click="() =>  form.get(route('companies.create'))" style=" margin-bottom: 16px;">
                Add Company
            </a-button>

            <a-table :dataSource="companies" :columns="columns" :pagination="pagination" @change="handleTableChange"
                rowKey="id" bordered :scroll="{ x: 1500, y: 600 }">
                <template #no="{ index }">
                    {{ index + 1 }}
                </template>
                <template #website="{ text }">
                    <a :href="text" target="_blank" rel="noopener noreferrer">{{ text }}</a>
                </template>
                <template #logo="{ text }">
                    <img :src="`/storage/${text}`" alt="Logo" width="100" />
                </template>

                <template #action="{ record }">
                    <a-space>
                        <a-button type="link" @click="showEditModal(record)">Edit</a-button>
                        <a-popconfirm title="Are you sure to delete this company?" okText="Yes" cancelText="No"
                            @confirm="() => handleDelete(record.id)">
                            <a-button type="link" danger>Delete</a-button>
                        </a-popconfirm>
                    </a-space>
                </template>

            </a-table>

            <a-modal :open="isModalVisible" title="Edit Company" @cancel="isModalVisible = false" @ok="updateSubmit"
                okText="Update">
                <a-form layout="vertical">
                    <a-form-item label=" Name" name="name" :wrapper-col="{ span: 22 }">
                        <a-input v-model:value="editCompany.name" placeholder="Name" />
                        <InputError class="mt-2" :message="editCompany.errors.name" />
                    </a-form-item>
                    <a-form-item label="Email" name="email" :wrapper-col="{ span: 22 }">
                        <a-input v-model:value="editCompany.email" placeholder="Email" />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </a-form-item>
                    <a-form-item label="Website" name="website" :wrapper-col="{ span: 22 }">
                        <a-input v-model:value="editCompany.website" placeholder="Website" />
                        <InputError class="mt-2" :message="form.errors.website" />
                    </a-form-item>
                </a-form>
            </a-modal>
        </div>
    </AuthenticatedLayout>
</template>
