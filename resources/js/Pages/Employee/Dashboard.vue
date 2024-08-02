<script setup>
import DropdownLink from '@/Components/DropdownLink.vue';
</script>

<template>
    Employee Dashboard

    <DropdownLink :href="route('logout')" method="post" as="button">
        Log Out
    </DropdownLink>
</template>