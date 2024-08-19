<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    user : Object,
    link : String
})

const getImageUrl = (imagePath) => {
  return `/storage/${imagePath}`;
};

</script>

<template>
    <Link :href="route(link, user.id)" class="rounded-lg overflow-hidden shadow-sm border">
        <div class="bg-primary text-lg font-medium text-white text-center py-10">
            {{ user.first_name }} {{ user.last_name }}
        </div>
        <div class="bg-ternary flex justify-center h-10">
            <img :src="user.employee.avatar ? getImageUrl(user.employee.avatar) : '/images/user.webp'" alt="" srcset="" class="w-24 -mt-6 aspect-square absolute rounded-full shadow-md border">
        </div>
        <div class="bg-white p-5 pt-12">
            <div class="flex text-sm">
                <div class="font-semibold w-16">Email</div>
                <div class="font-medium">{{ user.email }}</div>
            </div>
            <div class="flex text-sm">
                <div class="font-semibold w-16">ID</div>
                <div class="font-medium">{{ user.employee.employee_id || 'None' }}</div>
            </div>
        </div>
    </Link>
</template>