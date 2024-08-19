<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import Dialog from 'primevue/dialog';

const visible = ref(false);

const props = defineProps({
    btnLabel   : String,
    btnIcon    : String,
    structure  : Number
})

</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="visible = true" compact/>

    <Dialog v-model:visible="visible" modal header="Delete Page" :style="{ width: '35rem' }" class="dialog">
        <div class="font-semibold">
            Are you sure you want to delete this page?
        </div>
        <div>
            Note: Deleting this page will also delete all its child pages
        </div>

        <div class="flex justify-between mt-4">
            <Button @click="visible = false" prefixIcon="close" label="Cancel" />
            <Link :href="route('admin.structure.delete', props.structure)" method="post" as="button">
                <Button @click="visible = false" prefixIcon="delete" label="Delete" />
            </Link>
        </div>
    </Dialog>

</template>

