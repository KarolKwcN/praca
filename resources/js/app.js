require("./bootstrap");

window.Vue = require("vue");
window.Event = new Vue();

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "adminuser-component",
    require("./components/AdminUser.vue").default
);
Vue.component(
    "adminrepairs-component",
    require("./components/AdminRepairs.vue").default
);

Vue.component(
    "adminmarka-component",
    require("./components/AdminMarka.vue").default
);

Vue.component(
    "admindevice-component",
    require("./components/AdminDevice.vue").default
);

Vue.component("adminrepairsdevice-component", require("./components/AdminRepairsDevice.vue").default);


Vue.component("serwisantcreaterepair-component", require("./components/SerwisantCreateRepair.vue").default);
Vue.component("serwisantedytuj-component", require("./components/SerwisantEdytuj.vue").default);

Vue.component(
    "serwisantcreatestep-component",
    require("./components/SerwisantCreateSteps.vue").default
);

Vue.component(
    "naprawa-component",
    require("./components/Naprawa.vue").default
);

Vue.component(
    "admincategory-component",
    require("./components/AdminCategory.vue").default
);

Vue.component(
    "comments-component",
    require("./components/Comments.vue").default
);


Vue.component("pagination", require("laravel-vue-pagination"));
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import Swal from "sweetalert2";
window.Swal = Swal;
window.Fire = new Vue();
import VModal from "vue-js-modal";
import VueRouter from "vue-router";
Vue.use(VueRouter);

Vue.use(VModal);
const app = new Vue({
    el: "#app"
});
Vue.config.devtools = true;
