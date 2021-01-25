require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';

import router from './Router/index';
import App from './App.vue';
import store from './Store';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App }
});