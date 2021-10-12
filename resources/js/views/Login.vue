<template>
   <div class="w-screen h-screen flex justify-center items-center bg-gray-200 p-4">
     <div class="bg-white shadow w-full md:w-72 p-6 rounded">
       <form
        class="w-full"
        @submit.prevent="login"
      >
         <p class="mb-4 text-gray-700 font-semibold text-center text-xl">Login</p>
         <div>
           <label for="email" class="block text-gray-500 text-base">Email</label>
           <input type="email"
            id="email"
            name="email"
            class="w-full block py-2 border-b-2 border-gray-300 text-gray-400 placeholder-gray-300 text-base focus:outline-none focus:text-gray-500 focus:border-gray-500"
            autocomplete="off"
            placeholder="example@mail.com"
            v-model="email"
          />
         </div>
         <div class="mt-6">
           <label for="password" class="block text-gray-500 text-base">Password</label>
           <input type="password"
            id="password"
            name="password"
            class="w-full block py-2 border-b-2 border-gray-300 text-gray-400 placeholder-gray-300 text-base focus:outline-none focus:text-gray-500 focus:border-gray-500"
            placeholder="******"
            v-model="password"
          />
         </div>
         <button type="submit"
          class="w-full flex items-center justify-center bg-blue-600 px-4 py-2 text-center text-blue-50 rounded mt-6 disabled:opacity-75"
          :disabled="isAuthenticating"
         >
          <loader color="white" v-if="isAuthenticating"></loader>
          <span>Entrar</span>
        </button>
       </form>
     </div>
   </div>
</template>

<script>
import axios from 'axios'
import { mapState } from 'vuex'

export default {
  data() {
    return {
      email: '',
      password: '',
      isLogin: true,
    }
  },
  computed: {
    ...mapState(['isAuthenticating'])
  },
  methods: {
    async login() {
      try {
        this.isLogin = true
        await this.$store.dispatch('login', {
          email: this.email,
          password: this.password
        })

        this.isLogin = false
        return this.$router.replace('/admin')
      } catch (err) {

      }
    }
  }
}
</script>