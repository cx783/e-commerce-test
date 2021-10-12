import "tailwindcss/tailwind.css"
import router from './router'
import store from './store'
import App from './App.vue'

import Vue from 'vue'
import axios from 'axios'

axios.defaults.withCredentials = true;

Vue.component('loader', require('./components/Loader.vue').default)

const app = new Vue({
  router,
  store,
  render: (h) => h(App)
}).$mount('#app')
