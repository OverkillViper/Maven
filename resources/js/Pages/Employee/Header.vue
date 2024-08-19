<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import Notifications from '@/Pages/Common/Notifications.vue';
import Avatar from '@/Components/MavenComponents/Avatar.vue';
import { FwbBreadcrumb, FwbBreadcrumbItem } from 'flowbite-vue';

defineProps({
    pageTitle : String
})

const $page = usePage();
const breadcrumbs       = $page.props.breadcrumbs;
const currentBreadcrumb = $page.props.currentBreadcrumb;

const home = ref({
    icon: 'dashboard'
});

</script>

<template>
    <Head :title="currentBreadcrumb.breadcrumb.name" />
    <div class="flex p-4 items-center">
        <div class="flex-grow font-semibold text-lg">
            <div>
                {{ currentBreadcrumb.breadcrumb.name }}
            </div>
            
            <fwb-breadcrumb>
                <fwb-breadcrumb-item :home="ancestor.level == 0" v-for="ancestor in currentBreadcrumb.ancestors" :key="ancestor.id">
                    <Link :href="route(ancestor.href)" class="hover:text-gray-800 transition">{{ ancestor.name }}</Link>
                    <template #arrow-icon v-if="ancestor.level != 0">
                    <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                    </svg>
                </template>
                </fwb-breadcrumb-item>
                <fwb-breadcrumb-item :home="currentBreadcrumb.ancestors.length == 0">
                    <template #arrow-icon v-if="currentBreadcrumb.ancestors.length != 0">
                        <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                        </svg>
                    </template>
                    <div class="hover:text-gray-800 transition cursor-pointer">{{ currentBreadcrumb.breadcrumb.name }}</div>
                </fwb-breadcrumb-item>
            </fwb-breadcrumb>

            <!-- <fwb-breadcrumb-item :home="ancestor.level == 0" v-for="ancestor in currentBreadcrumb.ancestors" :key="ancestor.id">
                <Link :href="route(ancestor.href)" class="hover:text-gray-800 transition">{{ ancestor.name }}</Link>
                <template #arrow-icon v-if="ancestor.level != 0">
                    <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                    </svg>
                </template>
            </fwb-breadcrumb-item>
            <fwb-breadcrumb-item :home="currentBreadcrumb.ancestors.length == 0">
                <template #arrow-icon v-if="currentBreadcrumb.ancestors.length != 0">
                    <svg class="w-4 h-4 text-gray-400 -ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10 16 4-4-4-4"/>
                    </svg>
                </template>
                <div class="hover:text-gray-800 transition cursor-pointer">{{ currentBreadcrumb.breadcrumb.name }}</div>
            </fwb-breadcrumb-item> -->
        </div>
        <FormInputs class="w-72" placeholder="Search"/>
        <Button class="ms-2" prefixIcon="search"/>
        <Notifications class="ms-2"/>

        <Avatar :img="$page.props.auth.user.employee.avatar" class="ms-4" href="employee.profile"/>
    </div>
</template>