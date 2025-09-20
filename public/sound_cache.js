/******/ (() => { // webpackBootstrap
/*!*************************************!*\
  !*** ./resources/js/sound_cache.js ***!
  \*************************************/
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
var CACHE_NAME = "sound-cache";
var cachingFinished = false; // track if caching is done
var cachingPromise = null; // track install process
var urlParams = new URL(self.location).searchParams;
var BASE_URL = urlParams.get("baseUrl");
var AUDIO_BASE_URL = "".concat(BASE_URL, "/sound/");

// Huruf A-Z
var letters = Array.from({
  length: 26
}, function (_, i) {
  return String.fromCharCode(65 + i);
});
// Angka 0-9
var numbers = Array.from({
  length: 10
}, function (_, i) {
  return String(i);
});
var custom = ['akupresur', 'bpu', 'caten', 'farmasi', 'gigi', 'haji', 'ims', 'jiwa gizi', 'lab', 'lansia', 'loket', 'mtbs', 'nomor_antrian', 'pkpr', 'poli', 'polijiwagizi', 'psikolog', 'ptm', 'ruang', 'silahkan_menuju', 'surveilans'];
// Gabungkan
var alphanumeric = [].concat(letters, numbers, custom);

// Daftar asset
var ASSETS_TO_CACHE = alphanumeric.map(function (el) {
  return "".concat(AUDIO_BASE_URL).concat(el, ".mp3");
});
function sendMessageToClients(msg) {
  self.clients.matchAll({
    includeUncontrolled: true
  }).then(function (clients) {
    clients.forEach(function (client) {
      return client.postMessage(msg);
    });
  });
}
self.addEventListener("install", function (event) {
  cachingPromise = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
    var cache, loaded, _iterator, _step, file, match, response, _t, _t2;
    return _regenerator().w(function (_context) {
      while (1) switch (_context.p = _context.n) {
        case 0:
          _context.n = 1;
          return caches.open(CACHE_NAME);
        case 1:
          cache = _context.v;
          loaded = 0;
          _iterator = _createForOfIteratorHelper(ASSETS_TO_CACHE);
          _context.p = 2;
          _iterator.s();
        case 3:
          if ((_step = _iterator.n()).done) {
            _context.n = 13;
            break;
          }
          file = _step.value;
          _context.p = 4;
          _context.n = 5;
          return cache.match(file);
        case 5:
          match = _context.v;
          if (match) {
            _context.n = 9;
            break;
          }
          _context.n = 6;
          return fetch(file, {
            cache: "no-cache"
          });
        case 6:
          response = _context.v;
          if (!response.ok) {
            _context.n = 8;
            break;
          }
          _context.n = 7;
          return cache.put(file, response.clone());
        case 7:
          console.log("✅ Cached:", file);
          _context.n = 9;
          break;
        case 8:
          console.warn("⚠️ Gagal fetch:", file, response.status);
        case 9:
          _context.n = 11;
          break;
        case 10:
          _context.p = 10;
          _t = _context.v;
          console.error("❌ Error cache:", file, _t);
        case 11:
          loaded++;
          sendMessageToClients({
            type: "CACHE_PROGRESS",
            loaded: loaded,
            total: ASSETS_TO_CACHE.length
          });
        case 12:
          _context.n = 3;
          break;
        case 13:
          _context.n = 15;
          break;
        case 14:
          _context.p = 14;
          _t2 = _context.v;
          _iterator.e(_t2);
        case 15:
          _context.p = 15;
          _iterator.f();
          return _context.f(15);
        case 16:
          // Apapun hasilnya, tetap kirim selesai
          cachingFinished = true;
          sendMessageToClients({
            type: "CACHE_DONE"
          });
        case 17:
          return _context.a(2);
      }
    }, _callee, null, [[4, 10], [2, 14, 15, 16]]);
  }))();
  event.waitUntil(cachingPromise);
  self.skipWaiting();
});
self.addEventListener("activate", function (event) {
  event.waitUntil(clients.claim());
});
self.addEventListener("message", /*#__PURE__*/function () {
  var _ref2 = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2(event) {
    var _event$data;
    var cache, keys;
    return _regenerator().w(function (_context2) {
      while (1) switch (_context2.n) {
        case 0:
          if (!(((_event$data = event.data) === null || _event$data === void 0 ? void 0 : _event$data.type) === "CHECK_CACHE")) {
            _context2.n = 3;
            break;
          }
          _context2.n = 1;
          return caches.open(CACHE_NAME);
        case 1:
          cache = _context2.v;
          _context2.n = 2;
          return cache.keys();
        case 2:
          keys = _context2.v;
          // Always report progress
          sendMessageToClients({
            type: "CACHE_PROGRESS",
            loaded: keys.length,
            total: ASSETS_TO_CACHE.length
          });
          if (cachingFinished) {
            // already done → safe to send done
            sendMessageToClients({
              type: "CACHE_DONE"
            });
          } else if (cachingPromise) {
            // wait until cachingPromise resolves
            cachingPromise.then(function () {
              sendMessageToClients({
                type: "CACHE_DONE"
              });
            });
          }
        case 3:
          return _context2.a(2);
      }
    }, _callee2);
  }));
  return function (_x) {
    return _ref2.apply(this, arguments);
  };
}());
/******/ })()
;