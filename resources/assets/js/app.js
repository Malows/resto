
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.EventBus = new window.Vue();
import store from './store/index.js'


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('menu-resto', () => System.import('./components/Menu.vue'));
Vue.component('mesas', () => System.import('./components/pedidos/mesa/ListaMesas.vue'));
Vue.component('lista-pedidos', () => System.import('./components/pedidos/cocina/ListaPedidos.vue'));
Vue.component('lista-pedidos-categoria', () => System.import('./components/pedidos/cocina_digest/ListaPedidosDigest.vue'));
// Vue.component('menu-platos', require('./components/MenuPlatos.vue'));
// Vue.component('plato', require('./components/Plato.vue'));

window.app = new Vue({
    el: '#app',
    store: store
});
