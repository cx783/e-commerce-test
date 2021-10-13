<template>
  <div id="app" class="w-full h-full">
    <div class="fixed top-4 right-4 w-64 p-4 text-sm z-50 bg-red-400 text-red-50 rounded" v-if="errorMessages.length > 0">
      <p v-for="(message, index) of errorMessages" :key="`msg_${index}`">{{ message }}</p>
    </div>
    <router-view/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState([
      'errorMessages'
    ])
  }
}
</script>
