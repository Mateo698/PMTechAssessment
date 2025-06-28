<script setup>
import axios from 'axios'
import Popup from "@/components/popup.vue";
import {ref} from "vue";

const name = ref('');
const email = ref('');
const password = ref('');
const popUpTriggers = ref({
    invalidRegister: false,
    successfullRegister: false,
})

const handleRegister = async (event) => {
    event.preventDefault()

    try {
        await axios.post('/api/register', {
            name: name.value,
            email: email.value,
            password: password.value
        }).then(response => {
            console.log(response.status);
            if (response.status === 200) {
                popUpTriggers.value.successfullRegister = true;
                localStorage.setItem('name', name.value)
                localStorage.setItem('email', email.value)
                localStorage.setItem('token',response.data.token)
                console.log('Successfully registered');
            }
            if (response.status === 400) {
                popUpTriggers.value.invalidRegister = true;
                console.log('Error registering');
            }
        })
    }catch(err){
        console.log(err)
    }

}

const handleClose = (event) => {
    if(popUpTriggers.value.invalidRegister){
        popUpTriggers.value.invalidRegister = false;
    }

    if(popUpTriggers.value.successfullRegister){
        popUpTriggers.value.successfullRegister = false;
        window.location.href = '/home';
    }
    event.preventDefault()
}

const handleBack = (event) => {
    event.preventDefault()
    window.location.href = '/';
}
</script>
<template>
    <div id="page-container" class="d-flex justify-content-center align-items-center vh-100 bg-black" >
        <div id="login-form" class="p-4 bg-white rounded shadow">
            <form class="login-form d-flex flex-column gap-3" >
                <h3>Register</h3>
                <input id="name" placeholder="Name" type="text" class="form-control" v-model="name"/>
                <input type="email" id="email" name="email" placeholder="Email" class="form-control" v-model="email"/>
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" v-model="password"/>
                <button v-on:click="handleRegister" type="submit" class="btn btn-primary">Register</button>
                <button v-on:click="handleBack" type="submit" class="btn btn-secondary">Cancel</button>
            </form>

        </div>
        <Popup v-if="popUpTriggers.invalidRegister" :HandleClose="handleClose">
            <h1>Registration error</h1>
            <p> Please check that the email is correct</p>
        </Popup>
        <Popup v-if="popUpTriggers.successfullRegister" :HandleClose="handleClose">
            <h1>Successfully registered</h1>
            <p> Please check that the email is correct</p>
        </Popup>
    </div>

</template>


<style scoped>
h3 {
    color: #42b983;
    text-align: center;
}
</style>
