<script setup>

const model = defineModel({
    type: String,
    required: true,
});

defineProps({
    placeholder : { type: String },
    type        : { type: String },
    label       : { type: String },
});

</script>
<template>
    <div>
        <div class="text-sm font-medium text-gray-500 uppercase">
            {{ label }}
        </div>
        <input v-model="model" :placeholder="placeholder" :type="type" class="w-full font-semibold text-lg px-0 py-1 ring-0 focus:ring-0 border border-t-0 border-l-0 border-r-0 border-gray-200 hover:border-primary focus:border-primary focus:border-b-2 transition">
    </div>
</template>