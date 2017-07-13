<template lang="html">
  <div class="modal text-left" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Cobrar pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <p><strong>Platos</strong></p>
        <div class="row">
          <div class="col-xs-12 col-md-6 pedido-item" v-for="plato in pedido.platos">
            {{plato.nombre}}
            <strong class="text-danger" v-if="plato.cantidad > 1">X{{plato.cantidad}}</strong>
          </div>
        </div>
        <hr>
        <p>Total:<strong class="pull-right">${{pedido.total}}</strong></p>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth">Completar</button>
    </footer>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState({
      showModal: 'showModalCobrar',
      pedido: 'pedido_mesa_seleccionada'
    })
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_COBRAR');
    }
  }
}
</script>

<style lang="css">
</style>
