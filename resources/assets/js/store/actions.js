export default {
  SET_MESA_SELECCIONADA ({ commit }, mesa) {
    commit('SET_MESA_SELECCIONADA', mesa)
  },
  SET_PEDIDO_MESA_SELECCIONADA ({ commit }, pedido) {
    commit('SET_PEDIDO_MESA_SELECCIONADA', pedido)
  },
  REFRESH_CATEGORIAS_WITH_PLATOS ({ commit }) {
    axios.get('http://localhost:8000/api/categorias').then(({ data }) => {
      commit('SET_CATEGORIAS_WITH_PLATOS', data)
    })
  },
  REFRESH_MESAS ({ commit }) {
    axios.get('http://localhost:8000/api/mesas').then(({ data }) => {
      commit('SET_MESAS', data)
    })
  },
  REFRESH_PEDIDOS ({ commit }) {
    axios.get('http://localhost:8000/api/pedidos').then( ({ data }) => {
      commit('SET_PEDIDOS', data)
    })
  },

  SHOW_MODAL_ACCIONES ({ dispatch, commit }) {
    commit('SET_MODAL_ACCIONES', true)
  },
  SHOW_MODAL_BORRAR ({ dispatch, commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_BORRAR', true)
  },
  SHOW_MODAL_COBRAR ({ dispatch, commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_COBRAR', true)
  },
  SHOW_MODAL_CREAR ({ dispatch, commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_CREAR', true)
  },
  SHOW_MODAL_EDITAR ({ dispatch, commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_EDITAR',true)
  },
  HIDE_MODAL_ACCIONES ({ commit }) {
    commit('SET_MODAL_ACCIONES', false)
  },
  HIDE_MODAL_BORRAR ({ commit }) {
    commit('SET_MODAL_BORRAR', false)
  },
  HIDE_MODAL_COBRAR ({ commit }) {
    commit('SET_MODAL_COBRAR', false)
  },
  HIDE_MODAL_CREAR ({ commit }) {
    commit('SET_MODAL_CREAR', false)
  },
  HIDE_MODAL_EDITAR ({ commit }) {
    commit('SET_MODAL_EDITAR', false)
  },
  ENVIAR_NUEVO_PEDIDO({ commit }, pedido) {
    return new Promise(function(resolve, reject) {
      axios.post('http://localhost:8000/pedidos/mesas', pedido).then(response => {
        if ( response.status === 200 ) {
          commit('APPEND_PEDIDO', response.data)
        }
        resolve(response)
      })
    })
  },
  AGREGAR_NUEVA_MESA ({ commit }, mesa) {
    commit('APPEND_MESA', mesa)
  },
  EDITAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.put(`http://localhost:8000/pedido/mesas/${pedido.id}`).then(response => {
        if ( response.status === 200 ) {
          commit('REPLACE_PEDIDO', pedido)
          reolve(response)
        }
      })
    });
  },
  EDITAR_MESA_Y_LISTA ({ commit }, mesa) {
    axios.get(`http://localhost:8000/api/pedidos/${mesa.id}`).then(response => {
      if ( response.status === 200 ) {
        commit('SET_MESA_SELECCIONADA', mesa)
        commit('SET_PEDIDO_MESA_SELECCIONADA', response.data)
        commit('REPLACE_MESA', mesa)
      }
    })
  },
  COBRAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.put(`http://localhost:8000/pedido/mesas/${pedido.id}/cobrar`).then( response => {
        if ( response.status === 200 ) {
          commit('REMOVE_MESA', pedido)
          commit('REMOVE_PEDIDO', pedido)
          commit('SET_MESA_SELECCIONADA', undefined)
          commit('SET_PEDIDO_MESA_SELECCIONADA', undefined)
        }
      })
    });
  }
  // LOGOUT_USER ({ commit }) {
  //   window.localStorage.clear()
  //   commit('LOGOUT_USER')
  // },
  // SET_USER ({ commit }, user) {
  //   var aux = fillUser(user)
  //   commit('SET_USER', aux)
  // },
  // CHECK_CREDENTIALS ({ commit, state }) {
  //   // Check local storage to handle refreshes
  //   if (window.localStorage) {
  //     let token = window.localStorage.getItem('token')
  //     let header = {
  //       'Accept': 'application/json',
  //       'Authorization': token
  //     }
  //     axios.get(URL + '/api/user', {headers: header})
  //     .then(response => {
  //       var user = fillUser(response.data)
  //       window.localStorage.setItem('user', JSON.stringify(user))
  //       if (user && state.user !== user) {
  //         commit('SET_USER', user)
  //         commit('SET_TOKEN', token)
  //       }
  //     })
  //     .catch((err) => {
  //       if (err.message === 'Network Error') {
  //         console.error('Revise su conexión de internet, si el error persiste, consulte a los administradores del sistema')
  //       }
  //     })
  //   }
  // }
}
