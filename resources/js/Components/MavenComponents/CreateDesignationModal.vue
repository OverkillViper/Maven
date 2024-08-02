<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import Dialog from 'primevue/dialog';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';

const visible = ref(false);

const props = defineProps({
    btnLabel : String,
    btnIcon  : String
})

const designationForm = useForm({
    'title'    : ''
})

const createDesignation = () => {
    designationForm.post(route('admin.designation.create'), {
        onFinish: () => {
            designationForm.reset('title');
            visible.value = false;
        },
    });
};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Create Designation" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Designation title" v-model="designationForm.title" class="text-gray-800"/>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="createDesignation" suffixIcon="add" label="Create" :class="{ 'opacity-75': designationForm.processing }" :disabled="designationForm.processing"/>
        </div>
    </Dialog>

    <!-- <fwb-modal v-if="visible" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg font-semibold">
                Create Designation
            </div>
        </template>
        <template #body>
            <form @submit.prevent>
                <FormInputs type="text" placeholder="Designation title" v-model="designationForm.title" class="text-gray-800"/>
            </form>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <Button compact @click="closeModal" prefixIcon="close" label="Cancel" />
                <Button compact @click="createDesignation" suffixIcon="add" label="Create" :class="{ 'opacity-75': designationForm.processing }" :disabled="designationForm.processing"/>
            </div>
        </template>
    </fwb-modal> -->
</template>