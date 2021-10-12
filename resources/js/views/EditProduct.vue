<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto" v-if="product">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Edit product</p>
      <div
        class="mb-4"
      >
        <p class="mb-4 text-base text-gray-800">Images</p>
        <div class="flex flex-wrap space-x-2 mb-2">
          <div 
            v-for="image in product.images"
            :key="`img_${image.id}`"
            class="flex flex-col items-center"
          >
            <img
              :src="image.url"
              class="w-32 h-24 rounded overflow-hidden"
            />
            <confirmable-button
              text="Delete"
              size="sm"
              class="mt-2"
              color="red"
              @confirmed="remove(image)"
              :disabled="imagesRemoving.includes(image.id)"
            ></confirmable-button>
          </div>
        </div>
        <uploader 
          :url="`/api/products/${product.id}/media`"
          @uploaded="refresh"
        ></uploader>
      </div>
      <product-form
        :disabled="saving"
        :loading="saving"
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
import Uploader from './../components/Uploader.vue'
import ConfirmableButton from './../components/ConfirmableButton.vue'

export default {
  data() {
    return {
      saving: false,
      product: null,
      imagesRemoving: []
    }
  },
  components: {
    ProductForm,
    Uploader,
    ConfirmableButton
  },
  async mounted() {
    this.refresh()
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
    },
    async refresh() {
      let response = await axios.get(`/api/products/${this.$route.params.id}`)
      this.product = response.data
    },
    async remove(image) {
      this.imagesRemoving.push(image.id)
      await axios.delete(`/api/products/${this.product.id}/media/${image.id}`)
      this.refresh();
    }
  }
}
</script>