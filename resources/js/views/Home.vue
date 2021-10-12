<template>
  <div class="bg-gray-200">
    <client-header></client-header>
    <div v-if="loading" class="p-4 text-center text-gray-500">Loading...</div>
    <div v-else
      class="container mx-auto mt-4"
    >
      <div class="mt-4">
        <pagination :total="60"></pagination>
      </div>
      <div class="mt-4 grid gap-6 grid-cols-1 xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2">
        <div v-for="product in products"
          :key="product.id"
          class="p-4 flex flex-col space-y-2 bg-white border border-gray-200 rounded"
        >
          <img :src="product.images.length > 0 ? product.images[0].url : '/images/default.png'"
            :alt="product.name" 
            class="w-full h-3/4"
          />
          <h3 class="text-blue-700 text-xl font-semibold text-center truncate">{{ product.name }}</h3>
          <p class="text-gray-800 text-2xl text-center">$ {{ product.price }}</p>
          <div class="flex justify-end space-x-2">
            <form-button color="blue" class="w-full">
              Add to cart
            </form-button>
            <form-button color="gray" class="w-full">
              Show details
            </form-button>
          </div>
        </div>
      </div>
      <div class="py-4">
        <pagination :total="60"></pagination>
      </div>
    </div>
  </div>
</template>

<script>
import ClientHeader from './../components/ClientHeader.vue'
import FormButton from './../components/Button.vue'
import Pagination from './../components/Pagination.vue'
import axios from 'axios'

export default {
  data() {
    return {
      products: [],
      loading: false
    }
  },
  components: {
    ClientHeader,
    FormButton,
    Pagination
  },
  mounted() {
    this.loadProducts()
  },
  methods: {
    async loadProducts() {
      this.loading = true

      let { data } = await axios.get('/api/products')
      this.products = data.data

      this.loading = false
    }
  }
}
</script>