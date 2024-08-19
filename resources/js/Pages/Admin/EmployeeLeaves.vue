<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
// import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { useForm } from '@inertiajs/vue3';
import InputNumber from 'primevue/inputnumber';

const getImageUrl = (imagePath) => {
  return `/storage/${imagePath}`;
};

const props = defineProps({
    user                : Object,
    departmentAncestors : Array,
    experience          : Object,
    leaves              : Array,
});

const leaveProfileForm = useForm({
    user_id : props.user.id
});

const leaveAllocationsForm = useForm({
    leaves: props.leaves.map(leave => ({
        id: leave.id,
        type: leave.type.name,
        allocation: leave.allocation
    }))
});

const createLeaveProfile = () => {
    leaveProfileForm.post(route('admin.leaves.profile.create'), {
        onFinish: () => {
            leaveProfileForm.name = '';
        },
    });
};

const submitLeaveAllocations = () => {
    leaveAllocationsForm.put(route('admin.leaves.profile.update', props.user.id));
};

const employee = props.user.employee;

</script>

<template>
    <AdminLayout pageTitle="Employee Leaves">

        <div class="w-2/3 mx-auto flex gap-x-4">
            <div class="basis-1/3">
                <div class="rounded-lg border p-5 flex flex-col items-center bg-gray-50">
                    <img :src="employee.avatar ? getImageUrl(employee.avatar) : '/images/user.webp'" alt="" srcset="" class="w-40 aspect-square rounded-full shadow-md border">
        
                    <div class="text-gray-800 font-semibold text-lg mt-8">
                        {{ props.user.first_name }} {{ props.user.last_name }}
                    </div>
                    
                    <div class="text-sm text-gray-600 font-medium" v-if="employee.designation">{{ employee.designation.title }}</div>
                    <div class="text-sm text-gray-600 font-medium mt-1" v-if="employee.department">
                        {{ employee.department.name }}
                        <span v-for="ancestor in departmentAncestors" :key="ancestor.id">
                        / {{ ancestor.name }}
                        </span>
                    </div>
        
                    <div class="font-semibold mt-6 text-primary">
                        ID: {{ employee.employee_id }}
                    </div>
                    <div class="font-medium">
                        {{ experience.years }} Years {{ experience.months }} months
                    </div>
                    <div class="font-medium">
                        {{ user.email }}
                    </div>
                </div>
            </div>

            <div class="basis-2/3 border rounded-lg p-5 flex justify-center items-center">
                <div class="text-gray-500 font-medium text-center" v-if="props.leaves.length == 0">
                    <div>
                        <span class="material-symbols-outlined me-4">warning</span>
                    </div>
                    
                    No leave profile found for this employee.
                    <br>
                    Please create a leave profile.

                    <div class="flex justify-center mt-6">
                        <Button label="Create Leave Profile" prefixIcon="add" @click="createLeaveProfile"/>
                    </div>
                </div>
                <form @submit.prevent="submitLeaveAllocations" class="w-full h-full flex flex-col" v-else>
                    <div class="text-primary font-semibold">
                        Leave Profile
                    </div>
                    <div class="flex flex-grow">
                        <div class="m-auto">
                            <div class="flex justify-between text-sm font-semibold">
                                <div>Leave type</div>
                                <div>Allocation</div>
                            </div>
                            <div class="flex items-center my-2" v-for="(leave, index) in leaveAllocationsForm.leaves" :key="leave.id">
                                <div class="basis-2/3 font-medium text-sm text-gray-600">{{ leave.type }}</div>
                                <div class="basis-1/3">
                                    <InputNumber  v-model="leaveAllocationsForm.leaves[index].allocation" showButtons :min=0 buttonLayout="horizontal" fluid variant="filled">
                                        <template #incrementbuttonicon>
                                            <span class="material-symbols-outlined">add</span>
                                        </template>
                                        <template #decrementbuttonicon>
                                            <span class="material-symbols-outlined">remove</span>
                                        </template>
                                    </InputNumber>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <Button label="Save" prefixIcon="save" type="submit"/>
                    </div>
                </form>
            </div>
        </div>

    </AdminLayout>
</template>
