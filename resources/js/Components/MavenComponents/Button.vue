<script setup>

const props = defineProps({
    label       : { type: String },
    prefixIcon  : { type: String },
    suffixIcon  : { type: String },
    type        : { type: String },
    lightTheme  : { type: Boolean },
    compact     : { type: Boolean },
    // href        : { type: String },
});

</script>

<template>
    <button :type="type" class="flex item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition"  :class="[lightTheme ? 'bg-white text-primary border' : 'bg-primary text-white', compact ? 'px-2 py-1' : 'px-4 py-2', {'gap-x-2':label} ]">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-sm" v-if="prefixIcon">{{ prefixIcon }}</span>
        </div>
        <div class="flex items-center" :class="compact ? 'text-xs' : 'text-sm'" v-if="label">{{ label }}</div>
        <div class="flex items-center">
            <span class="material-symbols-outlined text-sm" v-if="suffixIcon">{{ suffixIcon }}</span>
        </div>
    </button>
</template>