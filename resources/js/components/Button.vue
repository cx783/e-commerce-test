<template>
  <button
    class="btn"
    :class="[bg, sizeClass]"
    :type="type"
    :disabled="disabled"
    @click="$emit('click')"
  >
    <slot></slot>
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: 'button'
    },
    color: {
      type: String,
      default: 'blue'
    },
    size: {
      type: String,
      default: 'md'
    },
    disabled: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    bg() {
      return `btn-${this.color}`
    },
    sizeClass() {
      return `btn-${this.size}`
    }
  }
}
</script>
