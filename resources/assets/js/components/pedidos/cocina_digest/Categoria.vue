<template lang="html">
  <div class="box" v-show="categoria.total">
    <h2 class="title">{{categoria.nombre.toUpperCase()}}</h2>
    <h4 class="subtitle">{{`${categoria.total} cosa${categoria.total>2 ? 's': ''}`}}</h4>
    <hr>
    <div class="row">
      <plato v-for="plato in categoria.platos" :key="plato.id" :plato="plato"></plato>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  props: ['categoria']
}
</script>
