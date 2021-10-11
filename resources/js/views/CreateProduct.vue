<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Add new product</p>
      <div
        class="mb-4"
      >
        <p class="mb-4 text-base text-gray-800">Images</p>
        <uploader :url="url"
          no-confirm ref="uploaderRef"
          @uploaded="finishProccess"  
        ></uploader>
      </div>
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
import Uploader from './../components/Uploader.vue'


export default {
  data() {
    return {
      saving: false,
      url: ''
    }
  },
  components: {
    ProductForm,
    Uploader
  },
  methods: {
    cancel() {
      this.$router.go(-1)
    },
    async save({ name, description, price, status}) {
      this.saving = true

      try {
        const { data } = await axios.post('/api/products', {
          name,
          description,
          price,
          status
        })

        this.url = `/api/products/${data.id}/media`
        this.$nextTick(() => {
          this.$refs.uploaderRef.confirm();
        })
      } catch (err) {
        console.log(err)
      } finally {
        this.saving = false
      }
    },
    finishProccess() {
      this.$router.back()
    }
  }
}
</script>