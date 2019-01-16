
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import UsersComponent from '../components/views/UsersComponent.vue'
import RolePermissionList from '../components/views/RolePermissionList.vue'

// TEMPORARY
import ExampleComponent from '../components/ExampleComponent.vue'


const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/home',
            name: 'home',
            component: ExampleComponent
        },
        {
            path: '/users',
            name: 'users',
            component: UsersComponent,
        },
        {
            path: '/role-permission-list',
            name: 'role-permission-list',
            component: RolePermissionList,
        },
    ],
})

export default router

