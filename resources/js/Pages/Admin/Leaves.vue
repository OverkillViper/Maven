<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import EmployeeCard from '@/Components/MavenComponents/EmployeeCard.vue';

const employeeSearchForm = useForm({
    query : '',
});

const props = defineProps({
    users : Array
});

const searchEmployee = () => {
    employeeSearchForm.post(route('admin.leaves'), {
        onFinish: () => {
            employeeSearchForm.query = '';
        },
    });
};

</script>

<template>
    <AdminLayout pageTitle="Leave Management">

        <div class="flex justify-between">
            <form @submit.prevent="searchEmployee" class="w-1/3 flex gap-x-4">
                <FormInputs placeholder="Search Employee" v-model="employeeSearchForm.query" class="w-full"/>
                <Button prefixIcon="search"/>
            </form>
            <div class="flex gap-x-4">
                <Link :href="route('admin.leaves.holidays')" class="flex item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition bg-primary text-white px-4 py-2 gap-x-2">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-sm">settings</span>
                    </div>
                    <div class="flex items-center text-sm">Manage Holidays</div>
                </Link>

                <Link :href="route('admin.leaves.types')" class="flex item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition bg-primary text-white px-4 py-2 gap-x-2">
                    <div class="flex items-center">
                        <span class="material-symbols-outlined text-sm">settings</span>
                    </div>
                    <div class="flex items-center text-sm">Manage Leave Types</div>
                </Link>
            </div>
            
        </div>

        <div class="w-2/3 mx-auto mt-10 grid grid-cols-4">
            <EmployeeCard  v-for="user in props.users" :key="user.id" :user="user" link="admin.leaves.employee"/>
        </div>

    </AdminLayout>
</template>