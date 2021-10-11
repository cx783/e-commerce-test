<template>
  <div>
    <div class="flex flex-col items-center md:flex-row">
      <label for="name" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Name
      </label>
      <form-input v-model="name" class="w-full" id="name" placeholder="My product"></form-input>
    </div>
    <div  class="flex flex-col items-center md:flex-row mt-4">
      <label for="description" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Description
      </label>
      <form-input v-model="description" type="text" class="w-full" id="email" placeholder="........."></form-input>
    </div>
    <div class="flex flex-col items-center md:flex-row mt-4">
      <label for="price" class="w-full md:w-64 flex-shrink-0 block mb-2">
        Price
      </label>
      <form-input v-model="price" type="number" class="w-full" id="price" placeholder="10"></form-input>
    </div>
    <div class="flex flex-col items-center md:flex-row mt-4">
      <label class="inline-flex items-center">
          <input type="checkbox" class="form-checkbox border border-gray-300 rounded" v-model="status">
          <span class="ml-2">Active</span>
        </label>
    </div>
    <div class="mt-4 lg:text-right">
      <form-button class="w-full lg:w-auto inline-block  disabled:opacity-75"
        :disabled="disabled"
        @click="save"
      >
        Guardar
      </form-button>
      <form-button class="w-full mt-4 lg:mt-0 lg:w-auto inline-block disabled:opacity-75"
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
    initialValues: {
      type: Object,
      default: () => ({
        name: '',
        description: '',
        price: 0,
        status: true
      })
    }
  },
  data() {
    return {
      name: '',
      description: '',
      price: 0,
      status: true
    }
  },
  components: {
    FormInput,
    FormButton
  },
  mounted() {
    this.name = this.initialValues.name
    this.description = this.initialValues.description
    this.price = this.initialValues.price
    this.status = this.initialValues.status
  },
  methods: {
    cancel() {
      this.$emit('cancel')
    },
    async save() {
      this.$emit('save', {
        name: this.name,
        description: this.description,
        price: this.price,
        status: this.status
      })
    }
  }
}
</script>
