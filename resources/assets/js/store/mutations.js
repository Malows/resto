export default {
  SET_MESA_SELECCIONADA (state, mesa) {
    state.mesa_seleccionada = mesa
  },
  SET_PEDIDO_MESA_SELECCIONADA (state, pedido) {
    state.pedido_mesa_seleccionada = pedido
  },
  SET_CATEGORIAS_WITH_PLATOS (state, categorias) {
    state.categorias_with_platos = categorias
  },
  SET_MESAS (state, mesas) {
    state.mesas = mesas
  },
  SET_PEDIDOS (state, pedidos) {
    state.pedidos = pedidos
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
