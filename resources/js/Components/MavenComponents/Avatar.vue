<script setup>
import { FwbAvatar } from 'flowbite-vue'
import { Link } from '@inertiajs/vue3';

defineProps({
    img : String,
    href : String
});

const getImageUrl = (imagePath) => {
  return `/storage/${imagePath}`;
};

</script>

<template>
    <Link :href="href ? route(href) : '#'" class="border rounded-full shadow-sm">
        <fwb-avatar :img="getImageUrl(img)" rounded v-if="img"/>
        <fwb-avatar rounded v-else/>
    </Link>
</template>