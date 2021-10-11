<template>
  <div class="inline-flex space-x-2">
    <form-button key="previous"
      :disabled="localCurrentPage === 1"
      color="white"
      class="text-gray-800"
      @click="previous"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </form-button>
    <form-button v-for="item of items"
      :key="item.position"
      :color="item.active ? 'blue' : 'white'"
      :class="[item.active ? 'text-blue-100' : 'text-gray-800']"
      :disabled="item.disabled"
      @click="goTo(item)"
    >
      {{ item.label }}
    </form-button>
    <form-button key="next"
      :disabled="localCurrentPage === items.length"
      color="white"
      class="text-gray-800"
      @click="next"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </form-button>
  </div>
</template>

<script>
import FormButton from './Button.vue'

const MAX_ELEMENTS = 10;

export default {
  props: {
    total: {
      type: Number,
      default: 0,
    },
    perPage: {
      type: Number,
      default: 15
    },
    currentPage: {
      type: Number,
      default: 1
    }
  },
  components: {
    FormButton
  },
  data() {
    return {
      localCurrentPage: 1,
    }
  },
  computed: {
    items() {
      const elements = Math.ceil(this.total / this.perPage)

      if (elements === 0) {
        return [{
          label: 1,
          position: 1,
          disabled: true
        }]
      }

      let _items = []

      for (let index = 1; index <= elements; index++) {
        _items.push({
          label: index,
          position: index,
          active: index === this.localCurrentPage,
          disabled: false
        })
      }

      return _items;
    }
  },
  methods: {
    previous() {
      console.log('previous')
      this.localCurrentPage--
      this.$emit('goTo', this.localCurrentPage)
    },
    goTo(item) {
      if (item.position === this.localCurrentPage) return

      console.log('goTo', item)
      this.localCurrentPage = item.position
      this.$emit('goTo', this.localCurrentPage)
    },
    next() {
      console.log('next')
      this.localCurrentPage++
      this.$emit('goTo', this.localCurrentPage)
    }
  },
  watch: {
    currentPage: {
      immediate: true,
      handler(val) {
        this.localCurrentPage = val
      }
    }
  }
}
</script>
