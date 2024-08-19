<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import Request from '@/Pages/Employee/Leaves/Request.vue';
import History from '@/Pages/Employee/Leaves/History.vue';

import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

const props = defineProps({
    leaves           : Array,
    leaveSummery     : Array,
    pendingLeaves    : Array,
    approvedLeaves   : Array,
    year             : String,
})
</script>

<template>
    <EmployeeLayout>
        <div class="-mt-5">
            <Tabs :value="props.year ? '1' : '0'">
                <TabList>
                    <Tab value="0">
                        <div class="font-semibold">Leave Request</div>
                    </Tab>
                    <Tab value="1">
                        <div class="font-semibold">Leave History</div>
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Request :leaves="props.leaves" :leaveSummery="leaveSummery" class="-mx-5"/>
                    </TabPanel>
                    <TabPanel value="1">
                        <History :pendingLeaves="pendingLeaves" :approvedLeaves="approvedLeaves" :year="year"/>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>
    </EmployeeLayout>
</template>

<style scoped>
.p-tab {
    padding: 0.8rem;
}
</style>