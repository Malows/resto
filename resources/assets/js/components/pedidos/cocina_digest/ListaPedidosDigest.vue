<template lang="html">
  <div class="content" v-cloak>
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
      <categoria v-for="categoria in categorias" :key="categoria.id" :data="categoria"></categoria>
    </div>
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
import { mapState } from 'vuex'
export default {
  components: {
    'categoria': () => System.import('./Categoria.vue')
  },
  computed: {
    ...mapState({
      'categorias': (state) => state.cocina.digest_pedidos
    })
  },
  created () {
    this.$store.dispatch('REFRESH_PEDIDOS_PENDIENTES')
    this.$store.dispatch('REFRESH_CATEGORIAS_WITH_PLATOS')
  }
}
</script>

<style lang="css">
</style>
