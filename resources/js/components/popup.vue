<script >
    export default {
        props: ['HandleClose'],

    }
</script>

<template>
    <div class="bg-black bg-opacity-50 position-fixed vw-100 vh-100 d">
        <div class="bg-white p-4 rounded shadow position-absolute top-50 start-50 translate-middle" style="height: auto; width: 30vw;">
            <slot/>
            <button @click="HandleClose" class="btn btn-primary">
                Close
            </button>
        </div>
    </div>

</template>

<style scoped>

</style>
