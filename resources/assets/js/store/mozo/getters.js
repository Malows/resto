
export default {
  categorias (state) {
    return state.categorias_with_platos.map( categoria => {
      return {
        id: categoria.id,
        nombre: categoria.nombre
      }
    })
  },
  platos (state) {
    return state.categorias_with_platos.reduce( (acc, curr) => acc.concat(curr.platos), [])
  },
  nombreDePlatos (state, getters) {
    let aux = []
    getters.platos.forEach((plato) => {aux[plato.id] = plato.nombre})
    return aux
  }
}
