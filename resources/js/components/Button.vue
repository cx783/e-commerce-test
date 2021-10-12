<template>
  <button
    class="rounded text-white disabled:opacity-75 inline-flex justify-center items-center"
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
      if (this.color === 'white') {
        return 'bg-white'
      }

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
