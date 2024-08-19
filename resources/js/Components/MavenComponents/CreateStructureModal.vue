<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import ToggleSwitch from 'primevue/toggleswitch';

const visible = ref(false);

const props = defineProps({
    btnLabel : String,
    btnIcon  : String,
    parent   : Number
})

const structureForm = useForm({
    parent_id   : props.parent,
    name        : '',
    href        : '',
    icon        : '',
    for_admin   : true
});

const createStructure = () => {
    structureForm.parent_id = props.parent;

    structureForm.post(route('admin.structure.create'), {
        onFinish: () => {
            structureForm.reset();
            visible.value = false;
        },
    });
};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Create Page" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Page Title" v-model="structureForm.name" class="text-gray-800 my-4"/>
            <FormInputs type="text" placeholder="Page Route" v-model="structureForm.href" class="text-gray-800 my-4"/>
            <FormInputs type="text" placeholder="Page Icon"  v-model="structureForm.icon" class="text-gray-800 my-4"/>
            <div class="flex items-center justify-between">
                <div class="text-sm font-semibold">For Admin Pages</div>
                <ToggleSwitch v-model="structureForm.for_admin" />
            </div>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="createStructure" suffixIcon="add" label="Create" :class="{ 'opacity-75': structureForm.processing }" :disabled="structureForm.processing"/>
        </div>
    </Dialog>
</template>