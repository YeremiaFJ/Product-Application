import Vue from 'vue';
import VueRouter from 'vue-router';
import VueFlashMessage from 'vue-flash-message';
import axios from 'axios';
import VeeValidate from 'vee-validate';

window.Vue = Vue;

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueFlashMessage);

window.PRODUCT_BASE_API = 'http://localhost/product-service-master/public/';
window.PRODUCT_API = window.PRODUCT_BASE_API + 'index.php/';

window.axios = axios;
window.axios.defaults.headers.common = {
  'X-Requested-With': 'XMLHttpRequest'
}
