<template>
    <div id="page-container" class="d-flex justify-content-center align-items-center vh-100 bg-black">
        <div id="login-form" class="p-4 bg-white rounded shadow">
            <form class="login-form d-flex flex-column gap-3">
                <h1>Login</h1>
                <input type="email" id="email" name="email" placeholder="Email" class="form-control" v-model="email" />
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" v-model="password" />
                <button @click="handleLogin" type="submit" class="btn btn-primary">Login</button>
                <button @click="handleRegister" class="btn btn-secondary">Register</button>
            </form>
        </div>
        <Popup v-if="errorPopup" :HandleClose="closePopup">
            <h1>Error</h1>
            <p>Please check your credentials</p>
        </Popup>
    </div>
</template>
<script setup>
    import {ref} from "vue";
    import axios from "axios";
    import Popup from "@/components/popup.vue";

    const email = ref('');
    const password = ref('');
    const errorPopup = ref(false);
    const handleLogin = async (event) => {
        event.preventDefault()
        try {
            await axios.post('/api/login', {
                email: email.value,
                password: password.value
            }).then((response) => {
                console.log(response)
                if(response.status === 200) {
                    localStorage.setItem('email', email.value)
                    localStorage.setItem('token',response.data.authorization.token)
                    window.location.href= "/home";
                }

                if(response.status === 'error' || response.status === 400) {
                    errorPopup.value = true;
                }
            })
        }catch(error) {
            errorPopup.value = true;
        }

    }
    const handleRegister = (event) => {
        event.preventDefault()
        window.location.href = '/register'
    }

    const closePopup = () => {
        errorPopup.value = !errorPopup.value;
    }

</script>
<style scoped>
h1 {
    color: #42b983;
    text-align: center;
}
</style>
