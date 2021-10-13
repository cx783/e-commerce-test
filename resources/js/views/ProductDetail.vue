<template>
  <div class="">
    <client-header></client-header>
    <div class="container mx-auto p-4">
      <div v-if="loading"
        class="text-center text-gray-400"
      >
        Loading
      </div>
      <div v-else-if="product">
        <div class="flex flex-col space-y-2 md:space-y-0 md:flex-row  md:justify-between items-c">
          <h2 class="text-2xl">{{ product.name }}</h2>
          <p class="text-2xl text-blue-600 font-semibold">$ {{ product.price }}</p>
        </div>
        <div class="mt-6">
          <div v-if="product.images.length > 0"
            class="flex space-x-2 overflow-x-auto"
          >
            <img v-for="img of product.images"
              :key="img.id" 
              :src="img.url"
              :alt="product.name"
              class="w-72 h-auto"
            />
          </div>
          <img v-else src="/images/default.png" :alt="product.name" class="w-72 h-auto"/>
        </div>
        <p class="text-base mt-4">{{ product.description }}</p>
        <div class="mt-4">
          <form-button @click="addItem({ product })">Add to cart</form-button>
        </div>
      </div>
      <div v-else
        class="text-center text-gray-400"
      >
        Sorry, resource not found. <router-link to="/"><span class="text-blue-600">Go to Home</span></router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ClientHeader from './../components/ClientHeader.vue'
import FormButton from './../components/Button.vue'
import { mapMutations } from 'vuex'

export default {
  data() {
    return {
      product: null,
      loading: false
    }
  },
  components: {
    ClientHeader,
    FormButton
  },
  mounted() {
    this.loadProduct()
  },
  methods: {
    ...mapMutations('cart', [
      'addItem'
    ]),
    async loadProduct() {
      this.loading = true
      const slug = this.$route.params.slug
      try {
        let { data } = await axios.get(`/api/c/products/${slug}`)
        this.product = data
      } catch (err) {

      } finally {
        this.loading = false
      }
    }
  }
}
</script>
