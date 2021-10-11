<template>
  <input
    :type="type"
    :placeholder="placeholder"
    v-model="val"
    class="px-4 py-2 shadow-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 focus:outline-none"
  />
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'text'
    },
    value: {
      type: [String, Number],
      default: ''
    },
    placeholder: {
      type: String,
      default: ''
    }
  },
  computed: {
    val: {
      get() {
        return this.value
      },
      set(newVal) {
        this.$emit('input', newVal)
      }
    }
  }
}
</script>