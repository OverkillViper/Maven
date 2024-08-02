<script setup>
import { FwbToast } from 'flowbite-vue'
import { computed, watch } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';

// const toast = useToast();

// const hasError = computed(() => Object.keys($page.props.errors).length > 0);

const toast = useToast();
const $page = usePage();

watch(() => $page.props.errors, error => {
    toast.add({ severity: 'error', summary: 'Error', detail: error[Object.keys(error)], life: 3000 });
});

</script>

<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-secondary">
        <div class="grid grid-cols-2 w-full max-w-4xl bg-white shadow-md overflow-hidden rounded-xl border p-3">
            <slot />
        </div>
        <Toast position="bottom-right"></Toast>
        <!-- <div class="absolute right-0 bottom-0 p-8" v-if="hasError">
            <fwb-toast type="danger" class="shadow-md border border-red-400 font-medium mt-3" v-for="(error, field) in $page.props.errors" :key="field">
                {{ error }}
            </fwb-toast>
        </div> -->
        
    </div>

</template>