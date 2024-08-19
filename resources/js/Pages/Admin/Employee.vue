<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import EmployeeCard from '@/Components/MavenComponents/EmployeeCard.vue';

import { useForm } from '@inertiajs/vue3';

const employeeSearchForm = useForm({
    query : '',
})

const props = defineProps({
    users : Array
})

const searchEmployee = () => {
    employeeSearchForm.post(route('admin.employee'), {
        onFinish: () => {
            employeeSearchForm.query = '';
        },
    });
};

</script>

<template>
<AdminLayout pageTitle="Employees">
    <form @submit.prevent="searchEmployee" class="w-1/3 mx-auto flex gap-x-4">
        <FormInputs placeholder="Search Employee" v-model="employeeSearchForm.query" class="w-full"/>
        <Button prefixIcon="search"/>
    </form>

    <div class="w-2/3 mx-auto mt-10 grid grid-cols-4">
        <EmployeeCard  v-for="user in props.users" :key="user.id" :user="user" link="admin.employee.details"/>
    </div>

</AdminLayout>
</template>