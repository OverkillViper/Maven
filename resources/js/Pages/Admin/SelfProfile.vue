<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import General from '@/Pages/Admin/Profile/General.vue';
import JobDetails from '@/Pages/Admin/Profile/JobDetails.vue';
import Personal from '@/Pages/Admin/Profile/Personal.vue';
import Summery from '@/Pages/Admin/Profile/Summery.vue';

import Tabs from 'primevue/tabs';
import TabList from 'primevue/tablist';
import Tab from 'primevue/tab';
import TabPanels from 'primevue/tabpanels';
import TabPanel from 'primevue/tabpanel';

const props = defineProps({
    auth : Object
})

</script>

<template>
    <AdminLayout pageTitle="Profile">
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
                    <Tab value="3">
                        <div class="font-semibold">Personal</div>
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Summery :auth="props.auth"/>
                    </TabPanel>
                    <TabPanel value="1">
                        <General />
                    </TabPanel>
                    <TabPanel value="2">
                        <JobDetails />
                    </TabPanel>
                    <TabPanel value="3">
                        <Personal />
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