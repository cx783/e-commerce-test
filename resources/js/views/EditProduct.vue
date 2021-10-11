<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto" v-if="product">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Edit product</p>
      <product-form
        :disabled="saving"
        :initialValues="{
          name: product.name,
          description: product.description,
          price: product.price,
          status: product.status
        }"
        @cancel="cancel"
        @save="save"
        hide-password
      ></product-form>
    </div>
    <div v-else class="text-center text-gray-400">
      Loading...
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ProductForm from '../components/ProductForm.vue'

export default {
  data() {
    return {
      saving: false,
      product: null
    }
  },
  components: {
    ProductForm
  },
  async mounted() {
    let response = await axios.get(`/api/products/${this.$route.params.id}`)
    this.product = response.data
  },
  methods: {
    cancel() {
      this.$router.go(-1)
    },
    async save({ name, description, price, status}) {
      this.saving = true

      try {
        await axios.put(`/api/products/${this.product.id}`, {
          name,
          description,
          price,
          status
        })

        this.$router.back()
      } catch (err) {
        console.log(err)
      } finally {
        this.saving = false
      }
    }
  }
}
</script>