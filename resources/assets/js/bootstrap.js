import Vue from 'vue';
// import VueRouter from 'vue-router';
import VueFlashMessage from 'vue-flash-message';
import axios from 'axios';
import VeeValidate from 'vee-validate';
import VueSession from 'vue-session';

window.Vue = Vue;

// Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueFlashMessage);
Vue.use(VueSession, { persist: true });

window.axios = axios;
window.axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest'
}
