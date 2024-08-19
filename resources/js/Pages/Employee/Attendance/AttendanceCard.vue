<script setup>
import { format } from 'date-fns';
import Button from '@/Components/MavenComponents/Button.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    attendance : Object
});

const formatDate = (date) => {
    return format(new Date(date), 'dd');
}

const formatMonth = (date) => {
    return format(new Date(date), 'MMMM');
}

const formatDay = (date) => {
    return format(new Date(date), 'EEE');
}

const formatTime = (time) => {
    if (!time || time === 'N/A' || time === 'NC') return 'N/A';
    return format(new Date(time), 'hh:mm a'); // 12-hour format with AM/PM
}

</script>

<template>
    <div class="mb-4 p-3 rounded-md border shadow-sm flex items-center" :class="{'bg-gray-100' : attendance.in_time == 'N/A'}">
        <div class="text-end w-32 border-r-2 pe-6">
            <div class="text-2xl font-medium">{{formatDate(attendance.date)}}</div>
            <div class="text-sm">{{ formatMonth(attendance.date) }} | {{ formatDay(attendance.date) }}</div>
        </div>
        <div class="flex items-center flex-grow">
            <div class="ms-4 basis-1/3">
                <div class="text-sm uppercase">In Time</div>
                <div class="text-xl font-medium">
                    {{ formatTime(attendance.in_time) }}
                </div>
            </div>
            <div class="ms-4 basis-1/3">
                <div class="text-sm uppercase">Out Time</div>
                <div class="text-xl font-medium">
                    {{ formatTime(attendance.out_time) }}
                </div>
            </div>
            <div class="ms-4 basis-1/3 flex justify-end gap-x-2">
                <Link href="#">
                    <Button label="Apply leave" compact/>
                </Link>
                <Link href="#">
                    <Button label="Request Time Change" compact/>
                </Link>

            </div>
        </div>

    </div>
</template>