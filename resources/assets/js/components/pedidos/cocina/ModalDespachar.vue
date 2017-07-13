<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Despachar pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <p>Mozo: <strong>{{pedido.mozo.name}}</strong> - {{totalDeCosas}} {{totalDeCosas > 1 ? 'cosas' : 'cosa'}}</p>
        <div class="row">
          <div class="col-sm-12 col-md-6 pedido-item" v-for="plato in pedido.platos">
            <strong class="text-danger" v-if="plato.cantidad > 1">X{{plato.cantidad}}</strong> {{plato.nombre}}
          </div>
        </div>
      </section>
      <footer class="modal-card-foot">
        <a class="button is-large is-fullwidth" @click="hideModal">Cerrar</a>
        <a class="button is-info is-large is-fullwidth">Completar</a>
    </footer>
    </div>
  </div>
</template>

<script>
export default {
  props: ['showModal', 'pedido'],
  methods: {
    hideModal () {
      this.$emit('hideModal')
    }
  },
  computed: {
    totalDeCosas () {
      return this.pedido.platos.reduce((carry, current) => carry + current.cantidad, 0)
    }
  },
}
</script>

<style lang="css">
</style>
