<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Add new product</p>
      <product-form
        :disabled="saving"
        @cancel="cancel"
        @save="save"
      ></product-form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import ProductForm from '../components/ProductForm.vue'

export default {
  data() {
    return {
      saving: false
    }
  },
  components: {
    ProductForm
  },
  methods: {
    cancel() {
      this.$router.go(-1)
    },
    async save({ name, description, price, status}) {
      this.saving = true

      try {
        await axios.post('/api/products', {
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