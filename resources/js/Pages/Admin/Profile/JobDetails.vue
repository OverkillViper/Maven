<script setup>
import { ref } from 'vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import Select from 'primevue/select';
import InputOtp from 'primevue/inputotp';
const $page = usePage();

const jobInformationForm = useForm({
    'employee_id'    : $page.props.auth.user.employee.employee_id,
    'department_id'  : $page.props.auth.user.employee.department_id,
    'designation_id' : $page.props.auth.user.employee.designation_id,
    'servicetype'    : $page.props.auth.user.employee.servicetype,
    'salary'         : $page.props.auth.user.employee.salary,
    'job_location'   : $page.props.auth.user.employee.job_location,
    'joined_at'      : $page.props.auth.user.employee.joined_at,
    'permanent_at'   : $page.props.auth.user.employee.permanent_at,
});

defineProps({
    'designations' : Array,
    'departments'  : Array,
})

const saveProfile = () => {
    jobInformationForm.post(route('admin.profile.general.update'), {
        onFinish: () => {
            jobInformationForm.reset();
        },
    });
};

</script>
<template>
    <form @submit.prevent="saveProfile" class="w-2/3 mx-auto grid grid-cols-2 gap-4">
        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Employee ID
            </div>
            <InputOtp v-model="jobInformationForm.employee_id" integerOnly :length="6"/>
        </div>
        
        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Department
            </div>
            <Select variant="filled" v-model="jobInformationForm.department_id" :options="departments" filter optionLabel="name" placeholder="Select Department" class="w-full">
                <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex items-center mb-1">
                        <div>{{ slotProps.value.name }}</div>
                    </div>
                    <span v-else>
                        {{ slotProps.placeholder }}
                    </span>
                </template>
                <template #option="slotProps">
                    <div class="flex items-center">
                        <div>{{ slotProps.option.name }}</div>
                    </div>
                </template>
            </Select>
        </div>
        
        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Designation
            </div>
            <Select variant="filled" v-model="jobInformationForm.designation_id" :options="$page.props.designations" filter optionLabel="title" placeholder="Select Designation" class="w-full">
                <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex items-center mb-1">
                        <div>{{ slotProps.value.title }}</div>
                    </div>
                    <span v-else>
                        {{ slotProps.placeholder }}
                    </span>
                </template>
                <template #option="slotProps">
                    <div class="flex items-center">
                        <div>{{ slotProps.option.title }}</div>
                    </div>
                </template>
            </Select>
        </div>

        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Service Type
            </div>
            <Select variant="filled" v-model="jobInformationForm.servicetype" :options="$page.props.designations" filter optionLabel="title" placeholder="Select Designation" class="w-full">
                <template #value="slotProps">
                    <div v-if="slotProps.value" class="flex items-center mb-1">
                        <div>{{ slotProps.value.title }}</div>
                    </div>
                    <span v-else>
                        {{ slotProps.placeholder }}
                    </span>
                </template>
                <template #option="slotProps">
                    <div class="flex items-center">
                        <div>{{ slotProps.option.title }}</div>
                    </div>
                </template>
            </Select>
        </div>
    </form>
</template>

<style scoped>

</style>