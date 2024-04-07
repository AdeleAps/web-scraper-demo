<script>
export default {
    methods: {
        callback: function (e) {
            this.$emit("click", e);
        },
    },
};
</script>
ƒ
<template>
    <button @click="callback($event)">delete</button>
</template>
