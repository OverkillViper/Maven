<script setup>
import SidebarMenuItem from '@/Components/MavenComponents/SidebarMenuItem.vue';
import SidebarGroupLabel from '@/Components/MavenComponents/SidebarGroupLabel.vue';
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="flex flex-col p-5">
        <div class="flex items-center">
            <div class="rounded-lg p-1 overflow-hidden bg-primary">
                <img :src="'/images/logo_1.png'" alt="logo" class="w-6 aspect-square">
            </div>
            
            <div class="ms-3 uppercase font-semibold flex-grow">Maven</div>

            <Link :href="route('logout')" method="post" as="button" label="Sign out" class="flex justify-center items-center border border-primary hover:bg-primary hover:text-white transition text-primary text-sm w-8 p-1 aspect-square rounded-md">
                <span class="material-symbols-outlined text-sm">power_settings_new</span>
            </Link>
        </div>

        <div class="flex flex-col flex-grow">
            <SidebarMenuItem :href="route('admin.dashboard')" label="Dashboard" icon="dashboard" class="mt-6"/>

            <SidebarGroupLabel label="Management" />

            <SidebarMenuItem :href="route('admin.departments')" label="Departments" icon="grid_view"/>
            <SidebarMenuItem :href="route('admin.designations')" label="Designations" icon="badge"/>

            <SidebarGroupLabel label="Communciation" />

            <SidebarMenuItem href="#" label="Direct Messages" icon="chat_bubble"/>
            <SidebarMenuItem href="#" label="Spaces" icon="forum"/>

            <SidebarGroupLabel label="Site management" />

            <SidebarMenuItem :href="route('admin.structure')" label="Structure" icon="account_tree"/>
        </div>
    </div>
</template>