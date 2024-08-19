<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import Select from 'primevue/select';
import Divider from 'primevue/divider';
import DatePicker from 'primevue/datepicker';

const $page = usePage();

const user = $page.props.auth.user;
const employee = user.employee;

const personalInformationForm = useForm({
    'date_of_birth'   : employee.date_of_birth,
    'marital_status'  : employee.marital_status,
    'gender'          : employee.gender,
    'title'           : employee.title,
    'blood_group'     : employee.blood_group,
    'contact'         : employee.contact,
    'nid'             : employee.nid,
    'passport'        : employee.passport,
    'driving_license' : employee.driving_license,
    'religion'        : employee.religion,
    'nationality'     : employee.nationality,
    'father_name'     : employee.father_name,
    'mother_name'     : employee.mother_name,
    'spouse_name'     : employee.spouse_name,
});

const marital_statuses = ['Single', 'Married', 'Widowed'];
const genders          = ['Male', 'Female', 'Other'];
const titles           = ['Mr.', 'Ms.', 'Mrs.'];
const blood_groups     = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-', 'Other'];
const reliogions       = ['Islam (Sunni)', 'Islam (Shia)', 'Hinduism', 'Christianity', 'Buddhism', 'Other'];
const nationalities    = ['Bangladeshi', 'Others'];

const handleDOBChange = (newDate) => {
    if (newDate) {
        personalInformationForm.date_of_birth = new Date(newDate.getTime() - newDate.getTimezoneOffset() * 60000);
    }
}

const saveProfile = () => {
    personalInformationForm.post(route('profile.personal.update'), {
        onFinish: () => {
            personalInformationForm.reset();
        },
    });
};

</script>

<template>
    <form @submit.prevent="saveProfile" class="w-2/3 mx-auto grid grid-cols-2 gap-4">
        <Divider align="left" type="solid" class="col-span-2">
            <div class="text-gray-500">
                Basic
            </div>
        </Divider>
        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Date of Birth
            </div>
            <DatePicker @date-select="handleDOBChange($event)" v-model="personalInformationForm.date_of_birth" variant="filled" placeholder="Date of Birth" class="h-9 w-full text-sm" showButtonBar />
        </div>

        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Marital Status
            </div>
            <Select variant="filled" v-model="personalInformationForm.marital_status" :options="marital_statuses" placeholder="Select Marital Status" class="w-full">
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
                Gender
            </div>
            <Select variant="filled" v-model="personalInformationForm.gender" :options="genders" placeholder="Select Gender" class="w-full">
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
                Title
            </div>
            <Select variant="filled" v-model="personalInformationForm.title" :options="titles" placeholder="Select Title" class="w-full">
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
                Blood group
            </div>
            <Select variant="filled" v-model="personalInformationForm.blood_group" :options="blood_groups" placeholder="Select Blood Group" class="w-full">
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
        
        <FormInputs v-model="personalInformationForm.contact" label="Contact" placeholder="Enter Contact Number" type="text"/>

        <Divider align="left" type="solid" class="col-span-2">
            <div class="text-gray-500">
                Identification
            </div>
        </Divider>

        <FormInputs v-model="personalInformationForm.nid" label="NID" placeholder="Enter National ID Number" type="text"/>

        <FormInputs v-model="personalInformationForm.passport" label="Passport" placeholder="Enter Passport Number" type="text"/>

        <FormInputs v-model="personalInformationForm.driving_license" label="Driving license" placeholder="Enter Driving License Number" type="text"/>

        <Divider align="left" type="solid" class="col-span-2">
            <div class="text-gray-500">
                Ethinic Information
            </div>
        </Divider>

        <div>
            <div class="ms-1 text-sm font-medium text-gray-500 mb-1">
                Religion
            </div>
            <Select variant="filled" v-model="personalInformationForm.religion" :options="reliogions" placeholder="Select Religion" class="w-full">
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
                Nationality
            </div>
            <Select variant="filled" v-model="personalInformationForm.nationality" :options="nationalities" placeholder="Select Nationality" class="w-full">
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

        <Divider align="left" type="solid" class="col-span-2">
            <div class="text-gray-500">
                Familty Details
            </div>
        </Divider>

        <FormInputs v-model="personalInformationForm.father_name" label="Father's name" placeholder="Enter Father Name" type="text"/>

        <FormInputs v-model="personalInformationForm.mother_name" label="Mother's name" placeholder="Enter Mother Name" type="text"/>

        <FormInputs v-model="personalInformationForm.spouse_name" label="Spouse's name" placeholder="Enter Spouse Name" type="text"/>

        <div class="flex col-span-2 justify-end">
            <Button tpye="submit" label="Save profile" prefixIcon="save"/>
        </div>
    </form>
</template>

<style scoped>
    .p-divider {
        @apply -mb-1 mt-4 font-semibold;
    }
</style>