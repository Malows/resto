<template lang="html">
  <div v-cloak class="content">
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
      <pedido v-for="pedido in pedidos" :key="pedido.id" :pedido="pedido"></pedido>
    </div>
    <modal-despachar />
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
import { mapState } from 'vuex'
export default {
  components: {
    'pedido': () => System.import('./Pedido.vue'),
    'modal-despachar': () => System.import('./ModalDespachar.vue')
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_DESPACHAR')
    },
    clickEnPedido (pedido) {
      this.$store.dispatch('SET_PEDIDO_SELECCIONADO', pedido)
      this.$store.dispatch('SHOW_MODAL_DESPACHAR')
    }
  },
  computed: {
    ...mapState({
      'pedido': (state) => state.cocina.pedidos
    })
  },
  created () {
    this.$store.dispatch('REFRESH_PEDIDOS_PENDIENTES')
  }
}
</script>

<style lang="css">
  [v-cloak] { display: none }
</style>
