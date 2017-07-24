<template lang="html">
  <div class="row text-center">
    <h2 v-show="platosFiltrados.length">{{this.categoria.nombre.toUpperCase()}}</h2>
    <div class="row col-lg-8 col-lg-offset-2" v-for="fila in platosDistribuidos" >
      <plato v-for="elem in fila" :elem="elem" :key="elem.id">
      </plato>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    'plato': () => System.import('./Plato.vue')
  },
  props: ['categoria'],
  data () {
    return {
      // nombre: '',
      divisor: 1,
      resto: 0,
      platos: []
    }
  },
  computed: {
    platosFiltrados () {
      return this.platos.filter(el => el.habilitado)
    },
    platosDistribuidos () {
      let filtrados = this.platos.filter(el => el.habilitado)
      let arr = []
      while (filtrados.length) {
        arr.push(filtrados.splice(0, this.divisor))
      }
      return arr
    }
  },
  methods: {
    handleResize () {
      let ancho = window.innerWidth
      let chico = ancho < 768 // punto de quiebre a xs en bootstrap
      this.divisor = (chico) ? 3 : 4
      this.resto = this.platos.length % this.divisor
    }
  },
  mounted () {
    let ancho = window.innerWidth
    let chico = ancho < 768 // punto de quiebre a xs en bootstrap
    this.divisor = (chico) ? 3 : 4
    this.resto = this.platos.length % this.divisor
  },
  created () {
    this.platos = this.categoria.platos.map(el => el)

    window.EventBus.$on('deshabilitarPlatos', (payload) => {
      if (typeof payload === 'number') {
        let encontrado = this.platos.filter(elem => elem.id === payload)[0]
        if (encontrado) encontrado.habilitado = false
      } else if (Array.isArray(payload)) {
        this.platos = this.platos.map((plato) => {
          if (payload.includes(plato.id)) plato.habilitado = false
          return plato
        })
      }
    })

    window.EventBus.$on('habilitarPlatos', (payload) => {
      if (typeof payload === 'number') {
        let encontrado = this.platos.filter(elem => elem.id === payload)[0]
        if (encontrado) encontrado.habilitado = true
      } else if (Array.isArray(payload)) {
        this.platos = this.platos.map((plato) => {
          if (payload.includes(plato.id)) plato.habilitado = true
          return plato
        })
      }
    })
  }
}
</script>

<style lang="css">
</style>
