import "./bootstrap";
import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";
import Layout from "./components/Layout";
import router from "./routes/routes";
import store from "./store/index";
import axios from "axios";
import "material-design-icons-iconfont/dist/material-design-icons.css";
import moment from "moment";

Vue.use(Vuetify);
// Set Vue globally
window.Vue = Vue;

const vuetifyOptions = {
    icons: {
        iconfont: "md"
    }
};
Vue.prototype.moment = moment;
Vue.prototype.$axios = axios;
// Load Index
Vue.component("app-layout", Layout);
const app = new Vue({
    vuetify: new Vuetify(vuetifyOptions),
    el: "#app",
    router,
    store,
    /**
     * This is to set token to any request to server side.
     * @returns Resquest with configurations
     */
    created() {
        axios.interceptors.request.use(
            function(config) {
                if (store.state.user) {
                    const tokenType = store.state.user.data.token_type;
                    const token = store.state.user.data.access_token;
                    if (token)
                        config.headers.Authorization = `${tokenType} ${token}`;
                }
                return config;
            },
            function(error) {
                return Promise.reject(error);
            }
        );
    }
});
