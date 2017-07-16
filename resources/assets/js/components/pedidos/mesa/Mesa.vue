<template lang="html">
  <div class="box" @click="clickEnMesa">
      <p><strong>Mesa {{data.mesa}}</strong> - {{data.total_cosas}} {{ data.total_cosas > 1 ? 'cosas' : ' cosa'}}</p>
      <div class="row">
        <plato v-for="plato in data.platos" :plato="plato" :key="plato.id"></plato>
      </div>
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  props: ['data'],
  methods: {
    clickEnMesa () {
      // console.log(this.data);
      this.$store.dispatch('SET_MESA_SELECCIONADA', this.data )
      this.$store.dispatch('SHOW_MODAL_ACCIONES')
    }
  },
}
</script>

<style lang="css">
</style>
