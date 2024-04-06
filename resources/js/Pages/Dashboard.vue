<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import { ref } from "vue";

const props = defineProps({
    posts: Array,
});

const posts = ref(props.posts);
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable :posts="posts" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
