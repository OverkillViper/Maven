<script setup>
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const editing = ref(false);

const props = defineProps({
    leaveType : Object
})

const typeForm = useForm({
    name : props.leaveType.name,
})

const toggleEdit = () => editing.value = !editing.value;

const updateLeaveType = () => {
    typeForm.post(route('admin.leaves.types.update', props.leaveType.id));
    editing.value = false;
};

const deleteLeaveType = () => {
    typeForm.post(route('admin.leaves.types.delete', props.leaveType.id));
};

</script>

<template>

    <div class="border rounded-md px-4 py-2">
        <form @submit.prevent class="flex items-center gap-x-4" v-if="editing">
            <FormInputs v-model="typeForm.name" placeholder="Type name" class="flex-grow"/>
            <Button prefixIcon="close" @click="toggleEdit"/>
            <Button prefixIcon="check" @click="updateLeaveType"/>
        </form>
        <div class="flex items-center gap-x-4" v-else>
            <div class="font-semibold flex-grow ms-2">{{ props.leaveType.name }}</div>
            <Button prefixIcon="delete" @click="deleteLeaveType"/>
            <Button prefixIcon="edit" @click="toggleEdit"/>
        </div>
        
    </div>

</template>