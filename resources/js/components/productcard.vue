<script setup lang="ts">
    const props = defineProps({
        product: Object,
        handleEdit: Function,
    })
</script>

<template>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title mb-0">{{product.name}}</h5>
                <span :class="product.status ? 'badge bg-success' : 'badge bg-secondary'">
                    {{ product.status ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <p class="card-text">{{product.description}}</p>
            <p class="card-text">{{product.code}}</p>
            <a @click="handleEdit(product)" class="btn btn-primary">Edit</a>
        </div>
    </div>
</template>

<style scoped>

</style>
