<script setup>
import Avatar from '@/Components/MavenComponents/Avatar.vue';
import Notifications from '@/Pages/Common/Notifications.vue';
import { usePage, Link } from '@inertiajs/vue3';
import { FwbBreadcrumb, FwbBreadcrumbItem } from 'flowbite-vue';

defineProps({
    pageTitle  : String,
})

const $page = usePage();
const breadcrumb = $page.props.currentBreadcrumb;
// const breadcrumbAncestors = $page.props.currentBreadcrumb ? props.breadcrumb.ancestors : [];

</script>

<template>
    <div class="flex py-3 px-6 items-center">
        <div class="flex-grow ">
            <div class="font-bold text-lg">{{ breadcrumb.breadcrumb.name }}</div>
            <div class="text-sm">
                <fwb-breadcrumb>
                    <fwb-breadcrumb-item :home="ancestor.level == 0" v-for="ancestor in breadcrumb.ancestors" :key="ancestor.id">
                        <Link :href="route(ancestor.href)" class="hover:text-gray-800 transition">{{ ancestor.name }}</Link>
                        <template #arrow-icon v-if="ancestor.level != 0">
                            <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                            </svg>
                        </template>
                    </fwb-breadcrumb-item>
                    <fwb-breadcrumb-item :home="breadcrumb.ancestors.length == 0">
                        <template #arrow-icon v-if="breadcrumb.ancestors.length != 0">
                            <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                            </svg>
                        </template>
                        <div class="hover:text-gray-800 transition cursor-pointer">{{ breadcrumb.breadcrumb.name }}</div>
                    </fwb-breadcrumb-item>
                </fwb-breadcrumb>
            </div>
        </div>
        
        <Notifications />
        <Avatar :img="$page.props.auth.user.employee.avatar" class="ms-4" href="admin.profile"/>
    </div>
</template>