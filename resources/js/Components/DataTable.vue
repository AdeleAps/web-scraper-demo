<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-responsive";

const props = defineProps({
    posts: Array,
});

DataTable.use(DataTablesCore);

const columns = [
    { data: "points", title: "Points" },
    { data: "title", title: "Title" },
    { data: "link", title: "Link" },
    { data: "origin_date", title: "Date" },
];

const options = {
    responsive: true,
};
</script>

<template>
    <div>
        <div style="min-height: 78vh" class="bg-main-light p-6 lg:p-8">
            <DataTable
                :columns="columns"
                :data="props.posts"
                class="display"
                :options="options"
            >
            </DataTable>
        </div>
    </div>
</template>
