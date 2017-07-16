export default {
  SET_MESA_SELECCIONADA ({ commit }, mesa) {
    commit('SET_MESA_SELECCIONADA', mesa)
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

  // actions de rollback de estados
  ROLLBACK_MESA_SELECCIONADA ({ commit, state }) {
    new Promise(function(resolve, reject) {
      axios.get(state.mesa_seleccionada.url).then( ({ data }) => {
        console.log(data.platos_ids);
        commit('SET_MESA_SELECCIONADA', data)
        // despues del hide, hace un rollback, no debería ser necesario el seteo
        // pero para evitar incosistencias de datos, la re seteo
        commit('REPLACE_MESA', data)
        resolve()
      })
    });
  },

  // actions de modals
  SHOW_MODAL_ACCIONES ({ commit }) {
    commit('SET_MODAL_ACCIONES', true)
  },
  SHOW_MODAL_BORRAR ({ commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_BORRAR', true)
  },
  SHOW_MODAL_COBRAR ({ commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_COBRAR', true)
  },
  SHOW_MODAL_CREAR ({ commit }) {
    commit('SET_MODAL_ACCIONES', false)
    commit('SET_MODAL_CREAR', true)
  },
  SHOW_MODAL_EDITAR ({ commit, state }) {
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
  NUEVO_PEDIDO({ commit }, pedido) {
    return new Promise(function(resolve, reject) {
      axios.post('http://localhost:8000/pedidos/mesas', pedido).then(response => {
        if ( response.status === 200 ) {
          commit('APPEND_MESA', response.data)
          resolve(response)
        } else {
          reject(response.error)
        }
      })
    })
  },
  EDITAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.put(pedido.url_editar).then(response => {
        if ( response.status === 200 ) {
          commit('REPLACE_MESA', response.data)
          commit('SET_MESA_SELECCIONADA', response.data)
          reolve(response)
        } else {
          reject(response.error)
        }
      })
    });
  },
  QUITAR_PLATO_PEDIDO ({ commit }, plato) {
    commit('QUITAR_PLATO_PEDIDO', plato)
  },
  AGREGAR_PLATO_PEDIDO ({ commit }, plato) {
    commit('AGREGAR_PLATO_PEDIDO', plato)
  },
  COBRAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.put(pedido.url_cobrar).then( response => {
        if ( response.status === 200 ) {
          commit('REMOVE_MESA', response.data)
          commit('SET_MESA_SELECCIONADA', undefined)
          resolve(response)
        }
      })
    });
  },
  BORRAR_PEDIDO ({ commit }, pedido) {
    new Promise(function(resolve, reject) {
      axios.delete(pedido.url_borrar).then( response => {
        if ( response.status === 200 ) {
          commit('REMOVE_MESA', response.data)
          commit('SET_MESA_SELECCIONADA', undefined)
          resolve(response)
        }
      })
    });
  },
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
