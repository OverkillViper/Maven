<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import Dialog from 'primevue/dialog';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';

const visible = ref(false);

const props = defineProps({
    btnLabel    : String,
    btnIcon     : String,
    designation  : Object
})

const designationForm = useForm({
    title : props.designation.title,
});

const updateDesignation = () => {
    designationForm.put(route('admin.designation.update', props.designation.id), {
        onFinish: () => {
            designationForm.reset();
            visible.value = false;
        },
    });

};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Modify Designation" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Designation title" v-model="designationForm.title" class="text-gray-800"/>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="updateDesignation" suffixIcon="save" label="Save" :class="{ 'opacity-75': designationForm.processing }" :disabled="designationForm.processing"/>
        </div>
    </Dialog>

    <!-- <fwb-modal v-if="visible" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg font-semibold capitalize">
                Edit designation title
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
                <Button compact @click="updateDesignation" suffixIcon="save" label="Update" :class="{ 'opacity-75': designationForm.processing }" :disabled="designationForm.processing"/>
            </div>
        </template>
    </fwb-modal> -->
</template>