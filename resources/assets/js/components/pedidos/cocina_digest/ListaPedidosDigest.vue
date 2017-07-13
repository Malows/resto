<template lang="html">
  <div class="content" v-cloak>
    <div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 text-left">
      <categoria v-for="categoria in categorias" :key="categoria.id" :categoria="categoria"></categoria>
    </div>
  </div>
</template>

<script>
import 'bulma/css/bulma.css'
export default {
  components: {
    'categoria': () => System.import('./Categoria.vue')
  },
  props: ['url'],
  data () {
    return {
      categorias: [],
    }
  },
  created () {
    axios.get(this.url).then( ( { data } ) => { this.categorias = ( Array.isArray(data) ) ? data : [data] } )
  }
}
</script>

<style lang="css">
</style>
