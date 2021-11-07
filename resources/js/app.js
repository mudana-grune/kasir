import 'es6-promise/auto'
import axios from 'axios'
// import './bootstrap'
import Vue from 'vue'
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router'
import Index from './Index'
import auth from './auth'
import router from './router/index'
import vuetify from './vuetify';
import meta from 'vue-meta';
import store from './store';
// Set Vue globally
window.Vue = Vue

// Set Vue router
Vue.router = router
Vue.use(VueRouter)

// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api`
Vue.use(VueAuth, auth)
Vue.use(meta, {  refreshOnceOnNavigation: true })

// Load Index
Vue.component('index', Index)

const app = new Vue({
  vuetify,
  store,
  el: '#app',
  router
});
