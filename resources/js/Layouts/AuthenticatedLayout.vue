<template>
    <a-layout style="height: 100vh;">
        <a-layout-sider v-model:collapsed="collapsed" :trigger="null" collapsible>
            <div style="margin-top: 50px;" />
            <a-menu v-model:selectedKeys="activeMenu" theme="dark" mode="inline">
                <a-menu-item key="dashboard" @click="navigate(route('dashboard'))">
                    <home-outlined />
                    <span>Dashboard</span>
                </a-menu-item>
                <a-menu-item key="companies" @click="navigate(route('companies.index'))">
                    <build-outlined />
                    <span>Company</span>
                </a-menu-item>
                <a-menu-item key="employee" @click="navigate(route('employees.index'))">
                    <user-outlined />
                    <span>Employee</span>
                </a-menu-item>
            </a-menu>
        </a-layout-sider>
        <a-layout>
            <a-layout-header
                style="background: #fff; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <menu-unfold-outlined v-if="collapsed" class="trigger" @click="() => (collapsed = !collapsed)" />
                    <menu-fold-outlined v-else class="trigger" @click="() => (collapsed = !collapsed)" />
                </div>

                <div style="margin-right: 24px;">
                    <a-dropdown>
                        <template #overlay>
                            <a-menu>

                                <a-menu-item key="logout" @click="handleLogout">
                                    <DropdownLink :href="route('logout')" method="post">
                                        Logout
                                    </DropdownLink>
                                </a-menu-item>
                            </a-menu>
                        </template>
                        <a class="ant-dropdown-link" @click.prevent>
                            <user-outlined style="font-size: 18px;" />
                            <span style="margin-left: 8px;"> {{ $page.props.auth.user.name }}</span>
                        </a>
                    </a-dropdown>
                </div>
            </a-layout-header>
            <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff', minHeight: '280px' }">
                <slot />
            </a-layout-content>
        </a-layout>
    </a-layout>
</template>
<script setup>
import DropdownLink from '@/Components/DropdownLink.vue';
import { ref, computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import {
    UserOutlined,
    HomeOutlined,
    MenuUnfoldOutlined,
    MenuFoldOutlined,
    BuildOutlined,
    PoweroffOutlined,
} from '@ant-design/icons-vue';
const page = usePage();


const activeMenu = computed(() => {
    return page.props.ziggy?.location?.name;
});
const collapsed = ref(false);
const navigate = (route) => {
    router.visit(route);
};

const handleLogout = () => {

}
</script>
