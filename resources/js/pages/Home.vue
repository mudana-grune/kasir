<template>
</template>
<script>
export default {
  computed: {
      isAdmin() {
          return this.$auth.user().role === 2;
      }
  },
  mounted() {
     this.isAdmin ?  this.$router.push({name: 'admin.dashboard'}) :  this.$router.push({name: 'kasir.dashboard'})
  }
}
</script>
