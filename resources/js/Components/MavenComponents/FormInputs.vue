<script setup>
import { ref, computed } from 'vue';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import InputNumber from 'primevue/inputnumber';


const model = defineModel({
    type: [Number, String],
    required: false,
});

const props = defineProps({
    placeholder : { type: String  },
    icon        : { type: String  },
    error       : { type: String  },
    type        : { type: String  },
    disabled    : { type: Boolean },
    label       : { type: String  },
    prefixLabel : { type: String  },
});

// const input             = ref(null);
const isPasswordVisible = ref(props.type === 'text');

const togglePassword = () => {
    isPasswordVisible.value = !isPasswordVisible.value;
};

</script>

<template>

    <div>
        <div class="ms-1 text-sm font-medium text-gray-500 mb-1" v-if="label">
            {{ label }}
        </div>
        <InputGroup>
            <InputGroupAddon v-if="icon">
                <span class="material-symbols-outlined text-sm">{{ icon }}</span>
            </InputGroupAddon>
            <Password  v-model="model" :placeholder="placeholder" variant="filled" size="small" v-if="type == 'password'" :feedback="false" toggleMask />
            <InputNumber v-model="model" :placeholder="placeholder" locale="en-IN" fluid v-else-if="type == 'number'" size="small" variant="filled"/>
            <InputText :disabled="disabled" v-model="model" :placeholder="placeholder" variant="filled" size="small" :type="type" v-else/>
            <InputGroupAddon v-if="prefixLabel" class="text-sm font-semibold">{{ prefixLabel }}</InputGroupAddon>
        </InputGroup>
    </div>
    

    <!-- <div>
        <div class="ms-1 text-sm font-medium text-gray-500 mb-2" v-if="label">
            {{ label }}
        </div>
        <div class="flex items-center">
            <span class="material-symbols-outlined me-4" v-if="icon">{{ icon }}</span>
            <input :disabled="disabled" :class="{'cursor-not-allowed':disabled}" v-model="model" :type="inputType" :placeholder="placeholder" class="w-full font-medium text-sm ring-0 border border-white focus:ring-0 transition bg-gray-100 py-2 px-4 rounded-md focus:shadow-md focus:border focus:border-primary">
            <span class="material-symbols-outlined ms-4 select-none cursor-default" v-if="type == 'password'" @click="togglePassword">{{ iconName }}</span>
        </div>
    </div> -->
    
</template>