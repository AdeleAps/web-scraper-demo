<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import NoPostsCard from "@/Components/NoPostsCard.vue";

const props = defineProps({
    posts: Array,
});

const hasPosts = props.posts.length > 0;
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <DataTable v-if="hasPosts" :posts="props.posts" />
                    <NoPostsCard v-else>
                        <template #content>
                            <h4 class="text-3xl font-extrabold mb-3">
                                Looks like there's no data.
                            </h4>
                            <div>
                                Tip: you need to run
                                <mark
                                    class="px-2 text-white bg-main-medium rounded dark:bg-blue-500"
                                    >sail artisan app:scrape</mark
                                >
                            </div>
                        </template>
                    </NoPostsCard>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
