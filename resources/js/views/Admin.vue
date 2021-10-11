<template>
  <div class="w-screen h-screen flex bg-gray-200">
    <div class="flex flex-col absolute z-10 left-0 top-0 transition-transform transform bg-gray-800 w-72 h-full flex-shrink-0 md:-translate-x-0 md:relative"
      :class="{
        '-translate-x-72': ! showMenu,
        '-translate-x-0': showMenu
      }"
    >
      <div class="flex justify-between items-center p-4 text-white">
        <h1 class="flex items-center space-x-2 text-2xl text-blue-100 font-semibold">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
          <span>E-Commerce</span>
        </h1>
        <svg class="w-6 h-6 md:hidden" @click="toggleMenu" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
          </path>
        </svg>
      </div>
      <ul class="flex-grow">
        <router-link
          to="/admin"
          v-slot="{ href, navigate, isExactActive  }"
          custom
        >
          <li>
            <a :href="href"
              class="flex items-center space-x-2 px-4 py-2 text-blue-100 text-lg hover:bg-blue-900"
              :class="{'font-semibold bg-blue-900': isExactActive }"
              @click="navigate"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
              <span class="text-sm">Dashboard</span>
            </a>
          </li>
        </router-link>
        <router-link
          to="/admin/users"
          v-slot="{ href, navigate, isExactActive  }"
          custom
        >
          <li>
            <a :href="href"
              class="flex items-center space-x-2 px-4 py-2 text-blue-100 text-lg hover:bg-blue-900"
              :class="{'font-semibold bg-blue-900': isExactActive }"
              @click="navigate"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
              <span class="text-sm">Users</span>
            </a>
          </li>
        </router-link>
        <router-link
          to="/admin/products"
          v-slot="{ href, navigate, isExactActive  }"
          custom
        >
          <li>
            <a :href="href"
              class="flex items-center space-x-2 px-4 py-2 text-blue-100 text-lg hover:bg-blue-900"
              :class="{'font-semibold bg-blue-900': isExactActive }"
              @click="navigate"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
              <span class="text-sm">Products</span>
            </a>
          </li>
        </router-link>
      </ul>
      <a href="#"
        class="flex space-x-2 px-4 py-2 bg-red-500 text-red-100"
        @click.prevent="logout"
      >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        <span class="text-sm">Logout</span>
      </a>
    </div>
    <div class="h-screen flex flex-col flex-grow transform">
      <div class="w-full md:hidden bg-white px-4 py-2">
        <svg @click="toggleMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
          </path>
        </svg>
      </div>
      <div class="flex-grow">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showMenu: false
    }
  },
  methods: {
    toggleMenu() {
      this.showMenu = ! this.showMenu
    },
    logout() {
      this.$store.dispatch('logout').then(() => this.$router.replace('/login'))
    }
  }
}
</script>
