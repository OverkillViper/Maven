<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

import General from '@/Pages/Admin/EmployeeProfile/General.vue';
import JobDetails from '@/Pages/Admin/EmployeeProfile/JobDetails.vue';
import Summery from '@/Pages/Admin/EmployeeProfile/Summery.vue';

import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

defineProps({
    user : Object
})

</script>

<template>
    <AdminLayout pageTitle="Employee Details">
        <div class="-mt-4">
            <Tabs value="0">
                <TabList>
                    <Tab value="0">
                        <div class="font-semibold">Summery</div>
                    </Tab>
                    <Tab value="1">
                        <div class="font-semibold">General</div>
                    </Tab>
                    <Tab value="2">
                        <div class="font-semibold">Job Details</div>
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Summery :user="user"/>
                    </TabPanel>
                    <TabPanel value="1">
                        <General :user="user"/>
                    </TabPanel>
                    <TabPanel value="2">
                        <JobDetails :user="user"/>
                    </TabPanel>
                </TabPanels>
            </Tabs>
        </div>

    </AdminLayout>
</template>

<style scoped>
.p-tab {
    padding: 0.8rem;
}
</style>