<template>
  <div class="bg-white p-6 shadow-lg">
    <div class="flex justify-between items-center container mx-auto">
      <router-link
        to="/"
        v-slot="{ href, navigate  }"
        custom
      >
        <h1 class="text-lg font-semibold text-gray-700">
          <a :href="href"
            @click="navigate"
          >
            E-COMMERCE
          </a>
        </h1>
      </router-link>
      <button class="group text-gray-700 relative" @click="toggleShowCart">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
          </path>
        </svg>
        <span class="absolute flex items-center justify-center -top-4 -right-4 text-gray-50 text-xs w-5 h-5 rounded-full bg-gray-700">
          {{ totalItems }}
        </span>
        <!-- <cart
          class="w-80 h-72 absolute border border-gray-300 rounded right-0 top-8 overflow-hidden"
          :class="{'hidden': !showCart, 'block': showCart}"
        ></cart> -->
      </button>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import vClickOutside from 'v-click-outside'
import Cart from './Cart.vue'

export default {
  directives: {
    clickOutside: vClickOutside.directive
  },
  data() {
    return {
      showCart: false
    }
  },
  components: {
    Cart
  },
  computed: {
    ...mapGetters('cart', [
      'totalItems'
    ]),
  },
  methods: {
    toggleShowCart() {
      // this.showCart = ! this.showCart
      this.$router.push('/checkout')
    },
    hideCard() {
      this.showCart = false
    }
  }
}
</script>
