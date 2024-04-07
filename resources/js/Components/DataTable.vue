<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-responsive";

const props = defineProps({
    posts: Array,
});

DataTable.use(DataTablesCore);

const columns = [
    // {
    //     data: null,
    //     className: "dt-center editor-edit",
    //     defaultContent: '<button><i class="fa fa-pencil"/>hello</button>',
    //     orderable: false,
    // },
    {
        data: "title",
        title: "Title",
        render: (data, type, row) =>
            `<a href="${row.link}" target="_blank" rel="noopener noreferrer">${data}</a>`,
    },
    { data: "origin_date", title: "Date" },
];

const options = {
    responsive: true,
    scrollY: "50vh",
};
</script>

<style>
@import "datatables.net-dt";
</style>

<template>
    <div>
        <div class="bg-main-light p-6 lg:p-8">
            <DataTable
                :columns="columns"
                :data="props.posts"
                :options="options"
            >
            </DataTable>
        </div>
    </div>
</template>
