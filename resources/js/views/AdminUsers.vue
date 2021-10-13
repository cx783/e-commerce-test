<template>
  <div class="p-4 bg-gray-200">
    <div class="flex flex-col md:flex-row justify-between space-y-2 md:space-y-0 md:space-x-2 bg-white p-4 rounded">
      <div class="flex-grow">
        <form-input id="name" class="w-full md:w-auto" placeholder="Search by name" v-model="userName"></form-input>
        <label class="inline-flex items-center md:ml-4">
          <input type="checkbox" class="form-checkbox border border-gray-300 rounded" v-model="onlyTrashed">
          <span class="ml-2">Show only trashed users</span>
        </label>
      </div>
      <form-button
        @click="applyFiltersButtonClicked"
      >
        Apply filters
      </form-button>
      <form-button
        @click="addNewUser"
      >Add new</form-button>
    </div>
    <div class="mt-4">
      <div v-if="loadingUsers"
        class="p-4 text-center text-gray-400"
      >
        Loading...
      </div>
      <div v-else-if="users.length === 0"
        class="p-4 text-center text-gray-400"
      >
        Without records to show
      </div>
      <div v-else class="">
        <div class="font-semibold py-2 text-gray-700 w-full hidden md:flex">
          <div class="w-full">Full name</div>
          <div class="w-full">Email</div>
          <div class="w-full">Created at</div>
          <div class="w-full"></div>
        </div>
        <div class="w-full bg-white p-4 mb-3 rounded shadow"
          v-for="user of users"
          :key="`user_${user.id}`"
        >
          <div class="p-4 flex flex-col md:flex-row">
            <div class="w-full">
              <div class="md:hidden text-gray-600">
                Full Name
              </div>
              <div class="text-gray-800">
                {{ user.name }}
              </div>
            </div>
            <div class="w-full mt-2 md:mt-0">
              <div class="md:hidden text-gray-600">
                Email
              </div>
              <div class="text-gray-800">
                {{ user.email }}
              </div>
            </div>
            <div class="w-full mt-2 md:mt-0">
              <div class="md:hidden text-gray-600">
                Created at
              </div>
              <div class="text-gray-800">
                {{ user.created_at }}
              </div>
            </div>
            <div 
              v-if="! user.deleted_at"
              class="w-full flex flex-col mt-4 md:mt-0 md:flex-row justify-end"
            >
              <form-button size="sm"
                color="yellow"
                class="w-full mb-2 md:w-auto md:mb-0 md:mr-2"
                @click="update(user)"
              >
                Edit
              </form-button>
              <confirmable-button size="sm"
                textConfirm="Confirm the deletion"
                textCancel="Cancel"
                color="red"
                class="w-full md:w-auto"
                :button-class="['w-full', 'md:w-auto']"
                @confirmed="deleteUser(user)"
                :disabled="deleting.includes(user.id)"
              >
                <loader color="red-100" v-if="deleting.includes(user.id)"></loader>
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
import FormInput from './../components/Input.vue'
import FormButton from './../components/Button.vue'
import ConfirmableButton from './../components/ConfirmableButton.vue'
import Pagination from './../components/Pagination.vue'

export default {
  data() {
    return {
      users: [],
      userName: '',
      onlyTrashed: false,
      loadingUsers: false,
      deleting: [],

      total: 0,
      currentPage: 1
    }
  },
  components: {
    FormInput,
    FormButton,
    ConfirmableButton,
    Pagination
  },
  mounted() {
    this.loadUsers();
  },
  methods: {
    async loadUsers(filters = {}) {
      this.loadingUsers = true

      try {
        const response = await axios.get('/api/users', {
          params: {
            ...filters,
            page: this.currentPage
          }
        })

        this.users = response.data.data
        this.total = response.data.total
        this.currentPage = response.data.current_page
      } catch (err) {
        
      } finally {
        this.loadingUsers = false
      }
    },
    addNewUser() {
      this.$router.push('/admin/users/create')
    },
    update(user) {
      this.$router.push(`/admin/users/${user.id}/edit`)
    },
    async deleteUser(user) {
      this.deleting.push(user.id)

      try {
        await axios.delete(`/api/users/${user.id}`)
        this.loadUsers()
      } catch (err) {

      } finally {
        this.deleting = this.deleting.filter(u => u.id !== user.id)
      }
    },
    applyFiltersButtonClicked() {
      this.currentPage = 1
      this.applyFilters()
    },
    applyFilters() {
      let filters = {
        name: this.userName
      }

      if (this.onlyTrashed) {
        filters.trashed = 1
      }

      this.loadUsers(filters)
    },
    goTo(position) {
      this.currentPage = position
      this.applyFilters()
    }
  }
}
</script>
