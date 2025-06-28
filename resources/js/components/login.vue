<template>
    <div id="page-container" class="d-flex justify-content-center align-items-center vh-100 bg-black">
        <div id="login-form" class="p-4 bg-white rounded shadow">
            <form class="login-form d-flex flex-column gap-3">
                <h1>Login</h1>
                <input type="email" id="email" name="email" placeholder="Email" class="form-control" v-model="email" />
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" v-model="password" />
                <button v-on:click="handleLogin" type="submit" class="btn btn-primary">Login</button>
                <button v-on:click="handleRegister" class="btn btn-secondary">Register</button>
            </form>
        </div>
    </div>
</template>
<script setup>
    import {ref} from "vue";
    import axios from "axios";

    const email = ref('');
    const password = ref('');
    const handleLogin = async (event) => {
        event.preventDefault()
        await axios.post('/api/login', {
            email: email.value,
            password: password.value
        }).then((response) => {
            console.log(response.data);
        })
    }
    const handleRegister = (event) => {
        event.preventDefault()
        window.location.href = '/register'
    }



</script>
<style scoped>
h1 {
    color: #42b983;
    text-align: center;
}
</style>
