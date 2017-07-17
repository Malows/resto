export default {
// Initial and refreshing Actions
  REFRESH_PEDIDOS_PENDIENTES ({ commit }) {
    axios.get(`http://localhost:8000/api/pedidos`).then( response => {
      commit('SET_PEDIDOS', response.data)
    })
    axios.get(`http://localhost:8000/api/digest/pedidos`).then( response => {
      commit('SET_DIGEST', response.data)
    })
  },
  SET_PEDIDO_SELECCIONADO ({ commit }, pedido) {
    commit('SET_PEDIDO_SELECCIONADO', pedido)
  },

// Actions
  DESPACHAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.put(pedido.url_completar).then(response => {
        if ( response.status === 200 ) {
          commit('REMOVE_PEDIDO', response.data)
          commit('SET_PEDIDO_SELECCIONADO', undefined)
          resolve(response)
        }
      })
    });
  },

// Actions over the modal
  HIDE_MODAL_DESPACHAR ({ commit }) {
    commit('SET_MODAL_DESPACHAR', false)
  },
  SHOW_MODAL_DESPACHAR ({ commit }) {
    commit('SET_MODAL_DESPACHAR', true)
  }
}
