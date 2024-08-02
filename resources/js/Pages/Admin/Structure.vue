<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import StructureList from '@/Pages/Admin/StructureList.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const expanded = ref(false);

const pageForm = useForm({
    name:   '',
    href:   '',
    parent: null,
});

defineProps({
    breadcrumbs : Object
})

const addPage = () => {
    pageForm.post(route('admin.structure.create'), {
        onFinish: () => {
            pageForm.reset();
        },
    });
};

const toggleButton = () => {
    buttonIcon.value = buttonIcon.value === 'add' ? 'close' : 'add';
    buttonLabel.value = buttonLabel.value === 'Add page' ? 'Cancel' : 'Add page';
    showPageForm.value = !showPageForm.value;
    if(showPageForm.value) {
        pageForm.reset();
    }
}

const buttonIcon  = ref('add');
const buttonLabel = ref('Add page');
const showPageForm = ref(false);

</script>

<template>
    <AdminLayout pageTitle="Structure">
        <div class="border border-dashed p-4 rounded flex items-center font-medium justify-center bg-gray-50 border-gray-300 text-gray-500" v-if="breadcrumbs.length == 0">
            <span class="material-symbols-outlined me-4">warning</span>
            <div class="me-8">Site structure is empty</div>
        </div>
        
        <div class="flex items-center mt-4" v-if="breadcrumbs.length == 0">
            <Button :prefixIcon="buttonIcon" :label="buttonLabel" @click="toggleButton"/>
            <form @submit.prevent="addPage" class="inline-flex" v-if="showPageForm">
                <FormInputs v-model="pageForm.name" type="text" autocomplete="off" placeholder="Page name" class="ms-4"/>
                <FormInputs v-model="pageForm.href" type="text" autocomplete="off" placeholder="Page href" class="ms-4"/>
                <Button prefixIcon="add" label="Add" class="ms-4" type="submit"/>
            </form>
        </div>
        
        <div class="flex justify-end gap-x-4">
            <Button label="Expand All" prefixIcon="add" compact @click="expanded = true"/>
            <Button label="Collapse All" prefixIcon="remove" compact @click="expanded = false"/>
        </div>

        <StructureList :breadcrumbs="breadcrumbs" :expand="expanded"/>
    </AdminLayout>
</template>