webpackJsonp([14],{

/***/ 100:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "row text-center"
  }, [_c('h2', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.platosFiltrados.length),
      expression: "platosFiltrados.length"
    }]
  }, [_vm._v(_vm._s(this.categoria.nombre.toUpperCase()))]), _vm._v(" "), _vm._l((_vm.platosDistribuidos), function(fila) {
    return _c('div', {
      staticClass: "row col-lg-8 col-lg-offset-2"
    }, _vm._l((fila), function(elem) {
      return _c('plato', {
        key: elem.id,
        attrs: {
          "elem": elem
        }
      })
    }))
  })], 2)
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-32bd36d6", module.exports)
  }
}

/***/ }),

/***/ 115:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(74);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(49)("6f7f08dc", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-32bd36d6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MenuPlatos.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-32bd36d6\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./MenuPlatos.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 55:
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
    'plato': () => __webpack_require__.e/* import() */(13).then(__webpack_require__.bind(null, 85))
  },
  props: ['categoria'],
  data() {
    return {
      // nombre: '',
      divisor: 1,
      resto: 0,
      platos: []
    };
  },
  computed: {
    platosFiltrados() {
      return this.platos.filter(el => el.habilitado);
    },
    platosDistribuidos() {
      let filtrados = this.platos.filter(el => el.habilitado);
      let arr = [];
      while (filtrados.length) {
        arr.push(filtrados.splice(0, this.divisor));
      }
      return arr;
    }
  },
  methods: {
    handleResize() {
      let ancho = window.innerWidth;
      let chico = ancho < 768; // punto de quiebre a xs en bootstrap
      this.divisor = chico ? 3 : 4;
      this.resto = this.platos.length % this.divisor;
    }
  },
  mounted() {

    let ancho = window.innerWidth;
    let chico = ancho < 768; // punto de quiebre a xs en bootstrap
    this.divisor = chico ? 3 : 4;
    this.resto = this.platos.length % this.divisor;
  },
  created() {
    this.platos = this.categoria.platos.map(el => el);

    window.EventBus.$on('deshabilitarPlatos', payload => {
      if (typeof payload === 'number') {
        let encontrado = this.platos.filter(elem => elem.id === payload)[0];
        if (encontrado) encontrado.habilitado = false;
      } else if (Array.isArray(payload)) {
        this.platos = this.platos.map(plato => {
          if (payload.includes(plato.id)) plato.habilitado = false;
          return plato;
        });
      }
    });

    window.EventBus.$on('habilitarPlatos', payload => {
      if (typeof payload === 'number') {
        let encontrado = this.platos.filter(elem => elem.id === payload)[0];
        if (encontrado) encontrado.habilitado = true;
      } else if (Array.isArray(payload)) {
        this.platos = this.platos.map(plato => {
          if (payload.includes(plato.id)) plato.habilitado = true;
          return plato;
        });
      }
    });
  }
});

/***/ }),

/***/ 74:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(42)();
exports.push([module.i, "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", ""]);

/***/ }),

/***/ 84:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(115)

var Component = __webpack_require__(48)(
  /* script */
  __webpack_require__(55),
  /* template */
  __webpack_require__(100),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/juan/Programacion/php/resto/resources/assets/js/components/MenuPlatos.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] MenuPlatos.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-32bd36d6", Component.options)
  } else {
    hotAPI.reload("data-v-32bd36d6", Component.options)
  }
})()}

module.exports = Component.exports


/***/ })

});