<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    name  : String,
    href  : String,
    icon  : String
})

</script>

<template>
    <Link :href="route(href) || '#'" v-tooltip="name">
        <span class="material-symbols-outlined">{{ icon }}</span>
    </Link>
</template>