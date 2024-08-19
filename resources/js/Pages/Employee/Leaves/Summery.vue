<script setup>
import Chart from 'primevue/chart';

const props = defineProps({
    leaveSummery : Array
})

const getChartData = (leave) => {
    const documentStyle = getComputedStyle(document.body);

    return {
        labels: ['Utilized', 'Pending', 'Balance'],
        datasets: [
            {
                data: [leave.utilized, leave.pending, leave.balance],
                cutout: '85%',
                rotation: '270',
                borderJoinStyle: 'round',
                backgroundColor: ['#252525', documentStyle.getPropertyValue('--p-orange-500'), '#5740eb'],
                hoverBackgroundColor: ['#353535', documentStyle.getPropertyValue('--p-orange-400'), documentStyle.getPropertyValue('--p-purple-400')]
            }
        ]
    };
};

const getChartOption = (leave) => {
    return {
        plugins: {
            legend: {
                display: false,
                position: 'bottom',
            },
        },
    }
}
</script>

<template>
    <div class="flex-grow flex flex-col">
        <div class="grid grid-cols-5 gap-10 my-4">
            <div v-for="leave in props.leaveSummery" :key="leave.leaveType">
                <div class="relative">
                    <div class="text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xl">
                        {{ leave.balance }}
                        <div class="text-xs">Remaining</div>
                    </div>
                    <Chart type="doughnut" :data="getChartData(leave)" :options="getChartOption(leave)" class="font-medium"/>
                </div>
                

                <div class="text-center font-semibold text-sm mt-2">{{ leave.leaveType }}</div>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <div class="col-span-3 text-primary text-sm font-semibold">Allocations</div>

            <div v-for="leave in leaveSummery" :key="leave.id" class="border rounded-md bg-accent flex items-center text-sm divide divide-x-2 overflow-hidden">
                <div class="font-medium p-2 flex-grow">{{ leave.leaveType }}</div>
                <div class="font-semibold p-2 bg-white w-10 text-center">{{ leave.allocation < 10 ? '0' : '' }}{{ leave.allocation }}</div>
            </div>
        </div>
    </div>
</template>