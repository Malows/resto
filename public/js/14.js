webpackJsonp([14],{

/***/ 112:
/***/ (function(module, exports, __webpack_require__) {

module.exports={render:function (){var _vm=this;var _h=_vm.$createElement;var _c=_vm._self._c||_h;
  return _c('div', {
    staticClass: "col-xs-4 col-sm-3 plato",
    on: {
      "click": _vm.toggleImageVisibility
    }
  }, [_c('img', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (_vm.displayPicture),
      expression: "displayPicture"
    }],
    staticClass: "img-responsive",
    attrs: {
      "src": _vm.elem.foto
    }
  }), _vm._v(" "), _c('div', {
    directives: [{
      name: "show",
      rawName: "v-show",
      value: (!_vm.displayPicture),
      expression: "!displayPicture"
    }],
    staticClass: "texto"
  }, [_c('h3', [_vm._v(_vm._s(_vm.elem.nombre))]), _vm._v(" "), (_vm.elem.descripcion) ? _c('h4', [_vm._v(_vm._s(_vm.elem.descripcion))]) : _vm._e(), _vm._v(" "), _c('p', [_vm._v("$" + _vm._s(_vm.elem.precio))])])])
},staticRenderFns: []}
module.exports.render._withStripped = true
if (false) {
  module.hot.accept()
  if (module.hot.data) {
     require("vue-hot-reload-api").rerender("data-v-ae117926", module.exports)
  }
}

/***/ }),

/***/ 126:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(86);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(55)("16070c64", content, false);
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-ae117926\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Plato.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"id\":\"data-v-ae117926\",\"scoped\":false,\"hasInlineConfig\":true}!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Plato.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 63:
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
  props: ['elem'],
  data: function data() {
    return {
      displayPicture: true
    };
  },

  methods: {
    toggleImageVisibility: function toggleImageVisibility() {
      if (this.displayPicture) {
        window.EventBus.$emit('toggleVisibility', this.elem.id);
      } else {
        this.displayPicture = true;
      }
    }
  },
  mounted: function mounted() {
    var _this = this;

    window.EventBus.$on('toggleVisibility', function (id) {
      if (_this.elem.id === id) {
        _this.displayPicture = false;
      } else {
        _this.displayPicture = true;
      }
    });
  }
});

/***/ }),

/***/ 86:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(48)();
exports.push([module.i, "\n.plato {\n  padding: 0;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -ms-flex-line-pack: stretch;\n      align-content: stretch;\n}\n.texto {\n  padding: 1em 0.75em 3em;\n  text-align: center;\n}\n", ""]);

/***/ }),

/***/ 92:
/***/ (function(module, exports, __webpack_require__) {


/* styles */
__webpack_require__(126)

var Component = __webpack_require__(54)(
  /* script */
  __webpack_require__(63),
  /* template */
  __webpack_require__(112),
  /* scopeId */
  null,
  /* cssModules */
  null
)
Component.options.__file = "/home/juan/Programacion/php/resto/resources/assets/js/components/Plato.vue"
if (Component.esModule && Object.keys(Component.esModule).some(function (key) {return key !== "default" && key !== "__esModule"})) {console.error("named exports are not supported in *.vue files.")}
if (Component.options.functional) {console.error("[vue-loader] Plato.vue: functional components are not supported with templates, they should use render functions.")}

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-ae117926", Component.options)
  } else {
    hotAPI.reload("data-v-ae117926", Component.options)
  }
})()}

module.exports = Component.exports


/***/ })

});