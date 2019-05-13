import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import DashboardComponent from '../components/DashboardComponent.vue'
import UsersComponent from '../components/UsersComponent.vue'
import RolePermissionList from '../components/RolePermissionList.vue'
import ChatComponent from '../components/ChatComponent.vue'
import SettingsComponent from '../components/SettingsComponent.vue'
import GeneralSettings from '../components/settings/GeneralSettings.vue'
import UserProfile from '../components/settings/UserProfile.vue'
import UploadGallery from '../components/settings/UploadGallery.vue'

const router = new VueRouter({
    mode: 'history',
    routes: [{
            path: '/home',
            name: 'dashboard',
            component: DashboardComponent
        },
        {
            path: '/users',
            name: 'users',
            component: UsersComponent,
        },
        {
            path: '/roles-permissions',
            name: 'roles-permissions',
            component: RolePermissionList,
        },
        {
            path: '/chat',
            name: 'chat',
            component: ChatComponent,
        },
        {
            path: '/settings',
            name: 'settings',
            component: SettingsComponent,
            children: [{
                    path: 'profile',
                    name: 'userprofile',
                    component: UserProfile
                },
                {
                    path: 'upload-gallery',
                    name: 'upload-gallery',
                    component: UploadGallery
                },
                {
                    path: 'general',
                    name: 'general',
                    component: GeneralSettings
                },
            ]
        },
    ],
})

export default router