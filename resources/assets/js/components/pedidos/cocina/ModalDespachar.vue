<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Despachar pedido completo</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <p>Mozo: <strong>{{pedido.mozo.name}}</strong> - {{pedido.total_cosas}} {{pedido.total_cosas > 1 ? 'cosas' : 'cosa'}}</p>
        <div class="row">
          <plato v-for="plato in pedido.platos" :key="pedido.id" :plato="plato" :estilos="['col-sm-12', 'col-md-6', 'pedido-item']" />
        </div>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth" :style="{ 'is-loading': buttonLoading }">Completar</button>
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
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_DESPACHAR')
    },
    despacharPedido () {
      this.buttonLoading = true
      this.$store.dispatch('DESPACHAR_PEDIDO', this.pedido).then( () => {
        this.buttonLoading = false
        this.$store.dispatch('HIDE_MODAL_DESPACHAR')
      })
    }
  },
  computed: {
    ...mapState({
      'pedido': (state) => state.cocina.pedido_seleccionado,
      'showModal': (state) => state.cocina.showModalDespachar
    }),
  },
}
</script>

<style lang="css">
</style>
