<script setup>
import Dialog from 'primevue/dialog';
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const visible = ref(false);

const props = defineProps({
    btnLabel    : String,
    btnIcon     : String,
    designation : Number
})

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Delete Designation" :style="{ width: '35rem' }" class="dialog">
        <div class="font-semibold">
            Are you sure you want to delete this designation?
        </div>

        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Link :href="route('admin.designation.delete', props.designation)" method="post" as="button">
                <Button @click="visible = false" prefixIcon="delete" label="Delete" />
            </Link>
        </div>
    </Dialog>

</template>