import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios'

Vue.use(VueAxios, axios);

axios.defaults.baseURL = process.env.VUE_APP_API_URL;
axios.defaults.headers.common['Accept'] = 'application/json';