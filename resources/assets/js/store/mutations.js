export default {
  SET_MESA_SELECCIONADA (state, mesa) {
    state.mesa_seleccionada = mesa
  },
  SET_CATEGORIAS_WITH_PLATOS (state, categorias) {
    state.categorias_with_platos = categorias
  },
  SET_MESAS (state, mesas) {
    state.mesas = mesas
  },
  SET_MODAL_ACCIONES(state, value) {
    state.showModalAcciones = value
  },
  SET_MODAL_BORRAR(state, value) {
    state.showModalBorrar = value
  },
  SET_MODAL_COBRAR(state, value) {
    state.showModalCobrar = value
  },
  SET_MODAL_CREAR(state, value) {
    state.showModalCrear = value
  },
  SET_MODAL_EDITAR(state, value) {
    state.showModalEditar = value
  },
  APPEND_MESA(state, mesa) {
    state.mesas.push(mesa)
  },
  REPLACE_MESA (state, mesa) {
    state.mesas.filter( elem => { elem.id === mesa.id })[0] = mesa
  },
  REMOVE_MESA (state, mesa) {
    state.mesa.splice( state.mesa.indexOf( mesa ), 1 )
  },
  // TOGGLE_LOADING (state) {
  //   state.callingAPI = !state.callingAPI
  // },
  // TOGGLE_SEARCHING (state) {
  //   state.searching = (state.searching === '') ? 'loading' : ''
  // },
  // SET_USER (state, user) {
  //   state.user = user
  // },
  // SET_TOKEN (state, token) {
  //   state.token = token
  // },
  // LOGOUT_USER (state) {
  //   state.token = null
  //   state.user = null
  // }
}
