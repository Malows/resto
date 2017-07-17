<template lang="html">
  <div v-cloak class="content">
    <div class="row">
      <label><input type="checkbox" value="" v-model="verDigest" @change="timerDigest"> Ver resumen</label>
    </div>

    <modal-despachar />
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
      <transition name="slide-left-fade">

        <pedido v-for="pedido in pedidos" v-if="!verDigest" :key="pedido.id" :data="pedido" />
      </transition>
      <transition name="slide-left-fade">
        <digest v-show="verDigest" v-for="categoria in digest_pedidos" :key="categoria.id" :data="categoria" />
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
  .slide-left-fade-enter-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-left-fade-leave-active {
  transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-left-fade-enter, .slide-left-fade-leave-to {
  transform: translateX(10px);
  opacity: 0;
}
</style>
