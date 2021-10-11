import Vue from 'vue'
import Router from 'vue-router'
import axios from 'axios'

import store from './store'

import Home from './views/Home.vue'
import Login from './views/Login.vue'
import Admin from './views/Admin.vue'
import AdminDashboard from './views/AdminDashboard.vue'
import AdminUsers from './views/AdminUsers.vue'
import CreateUser from './views/CreateUser.vue'
import AdminProducts from './views/AdminProducts.vue'
import EditUser from './views/EditUser.vue'
import CreateProduct from './views/CreateProduct.vue'
import EditProduct from './views/EditProduct.vue'

Vue.use(Router)

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/login',
    component: Login
  },
  {
    path: '/admin',
    component: Admin,
    children: [
      {
        path: '',
        component: AdminDashboard,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'users',
        component: AdminUsers,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'users/create',
        component: CreateUser
      },
      {
        path: 'users/:id/edit',
        component: EditUser
      },
      {
        path: 'products',
        component: AdminProducts,
        meta: {
          requiresAuth: true
        },
      },
      {
        path: 'products/create',
        component: CreateProduct
      },
      {
        path: 'products/:id/edit',
        component: EditProduct
      },
    ],
    meta: {
      requiresAuth: true
    }
  }
]

const router = new Router({
  mode: 'history',
  routes
})

router.beforeEach((to, from, next) => {
  console.log(store.getters.isAuthenticated)
  if (to.meta?.requiresAuth && ! store.getters.isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

axios.interceptors.response.use(
  (response) => {
    return response;
  }, 
  (error) => {
    if (error.response?.status === 401 && error.config.url !== '/api/user') {
      router.replace('/login')
    }

    return Promise.reject(error)
  }
)

export default router
