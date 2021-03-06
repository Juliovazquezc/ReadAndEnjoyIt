import Vue from 'vue'
import Vuex from 'vuex'
import router from '../router';
import * as authService from '../services/auth-service';
import * as userService from '../services/user-service';
import { setTokenAxios } from "../utils/token";

Vue.use(Vuex)

const doCommonActions = (commit, data) => {
  commit('SET_TOKEN', data);
  localStorage.setItem('token', JSON.stringify(data));
  setTokenAxios();
  router.push('/books');
}

export default new Vuex.Store({
  state: {
    user: {
      email: '',
      name: '',
    },
    token: null,
  },
  getters: {
    isAuthenticated( state ) {
      return !!state.token;
    },
    getToken (state) {
      return state.token;
    } 
  },
  mutations: {
    SET_USER (state, payload) {
      state.user = payload;
    },
    SET_TOKEN (state, payload) {
      state.token = payload
    }
  },
  actions: {
    async login({ commit }, credentials) {
      const { data } = await authService.login(credentials);
      doCommonActions(commit, data);
    },
    async register({commit}, register) {
      const { data } = await authService.register(register);
      doCommonActions(commit, data);
    },
    async retrieveInfoUser({commit}) {
      const { data } = await userService.getUser();
      commit('SET_USER', data);
    },
    getAccessTokenFromLocalStorage({commit}) {
      const token = localStorage.getItem('token');
      commit('SET_TOKEN', JSON.parse(token));
    },
    logout({commit}) {
      commit('SET_TOKEN', null);
      commit('SET_USER', {
        email: '',
        name: ''
      });
      localStorage.removeItem('token');
      router.push('/login');
    },
    isAuthenticated({ getters }) {
      return !!getters.getToken;
    }
  },
  modules: {
  }
})
