<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Cancelar pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <p>¿Esta seguro de desea cancelar el pedido completo?</p>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">No</button>
        <button class="button is-danger is-large is-fullwidth" :style="{'is-loading': buttonLoading}" @click="borrarPedido">Sí</button>
    </footer>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  data () {
    return {
      buttonLoading: false,
    }
  },
  computed: {
    ...mapState({
      showModal: 'showModalBorrar',
      mesa: 'mesa_seleccionada'
    })
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_BORRAR')
    },
    borrarPedido () {
      this.buttonLoading = true
      this.$store.dispatch('BORRAR_PEDIDO', this.mesa).then( response => {
        this.hideModal()
        this.buttonLoading = false
      })
    }
  },
}
</script>

<style lang="css">
</style>
