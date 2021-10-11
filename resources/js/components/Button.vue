<template>
  <button
    class="rounded-lg text-white"
    :class="[bg, sizeClass]"
    :type="type"
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
    }
  },
  computed: {
    bg() {
      return `bg-${this.color}-600`
    },
    sizeClass() {
      switch (this.size) {
        case 'sm':
          return 'text-sm py-1 px-2'
        case 'lg':
          return 'text-lg px-6 py-4'
        default:
          return 'text-base px-4 py-2'
      }
    }
  }
}
</script>
