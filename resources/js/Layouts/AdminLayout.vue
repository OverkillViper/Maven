<script setup>
import Sidebar from '@/Pages/Admin/Sidebar.vue';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import Header from '@/Pages/Admin/Header.vue';
import { useToast } from 'primevue/usetoast';

defineProps({
    pageTitle : String
})

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
    <div class="min-h-screen bg-accent flex">
        <Sidebar class="basis-1/6" :breadcrumbs="breadcrumbs"/>
        <div class="basis-5/6 p-3 ps-0">
            <div class="rounded-lg shadow-sm border bg-white w-full h-full">
                <Head :title="pageTitle" />
                <Header :pageTitle="pageTitle"/>
                <hr>
                

                <div class="p-4">
                    <slot />
                </div>
            </div>
            
        </div>
        <Toast position="bottom-right"></Toast>
    </div>
</template>