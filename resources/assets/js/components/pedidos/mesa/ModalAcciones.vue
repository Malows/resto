<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Acciones</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">
        <div class="btn-group btn-block">
          <button class="btn btn-success btn-lg col-xs-4 acciones-btn" @click="clickCobrar"><span class="glyphicon glyphicon-usd"></span>Cobrar</button>
          <button class="btn btn-primary btn-lg col-xs-4 acciones-btn" @click="clickEditar"><span class="glyphicon glyphicon-edit"></span>Editar</button>
          <button class="btn btn-danger btn-lg col-xs-4 acciones-btn" @click="clickBorrar"><span class="glyphicon glyphicon-trash"></span>Cancelar</button>
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
      showModal: 'showModalAcciones'
    })
  },
  methods: {
    hideModal () {
      this.$store.dispatch('HIDE_MODAL_ACCIONES');
    },
    clickCobrar () {
      this.$store.dispatch('SHOW_MODAL_COBRAR');
    },
    clickEditar () {
      this.$store.dispatch('SHOW_MODAL_EDITAR');
    },
    clickBorrar () {
      this.$store.dispatch('SHOW_MODAL_BORRAR');
    },
  }
}
</script>

<style lang="css">
  .acciones-btn {
    height: 15vh;
  }
</style>
