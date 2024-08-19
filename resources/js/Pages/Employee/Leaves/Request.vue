<script setup>
import SelectButton from 'primevue/selectbutton';
import DatePicker from 'primevue/datepicker';
import InputText from 'primevue/inputtext';
import Editor from 'primevue/editor';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { differenceInDays } from 'date-fns';
import Button from '@/Components/MavenComponents/Button.vue';
import Summery from '@/Pages/Employee/Leaves/Summery.vue';

const leaveApplicationForm = useForm({
    type : '',
    date : [],
    reason : '',
})

const leaveTypes = [];

const totalDays = ref(0);

const props = defineProps({
    leaves : Array,
    leaveSummery : Array,
});

props.leaves.forEach(leave => {
    leaveTypes.push(leave.type.name)
});

const calculateDays = () => {
    totalDays.value = leaveApplicationForm.date[1] != null ? differenceInDays(leaveApplicationForm.date[1], leaveApplicationForm.date[0]) + 1 : 1;
}

const requestLeave = () => {
    leaveApplicationForm.post(route('employee.leave.request'), {
        onFinish: () => {
            leaveApplicationForm.reset();
        },
    });
};

</script>

<template>
    <div class="grid grid-cols-2 gap-x-5">
        <div class="border rounded-lg p-5">
            <div class="text-primary font-semibold">
                Leave Application
            </div>
            <form @submit.prevent="requestLeave">
                <div>
                    <div class="text-sm font-medium text-gray-500 mt-4 mb-1">Leave Type</div>
                    <SelectButton v-model="leaveApplicationForm.type" :options="leaves" aria-labelledby="basic" class="w-full" optionLabel="type.name" optionValue="type.id"/>
                </div>
                <div class="grid grid-cols-2 gap-x-6">
                    <div>
                        <div class="text-sm font-medium text-gray-500 mt-4 mb-1">Leave Date</div>
                        <DatePicker dateFormat="dd/mm/yy" v-model="leaveApplicationForm.date" showIcon fluid selectionMode="range" iconDisplay="input" showButtonBar @date-select="calculateDays" @clear-click="totalDays = 0">
                            <template #inputicon="slotProps">
                                <span class="material-symbols-outlined -mt-1" @click="slotProps.clickCallback">date_range</span>
                            </template>
                        </DatePicker>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 mt-4 mb-1">Total Days</div>
                        <InputText v-model="totalDays" disabled placeholder="Disabled" size="small" class="w-full"/>
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="text-sm font-medium text-gray-500 mt-4 mb-1">Leave Reason</div>
                    <Editor v-model="leaveApplicationForm.reason" editorStyle="height: 220px">
                        <template v-slot:toolbar>
                            <span class="ql-formats">
                                <button v-tooltip.bottom="'Bold'"      class="ql-bold"      ></button>
                                <button v-tooltip.bottom="'Italic'"    class="ql-italic"    ></button>
                                <button v-tooltip.bottom="'Underline'" class="ql-underline" ></button>
                            </span>
                            <span class="ql-formats">
                                <button v-tooltip.bottom="'Numbered List'"      class="ql-list" value="ordered"  type="button"></button>
                            </span>
                        </template>
                    </Editor>
                </div>
                <div class="flex justify-end mt-4">
                    <Button label="Request Leave" prefixIcon="check" type="submit"/>
                </div>
            </form>
        </div>
        <div class="border rounded-lg p-5 flex flex-col">
            <div class="text-primary font-semibold">
                Leave Summery
            </div>
            <Summery :leaveSummery="leaveSummery"/>
        </div>
    </div>
</template>