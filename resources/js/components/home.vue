<script setup>
    import {onMounted} from "vue";
    import {requireAuth} from "@/utils/auth.js";
    import Topbar from "@/components/topbar.vue";
    import {ref} from "vue";
    import Productmodal from "@/components/productmodal.vue";


    onMounted(() => {
        requireAuth()
    })

    const createProductTrigger = ref(false)

    const triggerModal = () => {
        createProductTrigger.value = !createProductTrigger.value
        console.log(createProductTrigger.value)
    }
</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <Topbar :TriggerModal="triggerModal" />
        <div id="page-container" class="flex-grow-1 d-flex justify-content-center align-items-center" style="background-color: #4a5568">
            <Productmodal v-if="createProductTrigger"/>

        </div>
    </div>

</template>

<style scoped>

</style>
