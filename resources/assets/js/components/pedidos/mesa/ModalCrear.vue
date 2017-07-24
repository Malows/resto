<template lang="html">
  <div class="modal" :class="{ 'is-active': showModal }">
    <div class="modal-background" @click="hideModal"></div>
    <div class="modal-card">
      <header class="modal-card-head">
        <p class="modal-card-title">Crear pedido</p>
        <button class="delete" @click="hideModal"></button>
      </header>
      <section class="modal-card-body">

        <div class="form-group">
          <label for="mesa">Mesa</label>
          <input type="text" class="form-control" placeholder="Número de mesa" v-model.number="mesa">
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-xs-9">
              <label for="select_platos">Platos</label>
              <select class="form-control" v-model.number="model_plato">
                <optgroup v-for="categoria in categorias" :label="categoria.nombre" v-if="categoria.platos.length">
                  <option v-for="plato in categoria.platos" :value="plato.id" >{{plato.nombre}}</option>
                </optgroup>
              </select>
            </div>
            <div class="col-xs-3">
              <label for="id_plato">Código</label>
              <input type="number" v-model.number="model_plato" @keyup.enter="agregarPlato" class="form-control" placeholder='Código'>
            </div>
          </div>
        </div>

        <div class="form-group">
          <button class="btn btn-default btn-block btn-lg" @click="agregarPlato">Añadir</button>
        </div>

        <hr>

        <p><strong>Platos</strong></p>
        <ul class="text-left">
          <li class="pedido-item" v-for="pusher in pusher_platos" @dblclick="quitarPlato(pusher)">{{platos[pusher]}}</li>
        </ul>
      </section>
      <footer class="modal-card-foot">
        <button class="button is-large is-fullwidth" @click="hideModal">Cerrar</button>
        <button class="button is-info is-large is-fullwidth" :style="{ 'is-loading': botonLoader }" @click="enviarNuevoPedido">Enviar</button>
      </footer>
    </div>
  </div>
</template>

<script>
import { mapState, mapGetters } from 'vuex'
export default {
  data () {
    return {
      mesa: '',
      model_plato: '',
      pusher_platos: [],
      botonLoader: false
    }
  },
  computed: {
    ...mapState({
      showModal: state => state.mozo.showModalCrear,
      categorias: state => state.mozo.categorias_with_platos
    }),
    ...mapGetters({
      platos: 'nombreDePlatos'
    })
  },
  methods: {
    hideModal () {
      this.mesa = ''
      this.model_plato = ''
      this.pusher_platos = []
      this.$store.dispatch('HIDE_MODAL_CREAR')
    },
    quitarPlato (plato) {
      this.pusher_platos.splice(this.pusher_platos.indexOf(plato), 1)
    },
    agregarPlato () {
      if (this.model_plato) {
        this.pusher_platos.push(this.model_plato)
        this.pusher_platos = this.pusher_platos.sort()
        this.model_plato = ''
      }
    },
    enviarNuevoPedido () {
      this.boton_loader = true
      let payload = {
        mesa: this.mesa,
        platos: this.pusher_platos
      }
      this.$store.dispatch('NUEVO_PEDIDO', payload).then(response => {
        this.boton_loader = false
        this.hideModal()
      })
    }
  }
}
</script>

<style lang="css">
</style>
