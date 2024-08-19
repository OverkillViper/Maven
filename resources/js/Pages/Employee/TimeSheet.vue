<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import DatePicker from 'primevue/datepicker';
import { useForm } from '@inertiajs/vue3';
import Button from '@/Components/MavenComponents/Button.vue';

const dateSelectionForm = useForm({
    'dates' : []
})

const props = defineProps({
    attendances: Array
})

const fetchAttendance = () => {
    dateSelectionForm.get(route('employee.timesheet'));
}

</script>

<template>
<EmployeeLayout>
    <div>
        <div class="text-gray-500 text-sm font-medium">Time Sheet Range</div>
        <div class="flex items-center mt-2 gap-x-4">
            <DatePicker v-model="dateSelectionForm.dates" selectionMode="range" :manualInput="false" variant="filled" placeholder="Choose a date range"/>
            <Button label="Fetch Attendance" @click="fetchAttendance"/>
        </div>
    </div>
    <div class="w-2/3 mx-auto">
        <div class="flex justify-end gap-x-6">
            <div class="text-end">
                <div class="text-3xl">27</div>
                <div>Days In Total</div>
            </div>

            <div class="text-end">
                <div class="text-3xl">19</div>
                <div>Days Present</div>
            </div>
            
            <div class="text-end">
                <div class="text-3xl">09</div>
                <div>Days Absent</div>
            </div>
        </div>

        <div class="mt-6">
            <div class=" mt-4 border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="attendances.length == 0">
                <span class="material-symbols-outlined me-4">warning</span>
                <div class="me-8">
                    No record of attendance found for this date range.
                </div>
            </div>
            <div v-else>
                {{ attendances }}
            </div>
        </div>
    </div>
</EmployeeLayout>
</template>