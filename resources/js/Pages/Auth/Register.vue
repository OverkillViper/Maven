<script setup>
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('auth.register.post'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <AuthLayout>
        <Head title="Register" />
        <div class="rounded-lg p-4 bg-primary text-sm font-medium text-white flex flex-col justify-center items-center">
            <div>Already have an account?</div>
            <div class="mt-2">
                <Link :href="route('auth.login')">
                    <Button label="login" preffixIcon="chevron_right" lightTheme/>
                </Link>
            </div>
        </div>
        <div class="p-8">
            <Link href="/" class="flex items-center">
                <img :src="'/images/logo_3.png'" alt="logo" class="w-8 aspect-square">
                <div class="ms-3 uppercase font-semibold text-lg">maven</div>
            </Link>

            <div class="text-xl font-bold mt-6">Sign up</div>

            <form @submit.prevent="submit" class="mt-6 flex flex-col gap-y-3">
                <div class="flex">
                    <FormInputs type="text"     placeholder="First name" icon="person" v-model="form.first_name"/>
                    <FormInputs type="text"     placeholder="Last name"                v-model="form.last_name"/>
                </div>
                
                <FormInputs type="text"     placeholder="Email" icon="email" v-model="form.email"/>
                <FormInputs type="password" placeholder="Password" icon="password" v-model="form.password"/>
                <FormInputs type="password" placeholder="Confirm password" icon="password_2" v-model="form.password_confirmation"/>

                <div class="flex justify-end mt-6">
                    <Button label="Register" suffixIcon="chevron_right" type="submit" :class="{ 'opacity-50': form.processing }" :disabled="form.processing"/>
                </div>
                
            </form>
        </div>
        
        <!-- <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form> -->
    </AuthLayout>
</template>
