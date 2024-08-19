<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { format, addDays, subDays, isEqual, isAfter } from 'date-fns';
import Button from '@/Components/MavenComponents/Button.vue';

const props = defineProps({
    dates           : Array,
    bookedTomorrow  : Boolean,
    bookedToday     : Boolean,
})

const getBackgroundColor = (isBooked, date) => {
    const today = new Date().toISOString().split('T')[0];
    const tomorrow = new Date();
    tomorrow.setDate(new Date().getDate() + 1);
    const tomorrowStr = tomorrow.toISOString().split('T')[0];

    if (date < tomorrowStr) {
        return isBooked ? 'bg-green-500' : 'bg-red-500';
    } else if (date === tomorrowStr) {
        return isBooked ? 'bg-green-500' : 'bg-white';
    } else {
        return 'bg-gray-500';
    }
};

const formatDay = (date) => {
    return new Date(date).toLocaleDateString(undefined, { weekday: 'short' }).toUpperCase();
};

const formatDate = (date) => {
    return new Date(date).getDate().toString().padStart(2, '0');
};

const lunchBookForm = useForm({
    date : null
});

const lunchBookCancelForm = useForm({
    date : null
});

const placeLunchBooking = () => {
    lunchBookForm.post(route('employee.lunchbooking.create'));
};

const cancelLunchBooking = () => {
    lunchBookCancelForm.post(route('employee.lunchbooking.delete'));
};

</script>

<template>
<div class="border rounded-lg p-5 flex flex-col justify-between">
    <div class="flex justify-between">
        <div class="font-semibold text-primary">
            Lunch Booking
            <div class="text-xl font-bold text-gray-700" v-if="bookedToday">Today: Booked</div>
            <div class="text-xl font-bold text-red-500" v-else>Today: Not Booked</div>
        </div>
        <Link href="#">
            <Button label="View all bookings" suffixIcon="chevron_right" compact />
        </Link>
    </div>

    <div class="flex justify-center gap-x-4">
        <div v-for="day in props.dates.dates" :key="day.date"
            :class="[getBackgroundColor(day.isBooked, day.date), 'select-none rounded-md bg-opacity-40 w-16 h-16 shadow-sm shadow-gray-400 flex flex-col justify-center items-center font-semibold']">
            <!-- <p>{{ new Date(day.date).toLocaleDateString(undefined, { weekday: 'short', day: 'numeric' }) }}</p> -->
            <div>{{ formatDate(day.date) }}</div>
            <div>{{ formatDay(day.date) }}</div>
        </div>
    </div>

    <div class="flex justify-center">
        <Button label="Cancel Lunch Booking" prefixIcon="no_meals" @click="cancelLunchBooking" v-if="bookedTomorrow"/>
        <Button label="Place Lunch Booking" prefixIcon="restaurant" @click="placeLunchBooking" v-else/>
        
    </div>
</div>    
</template>