<template lang="html">
  <div class="box" v-show="data.total">
    <h2 class="title">{{data.nombre.toUpperCase()}}</h2>
    <h4 class="subtitle">{{`${data.total} cosa${data.total>2 ? 's': ''}`}}</h4>
    <hr>
    <div class="row">
      <plato v-for="plato in data.platos" :key="plato.id" :plato="plato"></plato>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  props: ['data']
}
</script>
