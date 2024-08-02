<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import FormInputs from '@/Components/MavenComponents/FormInputs.vue';
import Button from '@/Components/MavenComponents/Button.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('auth.login.post'), {
        onFinish: () => form.reset('password'),
    });
};

</script>

<template>
    <AuthLayout>
        <Head title="Log in" />
        
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        
        <div class="p-8">
            <Link href="/" class="flex items-center">
                <img :src="'/images/logo_3.png'" alt="logo" class="w-8 aspect-square">
                <div class="ms-3 uppercase font-semibold text-lg">maven</div>
            </Link>

            <div class="text-xl font-bold mt-6">Sign In</div>

            <form @submit.prevent="submit" class="mt-6 flex flex-col gap-y-3">
                <FormInputs type="text" placeholder="Email" icon="assignment_ind" v-model="form.email"/>
                <FormInputs type="password" placeholder="Password" icon="password" v-model="form.password"/>

                <div class="flex justify-between">
                    <div class="flex items-center">
                        <Checkbox name="remember" id="remember" v-model:checked="form.remember" class="focus:ring-transparent"/>
                        <label for="remember" class="select-none ms-2 text-sm text-gray-600 font-medium">Keep me signed in</label>
                    </div>

                    <Link :href="route('password.request')" class="text-sm font-medium transition hover:underline">Forgot password?</Link>
                </div>

                <div class="flex justify-end mt-6">
                    <Button type="submit" href="#" label="login" suffixIcon="chevron_right" :class="{ 'opacity-50': form.processing }" :disabled="form.processing"/>
                </div>
                
            </form>
        </div>
        <div class="rounded-lg p-4 bg-primary text-sm font-medium text-white flex flex-col justify-center items-center">
            <div>Don't have an account?</div>
            <div class="mt-2">
                <Link :href="route('auth.register')">
                    <Button href="#" type="submit" label="register" suffixIcon="chevron_right" lightTheme/>
                </Link>
            </div>
        </div>

        <!-- <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
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
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form> -->
    </AuthLayout>
</template>
