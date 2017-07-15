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
          <plato v-for="plato in mesa.platos" :key=plato.id :plato="plato" :estilos="['col-xs-12', 'col-md-6', 'pedido-item']" />
        </div>
        <hr>
        <p>Total:<strong class="pull-right">${{mesa.total_cobrar}}</strong></p>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth" :style="{'is-loading': buttonLoading}" @click="cobrarPedido">Cobrar</button>
    </footer>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  data () {
    return {
      buttonLoading: false
    }
  },
  computed: {
    ...mapState({
      showModal: 'showModalCobrar',
      mesa: 'mesa_seleccionada'
    })
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_COBRAR');
    },
    cobrarPedido () {
      this.buttonLoading = true;
      console.log('cobrar');
      this.$store.dispatch('COBRAR_PEDIDO', this.mesa).then( () => {
        this.hideModal();
        this.buttonLoading = false;
      })
    }
  }
}
</script>

<style lang="css">
</style>
