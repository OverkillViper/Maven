<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import Summery from '@/Pages/Employee/Profile/Summery.vue';
import General from '@/Pages/Employee/Profile/General.vue';
import Personal from '@/Pages/Employee/Profile/Personal.vue';
import { ref } from 'vue';

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
    <EmployeeLayout>
        <div class="-mt-5">
            <Tabs value="0">
                <TabList>
                    <Tab value="0">
                        <div class="font-semibold">Summery</div>
                    </Tab>
                    <Tab value="1">
                        <div class="font-semibold">General</div>
                    </Tab>
                    <Tab value="2">
                        <div class="font-semibold">Personal</div>
                    </Tab>
                </TabList>
                <TabPanels>
                    <TabPanel value="0">
                        <Summery :auth="props.auth"/>
                    </TabPanel>
                    <TabPanel value="1">
                        <General/>
                    </TabPanel>
                    <TabPanel value="2">
                        <Personal/>
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