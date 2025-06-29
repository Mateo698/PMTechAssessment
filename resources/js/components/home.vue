<script setup>
    import {onMounted} from "vue";
    import {requireAuth} from "@/utils/auth.js";
    import Topbar from "@/components/topbar.vue";
    import Productcard from "@/components/productcard.vue";
    import {ref} from "vue";
    import Productmodal from "@/components/productmodal.vue";
    import axios from "axios";
    import Editproductmodal from "@/components/editproductmodal.vue";
    import {watchEffect} from "vue";

    async function prefetch() {
        try {
            const res = await axios.get('/api/products',{
                headers: {
                    Authorization: `Bearer ` + localStorage.getItem('token')
                }
            })
            products.value = res.data
            filteredProducts.value = res.data
        } catch (error) {
            console.error(error)
        }
    }

    onMounted(() => {
        prefetch()
        requireAuth()
    })

    const createProductTrigger = ref(false)
    const editProductTrigger = ref(false)
    const products = ref([])
    const editProduct = ref({})
    const filteredProducts = ref([])
    const searchQuery = ref('')
    const statusFilter = ref('all')

    const filterProducts = () => {
        filteredProducts.value = products.value.filter(product => {
            const matchesSearch = product.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                                  product.description.toLowerCase().includes(searchQuery.value.toLowerCase());
            const matchesStatus = statusFilter.value === 'all' ||
                                  (statusFilter.value === 'active' && product.status) ||
                                  (statusFilter.value === 'inactive' && !product.status);
            return matchesSearch && matchesStatus;
        });
    };

    watchEffect(() => {
        filterProducts();
    });
    const triggerModal = () => {
        createProductTrigger.value = !createProductTrigger.value
    }

    const triggerEditModal = (product) => {
        if(editProductTrigger.value) {
            editProductTrigger.value = false
            editProduct.value = {}
        }else{
            editProductTrigger.value = true
            editProduct.value = product
        }


    }

</script>

<template>
    <div class="d-flex flex-column min-vh-100">
        <Topbar :TriggerModal="triggerModal" />
        <div id="filters" class="d-flex flex-row w-100 justify-content-start align-items-center p-3 gap-4" style="background-color: #2d3748">
            <input type="text" class="form-control w-50" placeholder="Search products..." v-model="searchQuery"/>
            <div class="d-flex flex-row align-items-center justify-content-center gap-2">
                <label class="form-label
                me-2 text-light">Status:</label>
                <select class="form-select" v-model="statusFilter">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

        </div>
        <div id="page-container" class="flex-grow-1 d-flex justify-content-start align-items-start p-4 gap-3" style="background-color: #4a5568">
            <Productcard v-for="(product, index) in filteredProducts" :key="index" :product="product" :handleEdit="triggerEditModal" />
        </div>
        <Productmodal v-if="createProductTrigger" :HandleClose="triggerModal" />
        <Editproductmodal v-if="editProductTrigger" :HandleClose="triggerEditModal" :product="editProduct" />
    </div>

</template>

<style scoped>

</style>
