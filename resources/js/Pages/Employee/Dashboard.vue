<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Link } from '@inertiajs/vue3';
import Button from '@/Components/MavenComponents/Button.vue';
import Attendance from '@/Pages/Employee/Dashboard/Attendance.vue';
import LunchBooking from '@/Pages/Employee/Dashboard/LunchBooking.vue';
import LeaveSummery from '@/Pages/Employee/Dashboard/LeaveSummery.vue';


const props = defineProps({
    attendance        : Object,
    lunchBookingDates : Array,
    bookedTomorrow    : Boolean,
    bookedToday       : Boolean,
    leaveSummery      : Array,
});

</script>

<template>
    <EmployeeLayout>
        <div class="grid grid-cols-2 gap-5">
            <Attendance :attendance="props.attendance"/>
            <LunchBooking
                :dates="lunchBookingDates"
                :bookedTomorrow="bookedTomorrow"
                :bookedToday="bookedToday"
            />
            <LeaveSummery :leaveSummery="leaveSummery"/>
        </div>
    </EmployeeLayout>
</template>