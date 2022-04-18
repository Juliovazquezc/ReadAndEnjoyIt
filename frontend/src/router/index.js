import Vue from "vue";
import VueRouter from "vue-router";
import Login from "@/views/Login.vue";
import Books from "@/views/Books.vue";
import store from "../store";

Vue.use(VueRouter);

const routes = [
  {
    path: "/login",
    name: "Login",
    component: Login,
    meta: {
      auth: true,
    },
  },
  {
    path: "/books",
    name: "Books",
    component: Books,
    meta: {
      auth: true,
    },
  },
  {
    path: "*",
    redirect: "/login",
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach((to, from, next) => {
  store.dispatch("getAccessTokenFromLocalStorage");
  require('../utils/set-authorization-header');
  const isAuthenticated = store.getters.isAuthenticated;
  if (!isAuthenticated && to.name !== "Login") {
    next({ name: "Login" });
  }
  if (isAuthenticated && to.name == "Login") {
    next({ name: 'Books' });
  }
  next();
});

export default router;
