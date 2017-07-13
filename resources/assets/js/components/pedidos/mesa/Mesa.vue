<template lang="html">
  <div class="box" @click="clickEnMesa" v-show="pedido">
      <p><strong>Mesa {{data.mesa}}</strong> - {{data.platos.length}} {{ data.platos.length> 1 ? 'cosas' : ' cosa'}}</p>
      <div class="row">
        <plato v-for="plato in pedido.platos" :plato="plato" :key="plato.id"></plato>
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
  data () {
    return {
      pedido: {},
    }
  },
  methods: {
    clickEnMesa () {
      // console.log(this.data);
      this.$store.dispatch('SET_MESA_SELECCIONADA', this.data )
      this.$store.dispatch('SET_PEDIDO_MESA_SELECCIONADA', this.pedido )
      this.$store.dispatch('SHOW_MODAL_ACCIONES')
    }
  },
  created () {
    axios.get(this.data.url).then( ({ data }) => { this.pedido = data } )
  }
}
</script>

<style lang="css">
</style>
