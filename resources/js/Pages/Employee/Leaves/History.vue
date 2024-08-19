<script setup>
import Select from 'primevue/select';
import { useForm, Link } from '@inertiajs/vue3';
import { format } from 'date-fns';
import Button from '@/Components/MavenComponents/Button.vue';

const props = defineProps({
    pendingLeaves    : Array,
    approvedLeaves   : Array,
    year             : String
});

const years = [];
const yearRange = 10;
const today = new Date();
const currentYear = today.getFullYear();

for(let year = currentYear; year > currentYear - yearRange; year--) {
    years.push(year);
}

const yearFilterForm = useForm({
    year : props.year == null ? currentYear : parseInt(props.year),
})

const submitYearForm = () => {
    yearFilterForm.get(route('employee.leave.manage'));
};

const cancelLeaveForm = useForm({
    leave: ''
})

const formatDate = (date) => {
    const dateObj = new Date(date);
    const dayOfMonth = format(dateObj, 'dd');
    const dayName = format(dateObj, 'EEE').toUpperCase();
    const monthName = format(dateObj, 'MMMM');

    return {
        'day'       : dayOfMonth,
        'dayName'   : dayName,
        'month'     : monthName,
    }
}

const cancelLeave = (leave) => {
    cancelLeaveForm.leave = leave;
    cancelLeaveForm.post(route('employee.leave.cancel'));
}

</script>

<template>
    <div class="flex items-center">
        <div class="me-6 font-medium">Leave Year</div>
        <Select v-model="yearFilterForm.year" :options="years" placeholder="Select leave year" @update:modelValue="submitYearForm"/>
    </div>

    <div class="w-2/3 mx-auto">

        <div class="flex items-center mt-6 text-xl font-semibold">
            <div class="text-primary me-2">{{ pendingLeaves.length < 10 ? '0' : '' }}{{ pendingLeaves.length  }}</div>
            <div>Pending Leave Requests</div>
        </div>
        
        <div class=" mt-4 border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="pendingLeaves.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">
                No record of leave request found for the selected year
            </div>
        </div>
        
        <div class="mt-4" v-else>
            <!-- {{ appliedLeaves }} -->
            <div v-for="leave in pendingLeaves" :key="leave.id"class="border rounded-md p-4 mb-4 flex items-center gap-x-6 shadow-sm bg-gray-50 select-none">
                <div class="w-28">
                    <div class="text-2xl text-end">{{ formatDate(leave.date).day }}</div>
                    <div class="text-sm font-medium text-end">{{ formatDate(leave.date).month }} | {{ formatDate(leave.date).dayName }}</div>
                </div>
                <div class="flex-grow">
                    <div class="font-semibold text-lg">{{ leave.type.name }} leave</div>
                    <div v-html="leave.reason" class="line-clamp-1" ></div>
                </div>
                <div>
                    <Button label="Cancel request" prefixIcon="close" @click="cancelLeave(leave.id)"/>
                </div>
            </div>
        </div>

        <div class="flex items-center mt-10 text-xl font-semibold">
            <div class="text-primary me-2">{{ approvedLeaves.length < 10 ? '0' : '' }}{{ approvedLeaves.length  }}</div>
            <div>Approved Leave Requests</div>
        </div>
        
        <div class=" mt-4 border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="approvedLeaves.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">
                No record of leave request found for the selected year
            </div>
        </div>
        
        <div class="mt-4" v-else>
            <!-- {{ appliedLeaves }} -->
            <div v-for="leave in approvedLeaves" :key="leave.id"class="border rounded-md p-4 mb-4 flex items-center gap-x-6 shadow-sm bg-gray-50 select-none">
                <div class="w-28">
                    <div class="text-2xl text-end">{{ formatDate(leave.date).day }}</div>
                    <div class="text-sm font-medium text-end">{{ formatDate(leave.date).month }} | {{ formatDate(leave.date).dayName }}</div>
                </div>
                <div class="flex-grow">
                    <div class="font-semibold text-lg">{{ leave.type.name }} leave</div>
                    <div v-html="leave.reason" class="line-clamp-1" ></div>
                </div>
                <div>
                    <div class="font-medium text-sm">Approved By</div>
                    <div class="font-semibold text-lg">{{ leave.approved_by }}</div>
                </div>
            </div>
        </div>
    </div>
    
</template>