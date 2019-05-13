require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'
import router from './router'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify, {
    theme: {
        primary: '#009688'
    }
})
Vue.use(require('vue-moment'));

Vue.component('home-component', require('./components/HomeComponent.vue').default)

window.eventBus = new Vue()

const app = new Vue({
    el: '#app',
    router
});