require("./bootstrap");

window.Vue = require("vue");
window.Event = new Vue();




const app_message = new Vue({
    el: "#app_message",
    data: {
        msg: 'lalala:',
        content: '',
        privateMsgs: [],
    },
    ready: function () {
        this.created();

    },

    created() {
        axios.get('/getMessages')
            .then(response => {
                console.log(response.data); // show if success
                app_message.privateMsgs = response.data;
                //app.users = response.data;  //we are putting data into our posts array
            })
            .catch(function (error) {
                console.log(error); // run if we have error
            });
    },
});
Vue.config.devtools = true;
