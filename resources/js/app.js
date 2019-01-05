
require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'
import router from './router'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)


Vue.component('example-component', require('./components/ExampleComponent.vue').default)
Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default)


window.eventBus = new Vue()


const app = new Vue({
    el: '#app',
    router
});
