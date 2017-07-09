<template>
  <div v-on:click="toggleImageVisibility" class="col-xs-4 col-sm-3 plato">
    <img :src="elem.foto" class="img-responsive" v-show="displayPicture">
    <div v-show="!displayPicture" class="texto">
      <h3>{{elem.nombre}}</h3>
      <h4 v-if="elem.descripcion">{{elem.descripcion}}</h4>
      <p>${{elem.precio}}</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ['elem'],
  data () {
    return {
      displayPicture: true
    }
  },
  methods: {
    toggleImageVisibility () {
      if (this.displayPicture) {
        window.EventBus.$emit('toggleVisibility', this.elem.id)
      } else {
        this.displayPicture = true
      }
    }
  },
  mounted () {
    window.EventBus.$on('toggleVisibility', (id) => {
      if (this.elem.id === id) {
        this.displayPicture = false
      } else {
        this.displayPicture = true
      }
    })
  }
}
</script>

<style>
.plato {
  padding: 0;
  display: flex;
  align-content: stretch;
}
.texto {
  padding: 1em 0.75em 3em;
  text-align: center;
}
</style>
