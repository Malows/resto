<template lang="html">
  <div class="box" @click="clickOnPedido">
    <p>Mozo: <strong>{{data.mozo.name}}</strong> - {{totalDeCosas}} {{totalDeCosas > 1 ? 'cosas' : 'cosa'}}</p>
    <div class="row">
      <plato v-for="plato in data.platos" :key="plato.id" :plato="plato"></plato>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    'plato': () => System.import('../partials/Plato.vue')
  },
  props: ['pedido'],
  data () {
    return {
      data: {
        mozo: {
          name: ''
        },
        platos: []
      }
    }
  },
  methods: {
    clickOnPedido () {
      this.$emit('clickEnPedido', this.data)
    },
  },
  computed: {
    totalDeCosas () {
      return this.data.platos.reduce((carry, current) => carry + current.cantidad, 0)
    }
  },
  created () {
    axios.get(this.pedido.url).then(({ data }) => {
      this.data = data
    })
  }
}
</script>

<style lang="css">
</style>
