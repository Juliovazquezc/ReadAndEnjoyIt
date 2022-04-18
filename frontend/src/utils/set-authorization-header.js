import Vue from 'vue';
import store from '../store';
store.dispatch("getAccessTokenFromLocalStorage");

const formatToken = (objectToken) => {
    return `${objectToken.token_type} ${objectToken.access_token}`;
} 

const isAuthenticated = store.getters.isAuthenticated;
if (isAuthenticated) {
    const token = store.getters.getToken;
    Vue.axios.defaults.headers.common['Authorization'] = formatToken(token);
}


