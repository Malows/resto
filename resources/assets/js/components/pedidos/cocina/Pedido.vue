<template lang="html">
  <div class="box" @click="clickEnPedido">
    <p>Mozo: <strong>{{data.mozo.name}}</strong> - {{data.total_cosas}} {{data.total_cosas > 1 ? 'cosas' : 'cosa'}}</p>
    <div class="row">
      <plato v-for="plato in data.platos" :key="plato.id" :plato="plato"></plato>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  props: ['data'],
  methods: {
    clickEnPedido (pedido) {
      this.$store.dispatch('SET_PEDIDO_SELECCIONADO', this.data)
      this.$store.dispatch('SHOW_MODAL_DESPACHAR')
    }
  },
  computed: {
    
  }
}
</script>

<style lang="css">
</style>
