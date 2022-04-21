import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify'
import i18n from './i18n'
require('./axios');
import { setTokenAxios } from "./utils/token";

Vue.config.productionTip = false
setTokenAxios();

new Vue({
  router,
  store,
  vuetify,
  i18n,
  render: h => h(App)
}).$mount('#app')
