<script setup>
import Clock from '@/Components/MavenComponents/Clock.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import Button from '@/Components/MavenComponents/Button.vue';

const props = defineProps({
    attendance : Object
});

const clockInForm = useForm({
    'time' : ''
});
const clockOutForm = useForm({
    'time' : ''
});

const submitClockIn = () => {
    clockInForm.post(route('employee.attendance.clockin'));
};

const submitClockOut = () => {
    clockOutForm.post(route('employee.attendance.clockout'));
};

const formattedInTime = computed(() => {
    if (!props.attendance || !props.attendance.in_time) {
        return '';
    }
    const date = new Date(props.attendance.in_time);
    return date.toLocaleTimeString('en-US', {
        hour:   'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true,
    });
});

const formattedOutTime = computed(() => {
    if (!props.attendance || !props.attendance.out_time) {
        return '';
    }
    const date = new Date(props.attendance.out_time);
    return date.toLocaleTimeString('en-US', {
        hour:   'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true,
    });
});

</script>

<template>

<div class="border rounded-lg p-5">
    <div class="flex justify-between items-center">
        <div class="font-semibold text-primary">Attendance</div>
        <Link href="#">
            <Button label="View time sheet" suffixIcon="chevron_right" compact />
        </Link>
    </div>

    <div class="flex justify-center my-6">
        <Clock />
    </div>

    <div class="my-6 w-64 mx-auto">
        <div class="flex items-center font-medium text-sm my-2">
            <span class="material-symbols-outlined me-2">fingerprint</span>
            <div class="flex-grow">
                Clock In Time
            </div>
            <div v-if="props.attendance">
                {{ formattedInTime }}
            </div>
        </div>
        <div class="flex items-center font-medium text-sm my-2">
            <span class="material-symbols-outlined me-2">move_item</span>
            <div class="flex-grow">
                Clock Out Time
            </div>
            <div v-if="props.attendance">
                {{ formattedOutTime }}
            </div>
        </div>
    </div>
    <div class="flex justify-between">
        <Button label="Clock In" prefixIcon="fingerprint" @click="submitClockIn"/>
        <Button label="Clock Out" prefixIcon="move_item"  @click="submitClockOut"/>
    </div>
</div>

</template>