
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import UsersComponent from '../components/views/UsersComponent.vue'
import VueOne from '../components/views/VueOne.vue'

// TEMPORARY
import ExampleComponent from '../components/ExampleComponent.vue'


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/dashboard',
            name: 'dashboard',
            component: ExampleComponent
        },
        {
            path: '/users',
            name: 'users',
            component: UsersComponent,
        },
        {
            path: '/viewone',
            name: 'viewone',
            component: VueOne,
        },
    ],
})

export default router

