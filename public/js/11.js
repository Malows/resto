webpackJsonp([11],{

/***/ 107:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "box",
    on: {
      "click": _vm.clickOnPedido
    }
  }, [_c('p', [_vm._v("Mozo: "), _c('strong', [_vm._v(_vm._s(_vm.data.mozo.name))]), _vm._v(" - " + _vm._s(_vm.totalDeCosas) + " " + _vm._s(_vm.totalDeCosas > 1 ? 'cosas' : 'cosa'))]), _vm._v(" "), _c('div', {
    staticClass: "row"
  }, _vm._l((_vm.data.platos), function(plato) {
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
     require("vue-hot-reload-api").rerender("data-v-cf3f9aca", module.exports)
  }
}

/***/ }),

/***/ 121:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(80);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(49)("62c00d59", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-cf3f9aca\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Pedido.vue", function() {
     var newContent = require("!!../../../../../../node_modules/css-loader/index.js!../../../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-cf3f9aca\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Pedido.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 59:
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

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    'plato': function plato() {
      return __webpack_require__.e/* import() */(4/* duplicate */).then(__webpack_require__.bind(null, 53));
    }
  },
  props: ['pedido'],
  data: function data() {
    return {
      data: {
        mozo: {
          name: ''
        },
        platos: []
      }
    };
  },

  methods: {
    clickOnPedido: function clickOnPedido() {
      this.$emit('clickEnPedido', this.data);
    }
  },
  computed: {
    totalDeCosas: function totalDeCosas() {
      return this.data.platos.reduce(function (carry, current) {
        return carry + current.cantidad;
      }, 0);
    }
  },
  created: function created() {
    var _this = this;

    axios.get(this.pedido.url).then(function (_ref) {
      var data = _ref.data;

      _this.data = data;
    });
  }
});

/***/ }),

/***/ 80:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(42)();
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

/***/ }),

/***/ 87:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(121)

var Component = __webpack_require__(48)(
  /* script */
  __webpack_require__(59),
  /* template */
  __webpack_require__(107),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/juan/Programacion/php/resto/resources/assets/js/components/pedidos/cocina/Pedido.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Pedido.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-cf3f9aca", Component.options)
  } else {
    hotAPI.reload("data-v-cf3f9aca", Component.options)
  }
})()}

module.exports = Component.exports


/***/ })

});