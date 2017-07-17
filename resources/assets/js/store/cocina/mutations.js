export default {
  SET_PEDIDOS (state, pedidos) {
    state.pedidos = pedidos
  },
  SET_PEDIDO_SELECCIONADO (state, pedido) {
    state.pedido_seleccionado = pedido
  },
  SET_DIGEST (state, digest) {
    state.digest_pedidos = digest
  },
  SET_DIGEST_SELECCIONADO (state, digest) {
    state.digest_seleccionado = digest
  },
  APPEND_PEDIDO (state, pedido) {
    state.pedidos.push(pedido)
  },
  REMOVE_PEDIDO (state, pedido) {
    state.pedidos = state.pedidos.filter( el => pedido.id !== el.id )
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
