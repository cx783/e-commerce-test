<template>
  <div id="app" class="h-full">
    <router-view/>
  </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch('getUser')
  }
}
</script>
