<template>
</template>
<script>
const KASIR = 1;
const ADMIN = 2;
const MANAGER = 3;

export default {
  computed: {
     role() {
       return  this.$auth.user().role
     }
  },
  mounted() {
     this.role === MANAGER ?  this.$router.push({name: 'manager.dashboard'}) :  (this.role === ADMIN ? this.$router.push({name: 'admin.dashboard'}) : this.$router.push({name: 'kasir.dashboard'}))
  }
}
</script>
