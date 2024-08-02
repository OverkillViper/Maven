<script setup>
import CreateDepartmentModal from '@/Components/MavenComponents/CreateDepartmentModal.vue';
import DeleteDepartmentModal from '@/Components/MavenComponents/DeleteDepartmentModal.vue';
import EditDepartmentModal   from '@/Components/MavenComponents/EditDepartmentModal.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    departments    : Array,
    expand         : Boolean,
})

const childrenVisible = ref({});

const initializeVisibility = () => {
  props.departments.forEach(department => {
    childrenVisible.value[department.id] = props.expand;
    if (department.children && department.children.length > 0) {
      department.children.forEach(child => {
        childrenVisible.value[child.id] = props.expand;
      });
    }
  });
};

watch(
    () => props.expand,
    (newExpand) => {
        Object.keys(childrenVisible.value).forEach(key => {
            childrenVisible.value[key] = newExpand;
        });
    }, { immediate: true }
);

const toggleChildren = (id) => {
    childrenVisible.value[id] = !childrenVisible.value[id];
}

initializeVisibility();

</script>

<template>
    <ul>
        <li v-for="department in props.departments" :key="department.id">
            <div class="border flex items-center rounded-lg p-3 bg-accent mb-4 min-w-96 gap-x-2">
                <span v-if="department.children.length" @click="toggleChildren(department.id)" class="material-symbols-outlined text-gray-400 select-none cursor-default hover:text-gray-800 transition">
                    {{ childrenVisible[department.id] ? 'keyboard_arrow_down' : 'keyboard_arrow_right' }}
                </span>
                <div class="font-semibold flex-grow">{{ department.name }}</div>
                <CreateDepartmentModal btnIcon="add"    :parent="department.id"/>
                <DeleteDepartmentModal btnIcon="delete" :department="department.id"/>
                <EditDepartmentModal   btnIcon="edit"   :department="department"/>
                
            </div>
            <div v-if="childrenVisible[department.id]">
                <DepartmentList v-if="department.children.length" :departments="department.children" class="ms-8" :expand="expand"/>
            </div>
        </li>
    </ul>
</template>