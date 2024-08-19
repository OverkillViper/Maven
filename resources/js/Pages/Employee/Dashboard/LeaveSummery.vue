<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { Link } from '@inertiajs/vue3';
import Summery from '@/Pages/Employee/Leaves/Summery.vue';

const props = defineProps({
    leaveSummery : Array
})

</script>

<template>
    <div class="border rounded-lg p-5 flex flex-col">
        <div class="flex justify-between">
            <div class="font-semibold text-primary">
                Leave Summery
            </div>
            <Link :href="route('employee.leave.manage')">
                <Button label="Leave Management" suffixIcon="chevron_right" compact />
            </Link>
        </div>
        <Summery :leaveSummery="leaveSummery"/>
    </div>
</template>