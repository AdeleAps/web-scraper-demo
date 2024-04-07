<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-responsive";
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    posts: Array,
});

const dataTableRef = ref(null);

DataTable.use(DataTablesCore);

const deleteRow = (rowId) => {
    router.delete(route("delete", rowId));
};

// This is clunky, but the DataTable disables Vue's events so I have to attach event listeners manually and leverage
// data attributes.

onMounted(() => {
    dataTableRef.value.$el.addEventListener("click", (event) => {
        const target = event.target;
        if (target.classList.contains("fa-trash")) {
            const rowId = target.getAttribute("data-row-id");
            deleteRow(rowId);
        }
    });
});

const columns = [
    {
        data: null,
        render: (data, type, row) =>
            `<button aria-label="Delete"><i class="fa fa-trash fa-lg" data-row-id="${row.id}"/></button>`,
        orderable: false,
    },
    { data: "points", title: "Points", className: "dt-body-center" },
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
                ref="dataTableRef"
                class="stripe"
                :columns="columns"
                :data="props.posts"
                :options="options"
            />
        </div>
    </div>
</template>
