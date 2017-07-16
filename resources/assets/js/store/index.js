import Vue from 'vue'
import Vuex from 'vuex'
// import state from './state'
// import actions from './actions'
// import mutations from './mutations'
// import getters from './getters'
import mozo from './mozo'
import cocina from './cocina'
Vue.use(Vuex)

export default new Vuex.Store({
  strict: 'true',
  modules: {
    mozo,
    cocina
  },
  // state,
  // actions,
  // mutations,
  // getters
})
