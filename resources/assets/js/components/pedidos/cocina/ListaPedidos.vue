<template lang="html">
  <div v-cloak class="content">
    <h2 class="text-center">Pedidos</h2>
    <hr>
    <div class="row">
      <button class="btn btn-primary pull-left" v-show="!verDigest" @click="clickDigest">Ver resumen</button>
      <button class="btn btn-primary pull-left" v-show="verDigest" @click="verDigest = false">Volver</button>
      <button class="btn btn-primary pull-right" v-show="verDigest">Fijar resumen</button>
    </div>

    <modal-despachar />
      <transition name="fade">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left" v-if="!verDigest">
          <pedido v-for="pedido in pedidos" :key="pedido.id" :data="pedido" />
        </div>
      </transition>
      <transition name="fade">
        <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left" v-if="verDigest" >
          <digest v-for="categoria in digest_pedidos" :key="categoria.id" :data="categoria" />
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
import { mapState } from 'vuex'
export default {
  components: {
    'pedido': () => System.import('./Pedido.vue'),
    'modal-despachar': () => System.import('./ModalDespachar.vue'),
    'digest': () => System.import('../cocina_digest/Categoria.vue')
  },
  data () {
    return {
      verDigest: false,
    }
  },
  computed: {
    ...mapState({
      'pedidos': (state) => state.cocina.pedidos,
      'digest_pedidos': (state) => state.cocina.digest_pedidos
    })
  },
  methods: {
    clickDigest () {
      this.verDigest = ! this.verDigest
      this.timerDigest()
    },
    timerDigest() {
      if ( this.verDigest ) {
        setTimeout(() => {
          this.verDigest = false
        }, 10000)
      }
    }
  },
  created () {
    this.$store.dispatch('REFRESH_PEDIDOS_PENDIENTES')
    this.$store.dispatch('REFRESH_CATEGORIAS_WITH_PLATOS')
  }
}
</script>

<style lang="css">
  [v-cloak] {
  display: none
}
  .fade-enter-active {
  transition: all .3s ease
}
.fade-leave-active {
  transition: all .3s ease
}
.fade-enter, .fade-leave-to {
  /*transform: translateX(10px);*/
  opacity: 0;
}
</style>
