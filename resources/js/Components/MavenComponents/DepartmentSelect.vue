<script setup>
const model = defineModel({
    type     : String,
    required : true,
});

const props = defineProps({
    departments : { type: Array  },
    icon        : { type: String  },
    disabled    : { type: Boolean },
    label       : { type: String  },
});

</script>

<template>
    
    <div class="w-full">
        <div class="ms-1 text-sm font-medium text-gray-500 mb-2" v-if="label">
            {{ label }}
        </div>
        <div class="flex items-center">
            <span class="material-symbols-outlined me-4" v-if="icon">{{ icon }}</span>
            <div class="w-full bg-gray-100 font-medium text-sm rounded-md py-2 px-4 select-none flex justify-between">
                <div>
                    <input type="hidden" v-model="model">
                </div>
                <span class="material-symbols-outlined text-gray-500">
                    keyboard_arrow_down
                </span>
            </div>
        </div>
        <div class="relative">
            <div class="p-2 bg-gray-100 mt-2 z-10 absolute w-full shadow-md rounded-md">
                <div v-for="department in departments" :key="department.id">
                    {{ department }}
                </div>
            </div>
        </div>
        
    </div>
</template>