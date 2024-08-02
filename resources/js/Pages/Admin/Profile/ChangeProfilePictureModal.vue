<script setup>
import Button from '@/Components/MavenComponents/Button.vue';
import { FwbModal } from 'flowbite-vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { FwbFileInput } from 'flowbite-vue';

const modalVisible = ref(false);

const props = defineProps({
    btnLabel : String,
    btnIcon  : String
})

const imagePreview = ref(null);

const previewImage = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      imagePreview.value = e.target.result;
    };
    reader.readAsDataURL(file);
  } else {
    imagePreview.value = null;
  }
};

const pictureForm = useForm({
    avatar : '',
});

function openModal() {
    modalVisible.value = true;
}

function closeModal() {
    modalVisible.value = false;
}

const changeProfilePicture = () => {
    pictureForm.post(route('admin.profile.avatar.update'), {
        onFinish: () => {
            pictureForm.reset();
            closeModal();
        },
    });
};
</script>

<template>
    <Button :label="props.btnLabel" :prefixIcon="props.btnIcon" @click="openModal"/>
    
    <fwb-modal v-if="modalVisible" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg font-semibold">
                Change profile avatar
            </div>
        </template>
        <template #body>
            <form @submit.prevent>
                <div class="text-gray-500 font-semibold mb-2">Choose profile picture</div>
                <div class="flex justify-between">
                    <div class="basis-1/2">
                        <fwb-file-input dropzone v-model="pictureForm.avatar" @change="previewImage"/>
                    </div>
                    
                    <div class="aspect-square w-64 border-2 rounded-lg border-dashed border-gray-300 overflow-hidden">
                        <img :src="imagePreview" v-if="imagePreview" alt="Image Preview" class="w-auto object-contain" />
                    </div>
                </div>
                
            </form>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <Button @click="closeModal" prefixIcon="close" label="Cancel" />
                <Button @click="changeProfilePicture" suffixIcon="save" label="Save" :class="{ 'opacity-75': pictureForm.processing }" :disabled="pictureForm.processing"/>
            </div>
        </template>
    </fwb-modal>
</template>