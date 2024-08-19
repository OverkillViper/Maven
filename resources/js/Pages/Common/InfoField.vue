<script setup>

const props = defineProps({
    label : String,
    value : [String, Number],
})

</script>

<template>
    <div>
        <div class="text-gray-500 text-sm font-medium">{{ props.label }}</div>
        <div class="font-semibold">{{ props.value || 'None' }}</div>
    </div>
</template>