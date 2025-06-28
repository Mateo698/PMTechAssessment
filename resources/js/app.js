import { createApp } from 'vue'
import Welcome from "./components/welcome.vue";
import Login from "./components/login.vue";
import Register from "./components/register.vue";
import Home from "./components/home.vue";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'




// Get the component name from a data attribute
const appElement = document.getElementById('app')
const componentName = appElement.dataset.component

const components = {
    Welcome,
    Login,
    Register,
    Home
}

const app = createApp({
    components,
    template: `<div><component :is="componentName" /></div>`,
    data() {
        return {
            componentName: componentName
        }
    }
})

app.mount('#app')






/**import { createApp } from 'vue'
import Login from "@/components/login.vue";
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'

createApp(Login).mount('#app');**/
