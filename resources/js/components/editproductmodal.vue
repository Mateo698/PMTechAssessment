<script setup lang="ts">
import {ref} from "vue";
import axios from "axios";
const props = defineProps({
    HandleClose: Function,
    product: Object,
})

const name = ref(props.product.name)
const description = ref(props.product.description)
const code = ref(props.product.code)
const status = ref(props.product.status == 1 ? 'active' : 'inactive');
const error = ref('')

const handleEdit = async () => {
    console.log(name.value, description.value, code.value, status.value)
    try{
        await axios.put(`/api/products/${props.product.id}`, {
            name: name.value,
            description: description.value,
            code: code.value,
            status: status.value == 'active',
        },{
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
            }
        }).then( res => {
            if(res.status == 200){
                console.log(res.data)
                window.location.reload()
            }
        })
    }catch(error){
        console.log(error)
    }

}
</script>

<template>
    <div class="bg-black bg-opacity-50 position-fixed vw-100 vh-100">
        <div class="d-flex flex-column bg-white p-4 rounded shadow position-absolute top-50 start-50 translate-middle gap-3" style="height: auto; width: 30vw;">
            <h1>Edit product</h1>
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
                <button @click="handleEdit" class="btn btn-primary flex-grow-1">
                    Edit
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
