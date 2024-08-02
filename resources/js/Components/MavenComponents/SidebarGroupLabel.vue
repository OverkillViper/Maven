<script setup>

defineProps({
    label   : String,
});
</script>
<template>
    <div class="uppercase font-semibold text-xs text-gray-500 my-2">{{ label }}</div>
</template>