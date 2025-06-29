<script setup lang="ts">
    const props = defineProps({
        TriggerModal: Function
    })

    const handleLogOut = () => {
        localStorage.clear()
        window.location.href = '/'
    }
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-black p-2">
        <a class="navbar-brand text-light" href="#">Process Maker Tech Assess</a>
        <div class="ms-auto">
            <button class="btn btn-primary m-1" type="button" v-on:click="TriggerModal">New Product</button>
            <button class="btn btn-danger" type="button" v-on:click="handleLogOut">Log Out</button>
        </div>
    </nav>
</template>

<style scoped>

</style>
