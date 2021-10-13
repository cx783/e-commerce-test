<template>
  <div class="p-4">
    <div class="flex flex-col space-y-4 lg:flex-row lg:space-y-0 lg:space-x-4">
      <div class="w-full rounded-lg border border-gray-300 bg-white p-4">
        <div class="flex justify-center font-semibold text-4xl text-gray-800">
          <loader v-if="loading"></loader>
          <span v-else>{{ statistics.users }}</span>
        </div>
        <div class="text-center text-lg text-gray-500">Users</div>
      </div>
      <div class="w-full rounded-lg border border-gray-300 bg-white p-4">
        <div class="flex justify-center font-semibold text-4xl text-gray-800">
          <loader v-if="loading"></loader>
          <span v-else>{{ statistics.products }}</span>
        </div>
        <div class="text-center text-lg text-gray-500">Products</div>
      </div>
      <div class="w-full rounded-lg border border-gray-300 bg-white p-4">
        <div class="flex justify-center font-semibold text-4xl text-gray-800">
          <loader v-if="loading"></loader>
          <span v-else>{{ statistics.orders }}</span>
        </div>
        <div class="text-center text-lg text-gray-500">Orders</div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      statistics: {
        users: 0,
        products: 0,
        orders: 0
      },
      loading: false
    }
  },
  async mounted() {
    this.loading = true
    try {
      let { data } = await axios.get('/api/statistics')
      this.statistics = data
    } catch (err) {

    } finally {
      this.loading = false
    }

  }
}
</script>
