<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Button from '@/Components/MavenComponents/Button.vue';
import CreateStructureModal from '@/Components/MavenComponents/CreateStructureModal.vue';
import DeleteStructureModal from '@/Components/MavenComponents/DeleteStructureModal.vue';

const pageForm = useForm({
    name:   '',
    href:   '',
    parent_id: null,
});

const showPageForm = ref({});

const buttonIcon  = ref({});

const addPage = (parent_id) => {
    pageForm.parent_id = parent_id;

    pageForm.post(route('admin.structure.create'), {
        onFinish: () => {
            pageForm.reset();
            showPageForm.value[parent_id] = false;
            buttonIcon.value = 'add';
        },
    });
};

const props = defineProps({
    breadcrumbs : Array,
    expand      : Boolean
})

const toggleButton = (breadcrumbID) => {
    buttonIcon.value[breadcrumbID] = buttonIcon.value[breadcrumbID] === 'close' ? 'add' : 'close';
    showPageForm.value[breadcrumbID] = !showPageForm.value[breadcrumbID];
    if(showPageForm.value) {
        pageForm.reset();
    }
}


const childrenVisible = ref({});

const initializeVisibility = () => {
  props.breadcrumbs.forEach(breadcrumb => {
    childrenVisible.value[breadcrumb.id] = props.expand;
    if (breadcrumb.children && breadcrumb.children.length > 0) {
        breadcrumb.children.forEach(child => {
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
    <ul class="tree">
        <li v-for="breadcrumb in props.breadcrumbs" :key="breadcrumb.id" class="mt-2">
            <div class="flex items-center h-10 ">
                <span class="material-symbols-outlined select-none cursor-default bg-primary rounded-sm text-white text-sm w-5 aspect-square flex justify-center items-center"
                    v-if="breadcrumb.children.length" @click="toggleChildren(breadcrumb.id)"
                >
                    {{ childrenVisible[breadcrumb.id] ? 'remove' : 'add' }}
                </span>
                <div class="min-w-40 ms-2">
                    <div class="text-sm font-semibold">{{ breadcrumb.name }}</div>
                    <div class="text-xs font-medium">{{ breadcrumb.href }}</div>
                </div>
                <div class="me-2">
                    <DeleteStructureModal btnIcon="delete" :structure="breadcrumb.id"/>
                </div>
                <div>
                    <CreateStructureModal btnIcon="add" :parent="breadcrumb.id"/>
                </div>
            </div>
            
            <div v-if="childrenVisible[breadcrumb.id]">
                <StructureList v-if="breadcrumb.children.length" :breadcrumbs="breadcrumb.children" class="mt-2" :expand="expand"/>
            </div>
        </li>
    </ul>
</template>

<style scoped>
.tree{
  --spacing : 1.5rem;
  --radius  : 10px;
}

.tree li{
  display      : block;
  position     : relative;
  padding-left : calc(2 * var(--spacing) - var(--radius) - 10px);
}

.tree ul{
  margin-left  : calc(var(--radius) - var(--spacing) + 25px);
  padding-left : 0;
}

.tree ul li{
  border-left : 2px solid #ddd;
}

.tree ul li:last-child{
  border-color : transparent;
}

.tree ul li::before{
  content      : '';
  display      : block;
  position     : absolute;
  top          : calc(var(--spacing) / -1.8);
  left         : -2px;
  width        : calc(var(--spacing) + 2px);
  height       : calc(var(--spacing) + 8px);
  border       : solid #ddd;
  border-width : 0 0 2px 2px;
}
</style>