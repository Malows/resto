<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Crear pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <div class="btn-group btn-block">
          <button class="btn btn-success btn-lg col-xs-4"><span class="glyphicon glyphicon-usd"></span>Cobrar</button>
          <button class="btn btn-primary btn-lg col-xs-4"><span class="glyphicon glyphicon-edit"></span>Editar</button>
          <button class="btn btn-danger btn-lg col-xs-4"><span class="glyphicon glyphicon-trash"></span>Cancelar</button>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  computed: {
    ...mapState({
      showModal: 'showModalCrear'
    })
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_CREAR')
    }
  }
}
</script>

<style lang="css">
</style>
