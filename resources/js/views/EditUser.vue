<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto" v-if="user">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Edit user</p>
      <user-form
        :disabled="saving"
        :loading="saving"
        :initialValues="{name: user.name, email: user.email}"
        @cancel="cancel"
        @save="save"
        hide-password
      ></user-form>
    </div>
    <div v-else class="text-center text-gray-400">
      Loading...
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import UserForm from '../components/UserForm.vue'

export default {
  data() {
    return {
      saving: false,
      user: null
    }
  },
  components: {
    UserForm
  },
  async mounted() {
    let response = await axios.get(`/api/users/${this.$route.params.id}`)
    this.user = response.data
  },
  methods: {
    cancel() {
      this.$router.go(-1)
    },
    async save({ name, email}) {
      this.saving = true

      try {
        await axios.put(`/api/users/${this.user.id}`, {
          name,
          email
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