<template lang="html">
  <div class="text-center">
    <modal-crear />
    <modal-acciones/>
    <modal-cobrar />
    <modal-borrar />
    <modal-editar :datos="mesa_seleccionada" />
    <div class="container-fluid">
      <div class="row col-md-4 col-md-offset-4">
        <button class="btn btn-primary btn-block btn-lg" @click="modalCrear">Agregar pedido</button>
      </div>
    </div>
    <hr v-show="mesas.length">
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left" v-if="mesas.length">
      <mesa v-for="mesa in mesas" :data="mesa" :key="mesa.id"></mesa>
    </div>
    <div style="padding: 20vh;" v-else>
      <p>No quedan pedidos pendientes.</p>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  components: {
    'mesa': () => System.import('./Mesa.vue'),
    'modal-acciones': () => System.import('./ModalAcciones.vue'),
    'modal-crear': () => System.import('./ModalCrear.vue'),
    'modal-cobrar': () => System.import('./ModalCobrar.vue'),
    'modal-borrar': () => System.import('./ModalBorrar.vue'),
    'modal-editar': () => System.import('./ModalEditar.vue'),
  },

  computed: {
    ...mapState(['mesas', 'mesa_seleccionada'])
  },

  methods: {
    modalCrear () { this.$store.dispatch('SHOW_MODAL_CREAR') },

    /*
    * Metodos para enviar peticiones a la API
    */
    cobrarMesa () {
      console.log('Cobrar mesa', mesa_seleccionada)
    },
    borrarMesa () {
      console.log('borrar mesa', mesa_seleccionada)
    },
    editarMesa () {
      console.log('editar mesa', mesa_seleccionada)
    }
  },
  mounted () {
    this.$store.dispatch('REFRESH_CATEGORIAS_WITH_PLATOS')
    this.$store.dispatch('REFRESH_MESAS')
    this.$store.dispatch('REFRESH_PEDIDOS')

  }
}
</script>

<style lang="css">
</style>
