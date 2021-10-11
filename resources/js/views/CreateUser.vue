<template>
  <div class="p-4 md:mt-12">
    <div class="bg-white rounded-lg p-6 lg:w-2/3 lg:mx-auto">
      <p class="text-xl text-gray-700 pb-4 mb-4 border-b border-gray-300">Add new user</p>
      <user-form
        :disabled="saving"
        @cancel="cancel"
        @save="save"
      ></user-form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import UserForm from '../components/UserForm.vue'

export default {
  data() {
    return {
      saving: false
    }
  },
  components: {
    UserForm
  },
  methods: {
    cancel() {
      this.$router.go(-1)
    },
    async save({ name, email, password, password_confirmation}) {
      this.saving = true

      try {
        await axios.post('/api/users', {
          name,
          email,
          password,
          password_confirmation
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