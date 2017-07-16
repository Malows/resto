webpackJsonp([15],{

/***/ 61:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    'plato': function plato() {
      return __webpack_require__.e/* import() */(4).then(__webpack_require__.bind(null, 54));
    }
  },
  props: ['categoria']
});

/***/ }),

/***/ 89:
/***/ (function(module, exports, __webpack_require__) {

var Component = __webpack_require__(49)(
  /* script */
  __webpack_require__(61),
  /* template */
  __webpack_require__(98),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/juan/Programacion/php/resto/resources/assets/js/components/pedidos/cocina_digest/Categoria.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Categoria.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-0d9fc224", Component.options)
  } else {
    hotAPI.reload("data-v-0d9fc224", Component.options)
  }
})()}

module.exports = Component.exports


/***/ }),

/***/ 98:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.categoria.total),
      expression: "categoria.total"
    }],
    staticClass: "box"
  }, [_c('h2', {
    staticClass: "title"
  }, [_vm._v(_vm._s(_vm.categoria.nombre.toUpperCase()))]), _vm._v(" "), _c('h4', {
    staticClass: "subtitle"
  }, [_vm._v(_vm._s(((_vm.categoria.total) + " cosa" + (_vm.categoria.total>2 ? 's': ''))))]), _vm._v(" "), _c('hr'), _vm._v(" "), _c('div', {
    staticClass: "row"
  }, _vm._l((_vm.categoria.platos), function(plato) {
    return _c('plato', {
      key: plato.id,
      attrs: {
        "plato": plato
      }
    })
  }))])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-0d9fc224", module.exports)
  }
}

/***/ })

});