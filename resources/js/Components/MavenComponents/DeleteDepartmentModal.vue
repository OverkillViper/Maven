<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';

const visible = ref(false);

const props = defineProps({
    btnLabel   : String,
    btnIcon    : String,
    department : Number
})

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Delete Department" :style="{ width: '35rem' }" class="dialog">
        <div class="font-semibold">
            Are you sure you want to delete this page?
        </div>
        <div>
            Note: Deleting this department will also delete all its employees and its sub-department.
        </div>

        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Link :href="route('admin.department.delete', props.department)" method="post" as="button">
                <Button @click="visible = false" prefixIcon="delete" label="Delete" />
            </Link>
        </div>
    </Dialog>

</template>

