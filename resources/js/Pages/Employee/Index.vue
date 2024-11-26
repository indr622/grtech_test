<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({});
const { props } = usePage();
const companies = props.companies;
const employee = ref(props.employee.data);
const editEmployee = useForm({
    company_id: '',
    first_name: '',
    last_name: '',
    email: '',
    phone: '',
});
const isModalVisible = ref(false);
const pagination = ref({
    current: props.employee.current_page,
    pageSize: props.employee.per_page,
    total: props.employee.total,
});
const handleTableChange = (pagination) => {
    const { current, pageSize } = pagination;
    pagination.current = current;
    pagination.pageSize = pageSize;
    form.get(route('employees.index'), {
        page: current,
        per_page: pageSize,
        preserveState: true,
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
        title: 'Fist Name',
        dataIndex: 'first_name',
        key: 'first_name',
    },
    {
        title: 'Last Name',
        dataIndex: 'last_name',
        key: 'last_name',
    },
    {
        title: 'Company',
        key: 'company',
        slots: { customRender: 'company' },

    },

    {
        title: 'Email',
        dataIndex: 'email',
        key: 'email',
    },
    {
        title: 'Phone',
        dataIndex: 'phone',
        key: 'phone',
    },
    {
        title: 'Action',
        key: 'action',
        slots: { customRender: 'action' },
    },
];

const handleDelete = (id) => {
    form.delete(route('employees.destroy', id), {
        onSuccess: () => {
            form.get(route('employees.index'));
        }
    });
};

const showEditModal = (employee) => {
    editEmployee.id = employee.id;
    editEmployee.company_id = employee.company_id;
    editEmployee.first_name = employee.first_name;
    editEmployee.last_name = employee.last_name;
    editEmployee.email = employee.email;
    editEmployee.phone = employee.phone;
    isModalVisible.value = true;
};

const updateSubmit = () => {
    editEmployee.put(route('employees.update', editEmployee.id), {
        onSuccess: () => {
            isModalVisible.value = false;
            form.get(route('employees.index'));
        }
    });

};
</script>

<template>

    <Head title="Employee" />

    <AuthenticatedLayout>
        <div>
            <a-button type="primary" @click="() => form.get(route('employees.create'))" style=" margin-bottom: 16px;">
                Add Employee
            </a-button>

            <a-table :dataSource="employee" :columns="columns" :pagination="pagination" @change="handleTableChange"
                rowKey="id" bordered :scroll="{ x: 1500, y: 600 }">
                <template #no="{ index }">
                    {{ index + 1 }}
                </template>
                <template #company="{ record }">
                    {{ record.company?.name || 'N/A' }}
                </template>

                <template #action="{ record }">
                    <a-space>
                        <a-button type="link" @click="showEditModal(record)">Edit</a-button>
                        <a-popconfirm title="Are you sure to delete this employee?" okText="Yes" cancelText="No"
                            @confirm="() => handleDelete(record.id)">
                            <a-button type="link" danger>Delete</a-button>
                        </a-popconfirm>
                    </a-space>
                </template>

            </a-table>
            <a-modal :open="isModalVisible" title="Edit Employee" okText="Update" @ok="updateSubmit()"
                @cancel="isModalVisible = false">
                <a-form layout="vertical" @submit.prevent="updateSubmit">
                    <a-form-item label="Company" name="company_id">
                        <a-select v-model:value="editEmployee.company_id" placeholder="Select Company">
                            <a-select-option v-for="company in companies" :key="company.id" :value="company.id">
                                {{ company.name }}
                            </a-select-option>
                        </a-select>
                        <InputError class="mt-2" :message="editEmployee.errors.company_id" />
                    </a-form-item>
                    <a-form-item label="First Name" name="first_name">
                        <a-input v-model:value="editEmployee.first_name" placeholder="First Name" />
                        <InputError class="mt-2" :message="editEmployee.errors.first_name" />
                    </a-form-item>

                    <a-form-item label="Last Name" name="last_name">
                        <a-input v-model:value="editEmployee.last_name" placeholder="Last Name" />
                        <InputError class="mt-2" :message="editEmployee.errors.last_name" />
                    </a-form-item>

                    <a-form-item label="Email" name="email">
                        <a-input v-model:value="editEmployee.email" placeholder="Email" />
                        <InputError class="mt-2" :message="editEmployee.errors.email" />
                    </a-form-item>

                    <a-form-item label="Phone" name="phone">
                        <a-input v-model:value="editEmployee.phone" placeholder="Phone" />
                        <InputError class="mt-2" :message="editEmployee.errors.phone" />
                    </a-form-item>


                </a-form>
            </a-modal>

        </div>
    </AuthenticatedLayout>
</template>
