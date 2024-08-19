<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import Select from 'primevue/select';
import InputOtp from 'primevue/inputotp';
import DatePicker from 'primevue/datepicker';

const $page = usePage();

const user = $page.props.auth.user;
const employee = user.employee;

const jobInformationForm = useForm({
    'employee_id'    : employee.employee_id + '',
    'department'     : employee.department,
    'designation'    : employee.designation,
    'servicetype'    : employee.servicetype,
    'salary'         : employee.salary,
    'job_location'   : employee.job_location,
    'joined_at'      : employee.joined_at,
    'permanent_at'   : employee.permanent_at,
});

const salaryCurrency = computed(() => (
    jobInformationForm.job_location == 'Bangladesh'               ? 'BDT' :
    jobInformationForm.job_location == 'India'                    ? 'RS'  :
    jobInformationForm.job_location == 'United States of America' ? 'USD' :
    jobInformationForm.job_location == 'Canada'                   ? 'CAD' : '')
);

defineProps({
    'designations' : Object,
    'departments'  : Object,
})

const designations = $page.props.designations;
const departments  = $page.props.departments;
const servicetype  = ['Probation', 'Permanent'];
const job_location = ['Bangladesh', 'United States of America', 'Canada', 'India'];

const saveProfile = () => {
    jobInformationForm.post(route('profile.jobdetail.update'), {
        onFinish: () => {
            jobInformationForm.reset();
        },
    });
};

const handleJoinedAtDateChange = (newDate) => {
  if (newDate) {
    jobInformationForm.joined_at = new Date(newDate.getTime() - newDate.getTimezoneOffset() * 60000);
  }
}

const handlePermanentAtDateChange = (newDate) => {
  if (newDate) {
    jobInformationForm.permanent_at = new Date(newDate.getTime() - newDate.getTimezoneOffset() * 60000);
  }
}

</script>
<template>
    <div>
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
                <Select showClear variant="filled" v-model="jobInformationForm.department" :options="departments" filter :optionLabel="departments.name" placeholder="Select Department" class="w-full">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex items-center text-sm h-5">
                            <div>{{ slotProps.value.name }}</div>
                        </div>
                        <div v-else class="text-sm h-5">
                            {{ slotProps.placeholder }}
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="flex items-center text-sm">
                            <div>{{ slotProps.option.name }}</div>
                        </div>
                    </template>
                </Select>
            </div>
            
            <div>
                <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                    Designation
                </div>
                <Select showClear class="w-full" variant="filled" v-model="jobInformationForm.designation" :options="designations" filter :optionLabel="designations.title" placeholder="Select Designation">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex items-center text-sm h-5">
                            <div>{{ slotProps.value.title }}</div>
                        </div>
                        <div v-else class="text-sm h-5">
                            {{ slotProps.placeholder }}
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="flex items-center text-sm">
                            <div>{{ slotProps.option.title }}</div>
                        </div>
                    </template>
                </Select>
            </div>

            <div>
                <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                    Service Type
                </div>
                <Select showClear variant="filled" v-model="jobInformationForm.servicetype" :options="servicetype" placeholder="Select Service type" class="w-full">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex items-center text-sm h-5">
                            <div>{{ slotProps.value }}</div>
                        </div>
                        <div v-else class="text-sm h-5">
                            {{ slotProps.placeholder }}
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="flex items-center text-sm">
                            <div>{{ slotProps.option }}</div>
                        </div>
                    </template>
                </Select>
            </div>

            <div>
                <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                    Job Location
                </div>
                <Select showClear variant="filled" v-model="jobInformationForm.job_location" :options="job_location" placeholder="Select Job location" class="w-full">
                    <template #value="slotProps">
                        <div v-if="slotProps.value" class="flex items-center text-sm h-5">
                            <div>{{ slotProps.value }}</div>
                        </div>
                        <div v-else class="text-sm h-5">
                            {{ slotProps.placeholder }}
                        </div>
                    </template>
                    <template #option="slotProps">
                        <div class="flex items-center text-sm">
                            <div>{{ slotProps.option }}</div>
                        </div>
                    </template>
                </Select>
            </div>

            <FormInputs v-model="jobInformationForm.salary" label="Salary" placeholder="Enter Salary" type="number" :prefixLabel="salaryCurrency"/>

            <div>
                <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                    Join Date
                </div>
                <DatePicker @date-select="handleJoinedAtDateChange($event)" v-model="jobInformationForm.joined_at" variant="filled" placeholder="Join date" class="h-10 w-full text-sm" showButtonBar />
            </div>

            <div>
                <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                    Permanent at
                </div>
                <DatePicker @date-select="handlePermanentAtDateChange($event)" v-model="jobInformationForm.permanent_at" variant="filled" placeholder="Permanant date" class="h-10 w-full text-sm" showButtonBar />
            </div>
            
            <div class="flex col-span-2 justify-end">
                <Button tpye="submit" label="Save profile" prefixIcon="save"/>
            </div>
        </form>
    </div>
    
</template>

<style scoped>


</style>