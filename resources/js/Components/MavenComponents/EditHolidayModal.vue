<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import { useForm } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';
import DatePicker from 'primevue/datepicker';

const visible = ref(false);

const props = defineProps({
    btnLabel    : String,
    btnIcon     : String,
    holiday     : Object
})

const holidayForm = useForm({
    name : props.holiday.name,
    date : props.holiday.date,
});

const updateHoliday = () => {
    holidayForm.put(route('admin.leaves.holiday.update', props.holiday.id), {
        onFinish: () => {
            visible.value = false;
        },
    });
};

</script>

<template>  
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Modify Holiday" :style="{ width: '25rem' }" class="dialog">
        <form @submit.prevent>
            <FormInputs type="text" placeholder="Holiday name" v-model="holidayForm.name" class="text-gray-800"/>
            <DatePicker v-model="holidayForm.date" inline class="w-full mt-2" showButtonBar dateFormat="yy-mm-dd"/>
        </form>
        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Button @click="updateHoliday" suffixIcon="save" label="Save" :class="{ 'opacity-75': holidayForm.processing }" :disabled="holidayForm.processing"/>
        </div>
    </Dialog>
</template>