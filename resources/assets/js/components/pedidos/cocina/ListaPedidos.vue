<template lang="html">
  <div v-cloak class="content">
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
      <pedido v-for="pedido in pedidos" :key="pedido.id" :pedido="pedido" @clickEnPedido="handleClickEnPedido"></pedido>
    </div>
    <modal-despachar :showModal="showModal" :pedido="pedido_seleccionado" @hideModal="hideModal"></modal-despachar>
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
export default {
  components: {
    'pedido': () => System.import('./Pedido.vue'),
    'modal-despachar': () => System.import('./ModalDespachar.vue')
  },
  props: ['url'],
  data () {
    return {
      pedidos: [],
      pedido_seleccionado: { mozo: { name: ''}, platos: []},
      showModal: false
    }
  },
  methods: {
    hideModal () {
      this.showModal = false
    },
    handleClickEnPedido (pedido) {
      this.pedido_seleccionado = pedido
      this.showModal = true
    }
  },
  created () {
    axios.get(this.url).then(response => {this.pedidos = response.data})
    // axios.get(this.url_personal).then(response => {this.personal = response.data})
    // axios.get(this.url_platos).then(response => {this.platos = response.data})
  },
  mounted () {

  }
}
</script>

<style lang="css">
  [v-cloak] { display: none }
</style>
