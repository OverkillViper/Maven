<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CreateHolidayModal from '@/Components/MavenComponents/CreateHolidayModal.vue';
import DeleteHolidayModal from '@/Components/MavenComponents/DeleteHolidayModal.vue';
import EditHolidayModal from '@/Components/MavenComponents/EditHolidayModal.vue';
import Select from 'primevue/select';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    holidays : Object
})

const years = [];
const yearRange = 10;
const today = new Date();
const currentYear = today.getFullYear();

for(let year = currentYear; year > currentYear - yearRange; year--) {
    years.push(year);
}

const yearForm = useForm({
    year : ''
});

const submitYearForm = () => {
    // console.log('Selected Year:', yearForm.year);
    yearForm.get(route('admin.holidays'));
};

const formattedDate = (date) => {
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return new Intl.DateTimeFormat('en-GB', options).format(new Date(date));
};

const isPastDate = (date) => {  
    const holidayDate = new Date(date);
    return holidayDate < today.setHours(0, 0, 0, 0);  // Compare without time
};

</script>

<template>
    <AdminLayout pageTitle="Holidays">

        <div class="flex items-center justify-between p-5" >
            <div class="flex items-center">
                <span class="material-symbols-outlined text-gray-500">tune</span>
                <Select v-model="yearForm.year" variant="filled" :options="years" placeholder="Filter by year" class="ms-4" @update:modelValue="submitYearForm"/>
                <!-- <DatePicker v-model="year" placeholder="Filter Holiday year" view="year" dateFormat="yy" variant="filled" class="ms-4"/> -->
            </div>
            <CreateHolidayModal btnLabel="Create Holiday" btnIcon="add" v-if="props.holidays.length != 0"/>
        </div>

        <div class="border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="props.holidays.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">
                No records of Holiday found
            </div>

            <CreateHolidayModal btnLabel="Create Holiday" btnIcon="add"/>
        </div>

        <div class="w-2/3 mx-auto mt-4">
            <div v-for="holiday in holidays" :key="holiday.id" class="flex items-center py-3 px-6 rounded-md border mb-4" :class="isPastDate(holiday.date) ? 'bg-gray-200' : 'bg-white'">
                <div class="flex-grow">
                    <div class="text-primary font-semibold">
                        {{ holiday.name }}
                    </div>
                    <div class="text-gray-500 font-medium">
                        {{ formattedDate(holiday.date) }}
                    </div>
                </div>
                <div class="ms-2">
                    <DeleteHolidayModal :holiday="holiday.id" btnIcon="delete"/>
                </div>
                <div class="ms-2">
                    <EditHolidayModal :holiday="holiday" btnIcon="edit"/>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>