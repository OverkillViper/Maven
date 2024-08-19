<script setup>
import AdminSidebarMenuItem from '@/Components/MavenComponents/AdminSidebarMenuItem.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    breadcrumbs : Object
})

</script>

<template>
    <div class="flex flex-col p-5">
        <div class="flex items-center">
            <Link href="/" class="rounded-lg p-1 overflow-hidden bg-primary">
                <img :src="'/images/logo_1.png'" alt="logo" class="w-6 aspect-square">
            </Link>
            
            <div class="ms-3 uppercase font-semibold flex-grow select-none">Maven</div>

            <Link :href="route('logout')" method="post" as="button" label="Sign out" class="flex justify-center items-center border border-primary hover:bg-primary hover:text-white transition text-primary text-sm w-8 p-1 aspect-square rounded-md">
                <span class="material-symbols-outlined text-sm">power_settings_new</span>
            </Link>
        </div>

        <div class="flex flex-col flex-grow mt-6 gap-y-2">
            <AdminSidebarMenuItem v-for="breadcrumb in breadcrumbs" :key="breadcrumb.id" :href="route(breadcrumb.href)" :label="breadcrumb.name" :icon="breadcrumb.icon"/>
        </div>
    </div>
</template>