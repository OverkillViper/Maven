<script setup>
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import Header from '@/Pages/Employee/Header.vue';
import Sidebar from '@/Pages/Employee/Sidebar.vue';
import { useToast } from 'primevue/usetoast';

const toast = useToast();
const $page = usePage();

watch(() => $page.props.flash, flash => {
    if(flash.message) {
        toast.add({ severity: flash.status, summary: flash.status, detail: flash.message, life: 3000 });
    }
});

watch(() => $page.props.errors, errors => {
    if (errors) {
        Object.keys(errors).forEach(key => {
            toast.add({
                severity: 'error',
                summary: 'Error',
                detail: errors[key],
                life: 3000
            });
        });
    }
});

const breadcrumbs = $page.props.breadcrumbs;

</script>

<template>

    <div class="min-h-screen bg-secondary flex">
        <Sidebar class="w-20" :breadcrumbs="breadcrumbs"/>
        <div class="w-full ms-4">
            <Header/>
            
            <div class="bg-white rounded-lg shadow-sm shadow-gray-300 mx-4 p-6 mb-4">
                <slot />
            </div>
        </div>
        <Toast position="bottom-right"></Toast>
    </div>

</template>