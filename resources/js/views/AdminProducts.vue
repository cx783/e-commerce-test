<template>
  <div class="p-4 bg-gray-200">
    <div class="flex justify-between space-x-2 bg-white p-4 rounded">
      <div class="flex-grow">
        <form-input id="name" placeholder="Search by name" v-model="productName"></form-input>
        <label class="inline-flex items-center ml-4">
          <input type="checkbox" class="form-checkbox border border-gray-300 rounded" v-model="onlyTrashed">
          <span class="ml-2">Show only trashed products</span>
        </label>
      </div>
      <form-button
        @click="applyFiltersButtonClicked"
      >
        Apply filters
      </form-button>
      <form-button
        @click="addNewProduct"
      >Add new</form-button>
    </div>
    <div class="mt-4">
      <div v-if="loadingProducts"
        class="p-4 text-center text-gray-400"
      >
        Loading...
      </div>
      <div v-else-if="products.length === 0"
        class="p-4 text-center text-gray-400"
      >
        Without records to show
      </div>
      <div v-else>
        <div class="font-semibold px-4 py-2 text-gray-700 w-full hidden md:flex">
          <div class="w-full">Name</div>
          <div class="w-full">Price</div>
          <div class="w-full">Created at</div>
          <div class="w-full"></div>
        </div>
        <div class="w-full bg-white p-4 mb-3 rounded shadow"
          v-for="product of products"
          :key="`product_${product.id}`"
        >
          <div class="p-4 flex flex-col md:flex-row">
            <div class="w-full">
              <div class="md:hidden text-gray-600">
                Name
              </div>
              <div class="text-gray-800">
                {{ product.name }}
              </div>
            </div>
            <div class="w-full mt-2 md:mt-0">
              <div class="md:hidden text-gray-600">
                Price
              </div>
              <div class="text-gray-800">
                {{ product.price }}
              </div>
            </div>
            <div class="w-full mt-2 md:mt-0">
              <div class="md:hidden text-gray-600">
                Created at
              </div>
              <div class="text-gray-800">
                {{ product.created_at }}
              </div>
            </div>
            <div 
              v-if="! product.deleted_at"
              class="w-full flex flex-col mt-4 md:mt-0 md:flex-row justify-end"
            >
              <form-button size="sm"
                color="yellow"
                class="w-full mb-2 md:w-auto md:mb-0 md:mr-2"
                @click="update(product)"
              >
                Edit
              </form-button>
              <confirmable-button size="sm"
                textConfirm="Confirm the deletion"
                textCancel="Cancel"
                color="red"
                class="w-full md:w-auto"
                @confirmed="deleteProduct(product)"
                :disabled="deleting.includes(product.id)"
              >
                <loader color="red-100" v-if="deleting.includes(product.id)"></loader>
                <span>Delete</span>
              </confirmable-button>
            </div>
            <div v-else class="w-full"></div>
          </div>
        </div>
        <div class="w-full">
          <pagination
            :total="total"
            :current-page="currentPage"
            @goTo="goTo"
          ></pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import FormButton from './../components/Button.vue'
import FormInput from './../components/Input.vue'
import ConfirmableButton from './../components/ConfirmableButton.vue'
import Pagination from './../components/Pagination.vue'

export default {
  data() {
    return {
      products: [],
      productName: '',
      onlyTrashed: false,
      loadingProducts: false,
      deleting: [],

      total: 0,
      currentPage: 1
    }
  },
  components: {
    FormButton,
    FormInput,
    ConfirmableButton,
    Pagination
  },
  mounted() {
    this.getProducts()
  },
  methods: {
    async getProducts(filters = {}) {
      this.loadingProducts = true

      try {
        const { data } = await axios.get('/api/products', {
          params: {
            ...filters,
            page: this.currentPage
          }
        })

        this.products = data.data
        this.total = data.total
        this.currentPage = data.current_page
      } catch (err) {

      } finally {
        this.loadingProducts = false
      }
    },
    addNewProduct() {
      this.$router.push('/admin/products/create')
    },
    applyFiltersButtonClicked() {
      this.currentPage = 1
      this.applyFilters()
    },
    applyFilters() {
      let filters = {
        name: this.productName
      }

      if (this.onlyTrashed) {
        filters.trashed = 1
      }

      this.getProducts(filters)
    },
    update(product) {
      this.$router.push(`/admin/products/${product.id}/edit`)
    },
    async deleteProduct(product) {
      this.deleting.push(product.id)

      try {
        await axios.delete(`/api/products/${product.id}`)
        this.getProducts()
      } catch (err) {

      } finally {
        this.deleting = this.deleting.filter(p => p.id !== product.id)
      }
    },
    goTo(position) {
      this.currentPage = position
      this.applyFilters()
    }
  }
}
</script>
