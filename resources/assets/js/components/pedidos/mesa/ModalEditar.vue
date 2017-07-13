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
          <li class="pedido-item" v-for="pusher in pusher_platos" @dblclick="quitarPlato(pusher)">{{nombreDePlatos[pusher]}}</li>
        </ul>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth">Editar</button>
      </footer>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
export default {
  props: ['datos'],
  data () {
    return {
      pusher_platos: [],
      model_plato: '',
      old_value_mesa: ''
    }
  },
  methods: {
    hideModal () {
      let aux_mesa = Object.assign({}, this.mesa_seleccionada, {mesa: parseInt(this.old_value_mesa)} )
      this.$store.dispatch('SET_MESA_SELECCIONADA', aux_mesa)
      let aux_pedido = Object.assign({}, this.pedido, {mesa: parseInt(this.old_value_mesa)} )
      this.$store.dispatch('SET_PEDIDO_MESA_SELECCIONADA', aux_pedido)
      this.$store.dispatch('HIDE_MODAL_EDITAR')
    },
    quitarPlato (plato) {
      this.pusher_platos.splice( this.pusher_platos.indexOf(plato), 1 )
    },
    agregarPlato () {
      this.pusher_platos.push(this.model_plato)
      this.model_plato = ''
    },
    updateNumeroDeMesa (e) {
      let aux_mesa = Object.assign({}, this.mesa_seleccionada, {mesa: parseInt(e.target.value)} )
      this.$store.dispatch('SET_MESA_SELECCIONADA', aux_mesa)
      let aux_pedido = Object.assign({}, this.pedido, {mesa: parseInt(e.target.value)} )
      this.$store.dispatch('SET_PEDIDO_MESA_SELECCIONADA', aux_pedido)
    }
  },
  computed: {
    ...mapGetters(['platos', 'nombreDePlatos']),
    ...mapState({
      showModal: 'showModalEditar',
      categorias: 'categorias_with_platos',
      mesa_seleccionada: 'mesa_seleccionada',
      pedido: 'pedido_mesa_seleccionada'
    }),
    mesa: {
      get () {
        return this.mesa_seleccionada.mesa
      },
      set (value) {
        let aux_mesa = Object.assign({}, this.mesa_seleccionada, {mesa: parseInt(value)} )
        this.$store.dispatch('SET_MESA_SELECCIONADA', aux_mesa)
        let aux_pedido = Object.assign({}, this.pedido, {mesa: parseInt(value)} )
        this.$store.dispatch('SET_PEDIDO_MESA_SELECCIONADA', aux_pedido)
      }
    }
  },
  beforeUpdate () {
    this.pusher_platos = this.mesa_seleccionada.platos
  }
}
</script>

<style lang="css">
  .pedido-item {
    margin: 0.25em 0;
  }
</style>
