<script setup>
import InfoField from '@/Pages/Common/InfoField.vue'
import { computed } from 'vue';

const props = defineProps({
    auth : Object
});

const user                  = computed(() => props.auth.user);
const employee              = computed(() => props.auth.user.employee);

const getImageUrl = (imagePath) => {
  return `/storage/${imagePath}`;
};

const salaryCurrency = employee.job_location == 'Bangladesh'               ? 'BDT' :
                       employee.job_location == 'India'                    ? 'RS'  :
                       employee.job_location == 'United States of America' ? 'USD' :
                       employee.job_location == 'Canada'                   ? 'CAD' : '';

</script>

<template>
    <div class="w-2/3 mx-auto flex flex-col gap-y-6">
        <div class="flex rounded-lg mt-24 p-6 bg-primary">
            <div class="basis-2/3">
                <div class="text-xl font-semibold text-white">{{ user.first_name }} {{ user.last_name }}</div>
                <div class="text-sm text-gray-200">{{ employee.designation.title }}, {{ employee.department.name }}</div>

                <div class="grid grid-cols-3 mt-6 text-white font-medium">
                    <div class="text-gray-300 text-sm">First name</div>
                    <div class="text-gray-300 text-sm">Last name</div>
                    <div class="text-gray-300 text-sm">Email name</div>
                    <div>{{ user.first_name }}</div>
                    <div>{{ user.last_name }}</div>
                    <div>{{ user.email }}</div>
                </div>
            </div>
            <div class="basis-1/3 flex justify-end">
                <div class=" -mt-20">
                    <img :src="employee.avatar ? getImageUrl(employee.avatar) : '/images/user.webp'" alt="" srcset="" class="w-40 aspect-square rounded-full shadow-md border">
                </div>
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <div class="section-label">
                Job Details
            </div>
            <div class="grid grid-cols-3 mt-4 gap-y-4">

                <InfoField label="Employee ID"    :value="employee.employee_id" />
                <InfoField label="Department"     :value="employee.department.name" />
                <InfoField label="Designation"    :value="employee.designation.title" />
 
                <InfoField label="Service Type"   :value="employee.servicetype" />
                <InfoField label="Job Location"   :value="employee.job_location" />
                <InfoField label="Salary"         :value="employee.salary + ' ' + salaryCurrency" />

                <InfoField label="Join Date"      :value="employee.joined_at" />
                <InfoField label="Permanent Date" :value="employee.permanent_at" />

            </div>
        </div>

        <div class="border rounded-lg p-6">
            <div class="section-label">
                Personal Information
            </div>
            <div class="grid grid-cols-3 mt-4 gap-y-4">
                <InfoField label="Date of Birth"    :value="employee.date_of_birth" />
                <InfoField label="Marital Status"   :value="employee.marital_status" />
                <InfoField label="Gender"           :value="employee.gender" />
                <InfoField label="Title"            :value="employee.title" />
                <InfoField label="Blood Group"      :value="employee.blood_group" />
                <InfoField label="Contact Number"   :value="employee.contact" />
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <div class="section-label">
                Identification
            </div>
            <div class="grid grid-cols-3 mt-4 gap-y-4">
                <InfoField label="NID"              :value="employee.nid" />
                <InfoField label="Passport"         :value="employee.passport" />
                <InfoField label="Driving License"  :value="employee.driving_license" />
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <div class="section-label">
                Ethnic Information
            </div>
            <div class="grid grid-cols-3 mt-4 gap-y-4">
                <InfoField label="Religion"         :value="employee.religion" />
                <InfoField label="Nationality"      :value="employee.nationality" />
            </div>
        </div>

        <div class="border rounded-lg p-6">
            <div class="section-label">
                Family Information
            </div>
            <div class="grid grid-cols-3 mt-4 gap-y-4">
                <InfoField label="Father's Name"      :value="employee.father_name" />
                <InfoField label="Mother's Name"      :value="employee.mother_name" />
                <InfoField label="Spouse's Name"      :value="employee.spouse_name" />
            </div>
        </div>
    </div>
</template>

<style scoped>

.section-label {
    @apply uppercase text-sm font-semibold text-primary;
}

</style>