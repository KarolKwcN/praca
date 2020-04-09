require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('adminuser-component', require('./components/AdminUser.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));


import Swal from 'sweetalert2';
window.Swal = Swal;
window.Fire = new Vue();
import VModal from 'vue-js-modal';
Vue.use(VModal);
const app = new Vue({
    el: '#app',
});
