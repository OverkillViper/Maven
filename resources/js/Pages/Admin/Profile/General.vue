<script setup>
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { useForm, usePage, Link } from '@inertiajs/vue3';
import ChangeProfilePictureModal from '@/Pages/Admin/Profile/ChangeProfilePictureModal.vue';

const $page = usePage();
// const { auth: { user } } = $page.props.value;

const getImageUrl = (imagePath) => {
  return `/storage/${imagePath}`;
};

const profileForm = useForm({
    'first_name'    : $page.props.auth.user.first_name,
    'last_name'     : $page.props.auth.user.last_name,
    'email'         : $page.props.auth.user.email,
});


const saveProfile = () => {
    profileForm.post(route('profile.general.update'), {
        onFinish: () => {
            profileForm.reset();
        },
    });
};

</script>

<template>
    <div class="flex w-2/3 mx-auto" >
        <div class="w-80 flex flex-col items-center 100 p-3">
            <img :src="$page.props.auth.user.employee.avatar ? getImageUrl($page.props.auth.user.employee.avatar) : '/images/user.webp'" alt="" srcset="" class="w-44 rounded-lg shadow-sm border">
            <div class="p-4">
                <ChangeProfilePictureModal btnLabel="Change avatar" btnIcon="image"/>
            </div>
        </div>
        <form @submit.prevent="saveProfile" class="w-full">
            <div class="w-full flex flex-col justify-center border p-6 rounded-xl">
                <div class="text-sm font-medium text-gray-500 mt-4 mb-1">
                    First name
                </div>
                <FormInputs type="text" placeholder="First name" v-model="profileForm.first_name"/>
                <div class="text-sm font-medium text-gray-500 mt-4 mb-1">
                    Last name
                </div>
                <FormInputs type="text" placeholder="Last name" v-model="profileForm.last_name"/>
                <div class="text-sm font-medium text-gray-500 mt-4 mb-1">
                    Email
                </div>
                <FormInputs type="text" placeholder="Email" v-model="profileForm.email" disabled/>
                <div class="flex justify-end gap-x-4 mt-4">
                    <Button label="Save" prefixIcon="save" type="submit"/>
                </div>
            </div>
        </form>
    </div>
    
    <div class="flex items-center justify-between border p-6 rounded-xl w-2/3 mx-auto mt-6">
        <div>
            <div class="font-semibold">Change password</div>
            <div class="mt-1 text-sm font-medium text-gray-500">A email will be sent to the registered email address containing the password reset link</div>
        </div>
        <div>
            <Link href="#" class="flex gap-x-2 item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition bg-primary text-white px-4 py-2">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm">lock_reset</span>
                </div>
                <div class="flex items-center text-sm">
                    Change Passoword
                </div>
            </Link>
        </div>
    </div>

    <div class="flex items-center justify-between border p-6 rounded-xl w-2/3 mx-auto mt-6">
        <div>
            <div class="font-semibold">Delete Account</div>
            <div class="mt-1 text-sm font-medium text-gray-500">Warning: This action cannot be undone</div>
        </div>
        <div>
            <Link href="#" class="flex gap-x-2 item-center justify-center uppercase rounded-md shadow-sm font-semibold hover:opacity-85 transition bg-red-500 text-white px-4 py-2">
                <div class="flex items-center">
                    <span class="material-symbols-outlined text-sm">delete</span>
                </div>
                <div class="flex items-center text-sm">
                    Delete Account
                </div>
            </Link>
        </div>
    </div>

</template>