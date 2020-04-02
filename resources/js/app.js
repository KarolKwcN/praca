require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();


Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('ban-component', require('./components/ban.vue').default);

import VModal from 'vue-js-modal';
Vue.use(VModal);
const app = new Vue({
    el: '#app',
});
