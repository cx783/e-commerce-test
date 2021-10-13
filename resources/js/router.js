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
import Checkout from'./views/Checkout.vue'
import ProductDetail from './views/ProductDetail.vue'

Vue.use(Router)

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/checkout',
    component: Checkout
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
        component: CreateUser,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'users/:id/edit',
        component: EditUser,
        meta: {
          requiresAuth: true
        }
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
        component: CreateProduct,
        meta: {
          requiresAuth: true
        }
      },
      {
        path: 'products/:id/edit',
        component: EditProduct,
        meta: {
          requiresAuth: true
        }
      },
    ],
    meta: {
      requiresAuth: true
    }
  },
  {
    path: '/:slug',
    component: ProductDetail
  }
]

const router = new Router({
  mode: 'history',
  routes
})

router.beforeEach(async (to, from, next) => {
  console.log(store.getters.isAuthenticated)
  if (to.meta?.requiresAuth) {
    if (! store.state.verifiedAuthentication) {
      await store.dispatch('verifyAuthentication')
    }
    if (! store.getters.isAuthenticated)
      return next('/login')
  }

  return next()
})

let idTimer = null

axios.interceptors.response.use(
  (response) => {
    return response;
  }, 
  (error) => {
    if (error.response?.status === 401 && error.config.url !== '/api/user') {
      router.replace('/login')
    }

    // By simplicity we use the validation of server, but can be validated the form with vuelidate or veevalidate in any component
    if (error.response?.status === 422 && typeof error.response?.data?.errors === 'object') {
      const messages = error.response.data.errors
      store.commit('setErrorMessages', Object.keys(messages).map(k => messages[k][0]))

      if (idTimer !== null) {
        clearTimeout(idTimer)
      }

      idTimer = setTimeout(() => {
        store.commit('setErrorMessages', [])
        idTimer = null
      }, 3000)
    }

    return Promise.reject(error)
  }
)

export default router
