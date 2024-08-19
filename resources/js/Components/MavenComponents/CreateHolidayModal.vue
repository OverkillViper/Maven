<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import DatePicker from 'primevue/datepicker';

const visible = ref(false);

const props = defineProps({
    btnLabel : String,
    btnIcon  : String
});

const holidayForm = useForm({
    name : '',
    date : '',
});

const createHoliday = () => {

    holidayForm.parent_id = props.parent;

    holidayForm.post(route('admin.leaves.holiday.create'), {
        onFinish: () => {
            holidayForm.name = '';
            visible.value = false;
        },
    });

};

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Create Holiday" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Holiday name" v-model="holidayForm.name" class="text-gray-800"/>
            <div class="mt-4 font-semibold">Pick holiday date</div>
            <DatePicker v-model="holidayForm.date" inline class="w-full mt-2" showButtonBar />
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="createHoliday"   suffixIcon="add"   label="Create" :class="{ 'opacity-75': holidayForm.processing }" :disabled="holidayForm.processing"/>
        </div>
    </Dialog>
</template>