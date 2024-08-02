<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';

const visible = ref(false);

const props = defineProps({
    btnLabel    : String,
    btnIcon     : String,
    department  : Object
})

const departmentForm = useForm({
    name        : props.department.name,
});

const updateDepartment = () => {
    departmentForm.put(route('admin.department.update', props.department.id), {
        onFinish: () => {
            departmentForm.reset();
            visible.value = false;
        },
    });

};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Modify Department" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Department name" v-model="departmentForm.name" class="text-gray-800"/>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="updateDepartment" suffixIcon="save" label="Save" :class="{ 'opacity-75': departmentForm.processing }" :disabled="departmentForm.processing"/>
        </div>
    </Dialog>
</template>