<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';

const visible = ref(false);

const props = defineProps({
    btnLabel : String,
    btnIcon  : String,
    parent   : Number
})

const departmentForm = useForm({
    name        : '',
    parent_id   : props.parent,
});

const createDepartment = () => {

    departmentForm.parent_id = props.parent;

    departmentForm.post(route('admin.department.create'), {
        onFinish: () => {
            departmentForm.name = '';
            visible.value = false;
        },
    });

};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Create Department" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Department name" v-model="departmentForm.name" class="text-gray-800"/>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="createDepartment" suffixIcon="add" label="Create" :class="{ 'opacity-75': departmentForm.processing }" :disabled="departmentForm.processing"/>
        </div>
    </Dialog>
</template>

<style  scoped>

</style>