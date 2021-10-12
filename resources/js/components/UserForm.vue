<template>
  <div>
    <div v-if="! hideName" class="flex flex-col items-center md:flex-row">
      <label for="name" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Full name
      </label>
      <form-input v-model="name" class="w-full" id="name" placeholder="John Doe"></form-input>
    </div>
    <div  v-if="! hideEmail" class="flex flex-col items-center md:flex-row mt-4">
      <label for="email" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Email
      </label>
      <form-input v-model="email" type="email" class="w-full" id="email" placeholder="john@mail.com"></form-input>
    </div>
    <div v-if="! hidePassword" class="flex flex-col items-center md:flex-row mt-4">
      <label for="password" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Password
      </label>
      <form-input v-model="password" type="password" class="w-full" id="password" placeholder="******"></form-input>
    </div>
    <div v-if="! hidePassword" class="flex flex-col items-center md:flex-row mt-4">
      <label for="password_confirmation" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Password confirmation
      </label>
      <form-input v-model="password_confirmation" type="password" class="w-full" id="password" placeholder="******"></form-input>
    </div>
    <div class="mt-4 lg:text-right">
      <form-button class="w-full lg:w-auto inline-block"
        :disabled="disabled"
        @click="save"
      >
        <loader color="blue-100" v-if="loading"></loader>
        <span>Guardar</span>
      </form-button>
      <form-button class="w-full mt-4 lg:mt-0 lg:w-auto inline-block"
        color="red"
        :disabled="disabled"
        @click="cancel"
      >
        Cancelar
      </form-button>
    </div>
  </div>
</template>

<script>
import FormInput from './Input.vue'
import FormButton from './Button.vue'

export default {
  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    hideName: {
      type: Boolean,
      default: false
    },
    hideEmail: {
      type: Boolean,
      default: false
    },
    hidePassword: {
      type: Boolean,
      default: false
    },
    initialValues: {
      type: Object,
      default: () => ({name: '', email: ''})
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: ''
    }
  },
  components: {
    FormInput,
    FormButton
  },
  mounted() {
    this.name = this.initialValues.name
    this.email = this.initialValues.email
  },
  methods: {
    cancel() {
      this.$emit('cancel')
    },
    async save() {
      let data = {}

      if (! this.hideName) {
        data.name = this.name
      }

      if (! this.hideEmail) {
        data.email = this.email
      }

      if (! this.hidePassword) {
        data.password = this.password
        data.password_confirmation = this.password_confirmation
      }

      this.$emit('save', data)
    }
  }
}
</script>
