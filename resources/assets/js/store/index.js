import Vue from 'vue'
import Vuex from 'vuex'
// import state from './state'
// import actions from './actions'
// import mutations from './mutations'
// import getters from './getters'
import mozo from './mozo'
Vue.use(Vuex)

export default new Vuex.Store({
  strict: 'true',
  modules: {
    mozo
  },
  // state,
  // actions,
  // mutations,
  // getters
})
