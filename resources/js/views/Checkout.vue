<template>
  <div class="bg-gray-200">
    <client-header></client-header>
    <div class="container mx-auto py-4">
      <div v-if="items.length > 0">
        <p class="text-xl text-gray-800 font-semibold mt-4 mb-6">Checkout</p>
        <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
          <div class="flex flex-col space-y-2 flex-grow bg-white rounded p-4">
            <p class="text-gray-800 text-base font-semibold pb-2">General Information</p>
            <div>
              <label for="full_name"
                class="w-full mb-1 md:w-72"
              >Full name</label>
              <form-input name="full_name"
                v-model="full_name"
                class="w-full"
              ></form-input>
            </div>
            <div class="flex flex-col space-y-2 lg:flex-row md:space-y-0 md:space-x-2">
              <div class="w-full">
                <label for="address"
                  class="w-full mb-1"
                >Address</label>
                <form-input name="address"
                  v-model="address"
                  class="w-full"
                ></form-input>
              </div>
              <div class="w-full">
                <label for="state"
                  class="w-full mb-1"
                >State</label>
                <form-input name="state"
                  v-model="state"
                  class="w-full"
                ></form-input>
              </div>
              <div class="w-full">
                <label for="country"
                  class="w-full mb-1"
                >Country</label>
                <form-input name="country"
                  v-model="country"
                  class="w-full"
                ></form-input>
              </div>
            </div>
            <p class="text-gray-800 text-base font-semibold pt-4 pb-2">Payment Info</p>
            <div class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-2">
              <div class="md:w-1/2">
                <label for="credit_card"
                  class="w-full mb-1 md:w-72"
                >Credit card</label>
                <form-input name="credit_card"
                  v-model="credit_card"
                  class="w-full"
                ></form-input>
              </div>
              <div class="md:w-1/4">
                <label for="credit_card_expiration"
                  class="w-full mb-1 md:w-72"
                >Credit card expiration</label>
                <form-input name="credit_card_expiration"
                  v-model="credit_card_expiration"
                  class="w-full"
                ></form-input>
              </div>
              <div class="md:w-1/4">
                <label for="credit_card_cvv"
                  class="w-full mb-1 md:w-72"
                >Credit card cvv</label>
                <form-input name="credit_card_cvv"
                  v-model="credit_card_cvv"
                  class="w-full"
                ></form-input>
              </div>
            </div>
          </div>
          <div class="w-96">
            <div class="pt-4 bg-white">
              <p class="px-4 text-gray-800 text-base font-semibold">Items</p>
              <cart without-checkout-button></cart>
            </div>
            <div class="mt-4">
              <form-button color="green" class="w-full" @click="save" :disabled="saving">
                <loader color="green-100" v-if="saving"></loader>
                <span>Pay</span>
              </form-button>
            </div>
          </div>
        </div>
      </div>
      <div v-else-if="saved" class="flex flex-col space-y-6 items-center">
        <p class="my-6 text-xl text-green-700">Thank's for your purchase.</p>
        <form-button @click="$router.replace('/')">Go to list of products</form-button>
      </div>
      <div v-else class="flex flex-col space-y-6 items-center">
        <p class="my-6 text-xl text-gray-700">You don't have items in your cart.</p>
        <form-button @click="$router.replace('/')">Go to list of products</form-button>
      </div>
    </div>
  </div>
</template>

<script>
import ClientHeader from './../components/ClientHeader.vue'
import FormButton from './../components/Button.vue'
import FormInput from './../components/Input.vue'
import Cart from './../components/Cart.vue'
import { mapGetters, mapState } from 'vuex'

export default {
  data() {
    return {
      full_name: '',
      address: '',
      state: '',
      country: '',
      credit_card: '',
      credit_card_expiration: '',
      credit_card_cvv: ''
    }
  },
  components: {
    ClientHeader,
    FormButton,
    FormInput,
    Cart
  },
  computed: {
    ...mapState('cart', [
      'items',
      'saving',
      'saved'
    ]),
    ...mapGetters('cart', [
      'total',
      'totalItems'
    ])
  },
  methods: {
    save() {
      this.$store.dispatch('cart/save', {
        full_name: this.full_name,
        address: this.address,
        state: this.state,
        country: this.country,
        payment: {
          credit_card: this.credit_card,
          credit_card_expiration: this.credit_card_expiration,
          credit_card_cvv: this.credit_card_cvv
        }
      })
    }
  }
}
</script>
