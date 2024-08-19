<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import CreateDesignationModal from '@/Components/MavenComponents/CreateDesignationModal.vue';
import DeleteDesignationModal from '@/Components/MavenComponents/DeleteDesignationModal.vue';
import EditDesignationModal from '@/Components/MavenComponents/EditDesignationModal.vue';
import { Link } from '@inertiajs/vue3';
import Timeline from 'primevue/timeline';
import Card from 'primevue/card';

const props = defineProps({
    designations : Object
})

const highestPosition = Math.max(...props.designations.map(d => d.position));
const lowestPosition = Math.min(...props.designations.map(d => d.position));

</script>

<template>
    <AdminLayout pageTitle="Designations">
        <div class="border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="props.designations.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">
                No records of designation found
            </div>

            <CreateDesignationModal btnLabel="Create designation" btnIcon="add"/>
        </div>

        <div class="p-5">
            <div class="flex justify-end" v-if="designations.length">
                <CreateDesignationModal btnLabel="Create designation" btnIcon="add"/>
            </div>
            <div class="w-3/5 mx-auto">
                <Timeline :value="designations" align="alternate">
                    <template #marker="slotProps">
                        <span class="flex w-8 h-8 items-center justify-center text-primary rounded-full z-10 shadow-sm border">
                            <span class="material-symbols-outlined text-sm">badge</span>
                        </span>
                    </template>
                    <template #content="slotProps">
                        <Card class="mt-4">
                            <template #title>
                                {{ slotProps.item.title }}
                            </template>
                            <template #content>
                                <div class="inline-flex items-center mt-2 gap-x-2">
                                    <DeleteDesignationModal btnIcon="delete" :designation="slotProps.item.id"/>
                                    <EditDesignationModal btnIcon="edit" :designation=  "slotProps.item"/>
                                    <Link v-if="slotProps.item.position !== highestPosition" method="post" as="button" :href="route('admin.designation.movedown', slotProps.item.id)" class="px-2 py-1 bg-primary text-white flex item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition">
                                        <span class="material-symbols-outlined text-sm">keyboard_arrow_up</span>
                                    </Link>
                                    <Link v-if="slotProps.item.position !== lowestPosition" method="post" as="button" :href="route('admin.designation.moveup', slotProps.item.id)" class="px-2 py-1 bg-primary text-white flex item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition">
                                        <span class="material-symbols-outlined text-sm">keyboard_arrow_down</span>
                                    </Link>
                                </div>
                            </template>
                        </Card>
                    </template>
                </Timeline>
            </div>
            
        </div>
    </AdminLayout>
</template>

<style lang="scss" scoped>
.p-card {
   @apply bg-gray-50;
}
</style>