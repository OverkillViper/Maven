<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import DepartmentList from '@/Pages/Admin/DepartmentList.vue';
import CreateDepartmentModal from '@/Components/MavenComponents/CreateDepartmentModal.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';

const expanded = ref(false);

defineProps({
    departments : Object
})

</script>

<template>
    <AdminLayout pageTitle="Departments">
        <div class="border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="departments.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">
                Currently this company has no departments
            </div>

            <CreateDepartmentModal btnLabel="Create a department" btnIcon="add"/>
        </div>

        <div class="flex justify-end gap-x-4" v-if="departments.length">
            <Button label="Expand All" prefixIcon="add" compact @click="expanded = true"/>
            <Button label="Collapse All" prefixIcon="remove" compact @click="expanded = false"/>
        </div>

        <div class="flex">
            <DepartmentList :departments="departments" :expand="expanded"/>
        </div>
        
    </AdminLayout>
</template>