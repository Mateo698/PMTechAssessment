<script setup lang="ts">
    import {ref} from "vue";
    import axios from "axios";
    const props = defineProps({
        HandleClose: Function,
    })

    const name = ref('')
    const description = ref('')
    const code = ref('')
    const status = ref('')
    const error = ref('')
    const handleCreate = async () => {
        try{
            await axios.post(`/api/products/new`, {
                name: name.value,
                description: description.value,
                code: code.value,
                status: status.value == 'active',
            },{
                headers: {
                    Authorization: `Bearer ` + localStorage.getItem('token')
                }
            }).then(response => {
                if(response.status == 200){
                    error.value = '';
                    window.location.reload()
                }
            })
        }catch(err){
            console.log(err)
            error.value = err.response.data.message
        }
    }
</script>

<template>
    <div class="bg-black bg-opacity-50 position-fixed vw-100 vh-100">
        <div class="d-flex flex-column bg-white p-4 rounded shadow position-absolute top-50 start-50 translate-middle gap-3" style="height: auto; width: 30vw;">
            <h1>Create new product</h1>
            <p v-if="error" class="text-danger">{{error}}</p>
            <input id="name" placeholder="Name" type="text" class="form-control" v-model="name"/>
            <textarea id="description" placeholder="Description" type="text" class="form-control" v-model="description"/>
            <input id="code" placeholder="Code" type="text" class="form-control" v-model="code"/>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="status1" name="status" value="active" v-model="status"/>
                <label class="form-check-label" for="status1">Active</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="status2" name="status" value="inactive"  v-model="status"/>
                <label class="form-check-label" for="status2">Inactive</label>
            </div>

            <div class="d-flex w-100 gap-3">
                <button @click="handleCreate" class="btn btn-primary flex-grow-1">
                    Create
                </button>
                <button @click="HandleClose" class="btn btn-danger flex-grow-1">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
