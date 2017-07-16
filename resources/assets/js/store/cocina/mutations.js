export default {
  SET_PEDIDOS (state, pedidos) {
    state.pedidos = pedidos
  },
  SET_PEDIDO_SELECCIONADO (state, pedido) {
    state.pedido_seleccionado = pedido
  },
  APPEND_PEDIDO (state, pedido) {
    state.pedidos.push(pedido)
  },
  REMOVE_PEDIDO (state, pedido) {
    let aux = state.pedidos.filter( el => pedido.id === el.id)[0]
    state.pedidos.splice( state.pedidos.indexOf(aux), 1)
  },
  REPLACE_PEDIDO (state, pedido) {
    state.pedidos = state.pedidos.map( el => {
      if ( el.id === pedido.id ) {
        return pedido
      } else {
        return el
      }
    })
  },
  SET_MODAL_DESPACHAR (state, value) {
    state.showModalDespachar = value
  }
}
