<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue';
import { FwbTab, FwbTabs, FlowbiteThemable  } from 'flowbite-vue';
import General from '@/Pages/Admin/Profile/General.vue';
import JobDetails from '@/Pages/Admin/Profile/JobDetails.vue';
import { usePage } from '@inertiajs/vue3';

const activeTab = ref('jobDetails')

const $page = usePage();

const departments = $page.props.departments;

</script>

<template>
    <AdminLayout pageTitle="Profile">
        <div class="-mt-4 ">
            <flowbite-themable theme="purple">
                <fwb-tabs v-model="activeTab" variant="underline" class="p-5">
                    <fwb-tab name="general" title="General">
                        <General />
                    </fwb-tab>
                    <fwb-tab name="jobDetails" title="Job Details">
                        <JobDetails :departments="departments" />
                    </fwb-tab>
                    <fwb-tab name="third" title="Third">
                    Lorem ipsum dolor...
                    </fwb-tab>
                </fwb-tabs>
            </flowbite-themable>
            
        </div>
        
    </AdminLayout>
</template>