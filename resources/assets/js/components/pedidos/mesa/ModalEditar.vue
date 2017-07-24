<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Editar pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">

        <div class="form-group">
          <label for="mesa">Mesa</label>
          <input type="text" class="form-control" placeholder="Número de mesa" v-model="mesa">
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-9">
              <label for="select_platos">Platos</label>
              <select class="form-control" v-model="model_plato" @submit.prevent="agregarPlato">
                <optgroup v-for="categoria in categorias" :label="categoria.nombre" v-if="categoria.platos.length">
                  <option v-for="plato in categoria.platos" :value="plato.id" >{{plato.nombre}}</option>
                </optgroup>
              </select>
            </div>
            <div class="col-xs-3">
              <label for="id_plato">Código</label>
              <input type="number" v-model="model_plato" @submit.prevent="agregarPlato" @keyup.enter="agregarPlato" class="form-control" placeholder='Código'>
            </div>
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-default btn-block btn-lg" @click="agregarPlato">Añadir</button>
        </div>

        <hr>

        <p><strong>Platos</strong></p>
        <ul class="text-left">
          <li class="pedido-item" v-for="pusher in mesa_seleccionada.platos_ids" @dblclick="quitarPlato(pusher)">{{nombreDePlatos[pusher]}}</li>
        </ul>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth" :style="{'is-loading': buttonLoader}" @click="editarPedido">Enviar</button>
      </footer>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
export default {
  data () {
    return {
      model_plato: '',
      buttonLoader: false
    }
  },
  methods: {
    hideModal () {
      this.$store.dispatch('ROLLBACK_MESA_SELECCIONADA').then(() => {
        this.$store.dispatch('HIDE_MODAL_EDITAR')
      })
    },
    quitarPlato (plato) {
      this.$store.dispatch('QUITAR_PLATO_PEDIDO', plato)
    },
    agregarPlato () {
      if (this.model_plato) {
        this.$store.dispatch('AGREGAR_PLATO_PEDIDO', this.model_plato)
        this.model_plato = ''
      }
    },
    editarPedido () {
      this.buttonLoader = true
      let payload = {
        mesa: this.mesa,
        platos: this.mesa_seleccionada.platos_ids
      }
      this.$store.dispatch('EDITAR_PEDIDO', payload).then(() => {
        this.buttonLoader = false
        this.$store.dispatch('HIDE_MODAL_EDITAR')
      })
    }
  },
  computed: {
    ...mapGetters(['platos', 'nombreDePlatos']),
    ...mapState({
      'showModal': state => state.mozo.showModalEditar,
      'categorias': state => state.mozo.categorias_with_platos,
      'mesa_seleccionada': state => state.mozo.mesa_seleccionada
    }),

    mesa: {
      get () {
        return this.mesa_seleccionada.mesa
      },
      set (value) {
        this.$store.dispatch(
          'SET_MESA_SELECCIONADA',
          Object.assign({}, this.mesa_seleccionada, {mesa: value ? parseInt(value) : ''})
        )
      }
    }
  }
}
</script>

<style lang="css">
  .pedido-item {
    margin: 0.25em 0;
  }
</style>
