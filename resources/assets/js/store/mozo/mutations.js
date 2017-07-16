export default {
  // mutators setters
  SET_MESA_SELECCIONADA (state, mesa) {
    state.mesa_seleccionada = mesa
  },
  SET_CATEGORIAS_WITH_PLATOS (state, categorias) {
    state.categorias_with_platos = categorias
  },
  SET_MESAS (state, mesas) {
    state.mesas = mesas
  },

  // mutators de los modals
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

  // mutators de las mesas
  APPEND_MESA(state, mesa) {
    state.mesas.push(mesa)
  },
  REPLACE_MESA (state, mesa) {
    state.mesas = state.mesas.map( elem => {
      if ( elem.id === mesa.id ) {
        return mesa
      } else {
        return elem
      }
    })
  },
  REMOVE_MESA (state, mesa) {
    let elem = state.mesas.filter(el => el.id === mesa.id)[0]
    state.mesas.splice( state.mesas.indexOf( elem ), 1 )
  },
  QUITAR_PLATO_PEDIDO (state, plato) {
    state.mesa_seleccionada.platos_ids.splice( state.mesa_seleccionada.platos_ids.indexOf(plato), 1)
  },
  AGREGAR_PLATO_PEDIDO (state, plato) {
    state.mesa_seleccionada.platos_ids.push(plato)
    state.mesa_seleccionada.platos_ids.sort((a,b) => a-b)
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
