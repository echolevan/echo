
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router'
import routes from './routes.js'
import iView from 'iview';
import Vuex from 'vuex'

Vue.use(VueRouter);
Vue.use(iView);
Vue.use(Vuex);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));

const router = new VueRouter({
    routes
});


router.beforeEach((to,from,next) => {
    iView.LoadingBar.start();
    next()
});


router.afterEach(() => {
    iView.LoadingBar.finish();
});



const  user_store = new Vuex.Store({
    state:{
        login:[],
    },
    mutations:{

    }
});

const app = new Vue({
    router,
    store:user_store,
}).$mount('#app');