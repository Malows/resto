<template lang="html">
  <div>
    <menu-platos v-for="categoria in categorias" :categoria='categoria' :key='categoria.id'></menu-platos>
  </div>
</template>

<script>
export default {
  components: {
    'menu-platos': () => System.import('./MenuPlatos.vue')
  },
  props: ['url'],
  data () {
    return {
      categorias: []
    }
  },
  created () {
    axios.get(this.url)
    .then(response => {
      this.categorias = response.data
    })
  }
}
</script>

<style lang="css">
</style>
