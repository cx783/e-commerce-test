<template>
  <div class="inline-block">
    <div v-if="shouldConfirm">
      <form-button
        :color="confirmColor"
        :size="size"
        :disabled="disabled"
        @click="confirm"
      >
        <slot name="confirm-button">{{ textConfirm }}</slot>
      </form-button>
      <form-button
        :color="cancelColor"
        :size="size"
        :disabled="disabled"
        @click="shouldConfirm = false"
      >
        <slot name="cancel-button">{{ textCancel }}</slot>
      </form-button>
    </div>
    <div v-else>
      <form-button
        :color="color"
        :size="size"
        :disabled="disabled"
        @click="shouldConfirm = true"
        :class="buttonClass"
      >
        <slot>{{ text }}</slot>
      </form-button>
    </div>
  </div>
</template>

<script>
import FormButton from './Button.vue'

export default {
  props: {
    text: {
      type: String,
      default: ''
    },
    textConfirm: {
      type: String,
      default: 'Confirm'
    },
    textCancel: {
      type: String,
      default: 'Cancel'
    },
    size: {
      type: String,
      default: 'md'
    },
    color: {
      type: String,
      default: 'blue'
    },
    confirmColor: {
      type: String,
      default: 'green'
    },
    cancelColor: {
      type: String,
      default: 'red'
    },
    disabled: {
      type: Boolean,
      default: false
    },
    buttonClass: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      shouldConfirm: false
    }
  },
  components: {
    FormButton
  },
  methods: {
    confirm() {
      this.$emit('confirmed')
      this.shouldConfirm = false
    }
  }
}
</script>
