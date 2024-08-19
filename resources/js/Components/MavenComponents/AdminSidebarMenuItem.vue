<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    icon    : String,
    label   : String,
    href    : String,
});

</script>

<template>
    <Link :href="href" class="flex p-2 items-center border text-gray-500 hover:bg-white hover:shadow-sm transition ease-in border-transparent hover:border-gray-200 rounded-md hover:text-gray-800">
        <span class="material-symbols-outlined" style="font-size: large;">{{ icon }}</span>
        <div class="ms-3 text-sm font-semibold">{{ label }}</div>
    </Link>
</template>