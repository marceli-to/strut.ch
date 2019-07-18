/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Require Vue
window.Vue = require('vue');

// Get VueRouter
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// Get VueAxios
import VueAxios from 'vue-axios';
import axios from 'axios';

Vue.use(VueAxios, axios);

// Posts
import PostIndexComponent from './components/posts/PostIndexComponent.vue';
import PostCreateComponent from './components/posts/PostCreateComponent.vue';
import PostEditComponent from './components/posts/PostEditComponent.vue';

import MasonryIndexComponent from './components/masonry/MasonryIndexComponent.vue';


// Dashboard
import DashboardComponent from './components/DashboardComponent.vue';

// Auth 
import LoginComponent from './components/auth/LoginComponent.vue';
import LogoutComponent from './components/auth/LogoutComponent.vue';

// App
import AppComponent from './components/AppComponent.vue';

import store from './store';

const routes = [
  {
    path: '/',
    redirect: { name: 'login' }
  },
  {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardComponent,
      meta: { requiresAuth: true },
  },
  {
      path: '/login',
      name: 'login',
      component: LoginComponent
  },
  {
      path: '/logout',
      name: 'logout',
      component: LogoutComponent
  },
  {
    name: 'posts',
    path: '/posts',
    component: PostIndexComponent,
    meta: { requiresAuth: true },
  },
  {
    name: 'post-create',
    path: '/post/create',
    component: PostCreateComponent,
    meta: { requiresAuth: true },
  },
  {
    name: 'post-edit',
    path: '/post/edit/:id',
    component: PostEditComponent,
    meta: { requiresAuth: true },
  },
  {
    name: 'masonry',
    path: '/masonry',
    component: MasonryIndexComponent,
    meta: { requiresAuth: true },
  },
];

const router = new VueRouter({ mode: 'history', routes: routes});

router.beforeEach((to, from, next) => {

  // check if the route requires authentication and user is not logged in
  if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
      // redirect to login page
      next({ name: 'login' });
      return;
  }

  // if logged in redirect to dashboard
  if(to.path === '/login' && store.state.isLoggedIn) {
      next({ name: 'dashboard' });
      return;
  }

  next();
});


// Intercept Axios 401 (Unauthorized)
Vue.axios.interceptors.response.use((response) => {
  return response;
}, (error) => {
  if (error.response.status == 401) {
    window.location.href = '/login';
  }
  return Promise.reject(error);
});

//const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');

const app = new Vue({
  components: { AppComponent },
  router
}).$mount('#app')