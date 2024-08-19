<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import LeaveTypeItem from '@/Components/MavenComponents/LeaveTypeItem.vue';
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import EmployeeCard from '@/Components/MavenComponents/EmployeeCard.vue';

const leaveTypeForm = useForm({
    name : '',
});

const props = defineProps({
    leaveTypes : Array
});

const createLeaveType = () => {
    leaveTypeForm.post(route('admin.leaves.types.create'), {
        onFinish: () => {
            leaveTypeForm.name = '';
        },
    });
};

</script>

<template>
    <AdminLayout pageTitle="Leave Types">

        <div class="mx-3 flex flex-col items-center">
            <form @submit.prevent="createLeaveType" class="flex items-center gap-x-4 self-start">
                <FormInputs type="text" placeholder="Type name" v-model="leaveTypeForm.name"/>
                <Button type="submit" label="Create" prefixIcon="add"/>
            </form>
            <div class="mt-6  border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="props.leaveTypes.length == 0">
                <span class="material-symbols-outlined me-4">warning</span>
                <div class="me-8">
                    No records of leave type found
                </div>
            </div>
            <div class="w-1/3 mx-auto mt-6" v-else>
                <LeaveTypeItem v-for="leaveType in props.leaveTypes" :key="leaveType.id" :leaveType="leaveType" class="my-3"/>
            </div>
            
        </div>

    </AdminLayout>
</template>