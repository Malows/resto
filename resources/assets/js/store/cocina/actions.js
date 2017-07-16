export default {
// Initial and refreshing Actions
  REFRESH_PEDIDOS_PENDIENTES ({ commit }) {
    axios.get(`http://localhost:8000/api/pedidos`).then( response => {
      commit('SET_PEDIDOS', response.data)
    })
  },

  SET_PEDIDO_SELECCIONADO ({ commit }, pedido) {
    commit('SET_PEDIDO_SELECCIONADO', pedido)
  },

// Actions over the modal
  HIDE_MODAL_DESPACHAR ({ commit }) {
    commit('SET_MODAL_DESPACHAR', false)
  },
  SHOW_MODAL_DESPACHAR ({ commit }) {
    commit('SET_MODAL_DESPACHAR', true)
  }
}
