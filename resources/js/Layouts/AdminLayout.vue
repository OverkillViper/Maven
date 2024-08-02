<script setup>
import Sidebar from '@/Pages/Admin/Sidebar.vue';
import { FwbToast } from 'flowbite-vue'
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import Header from '@/Pages/Admin/Header.vue';

defineProps({
    pageTitle : String
})

const $page = usePage();
const hasError = computed(() => Object.keys($page.props.errors).length > 0);

</script>

<template>
    <div class="min-h-screen bg-accent flex">

        <Sidebar class="basis-1/6"/>
        <div class="basis-5/6 p-3 ps-0">
            <div class="rounded-lg shadow-sm border bg-white w-full h-full">
                <Head :title="pageTitle" />
                <Header :pageTitle="pageTitle" />
                <hr>
                

                <div class="p-4">
                    <slot />
                </div>
            </div>
            
        </div>
        <div class="absolute right-0 bottom-0 p-8" v-if="hasError">
            <fwb-toast type="danger" class="shadow-md border border-red-400 font-medium mt-3" v-for="(error, field) in $page.props.errors" :key="field">
                {{ error }}
            </fwb-toast>
        </div>
    </div>
</template>