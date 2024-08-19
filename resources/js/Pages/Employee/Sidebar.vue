<script setup>
import { Link } from '@inertiajs/vue3';
import EmployeeSidebarItem from '@/Components/MavenComponents/EmployeeSidebarItem.vue';

defineProps({
    breadcrumbs : Object
})

</script>

<template>
    
    <div class="flex flex-col p-4 items-center">
        <Link href="/" class="ms-1 rounded-lg p-1 overflow-hidden bg-white border border-primary">
            <img :src="'/images/logo_3.png'" alt="logo" class="w-8 aspect-square">
        </Link>
        <div class="flex flex-col items-center gap-y-6 mt-10">
            <EmployeeSidebarItem v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id" :name="breadcrumb.name" :icon="breadcrumb.icon" :href="breadcrumb.href"/>
        </div>
        <Link :href="route('logout')" method="post" as="button" label="Sign out" class="mt-10 flex justify-center items-center border border-primary hover:bg-primary hover:text-white transition text-primary text-sm w-8 p-1 aspect-square rounded-md">
            <span class="material-symbols-outlined text-sm">power_settings_new</span>
        </Link>
    </div>
</template>