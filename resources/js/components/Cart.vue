<template>
  <div class="flex flex-col bg-white">
    <div class="flex-grow overflow-y-auto">
      <div v-for="(item, index) of items"
        :key="index"
        class="flex justify-between items-start text-sm px-4 py-2 space-x-2"
      >
        <form-button size="sm" color="red" class="flex-shrink-0 self-center" @click="removeItem(item.product.id)">
          <svg class="w-4 h-4 text-red-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </form-button>
        <span class="text-gray-600 text-left flex-grow">{{ item.product.name }} x {{ item.quantity }}</span>
        <span class="text-gray-800 font-semibold flex-shrink-0">$ {{ item.product.price * item.quantity}}</span>
      </div>
    </div>
    <div class="flex-shrink-0 flex items-center p-4 border-t"
      :class="{'justify-between': ! withoutCheckoutButton, 'justify-end': withoutCheckoutButton}"
    >
      <form-button size="sm" variant="green" @click="checkout" v-if="! withoutCheckoutButton">
        Check Out
      </form-button>
      <span class="text-base text-gray-800 font-semibold">
        $ {{ total }}
      </span>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState, mapMutations } from 'vuex'
import FormButton from './Button.vue'

export default {
  props: {
    withoutCheckoutButton: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    ...mapState('cart', [
      'items'
    ]),
    ...mapGetters('cart', [
      'total',
      'totalItems'
    ]),
  },
  components: {
    FormButton
  },
  methods: {
    ...mapMutations('cart', [
      'removeItem'
    ]),
    checkout() {
      this.$router.push('/checkout')
    }
  }
}
</script>