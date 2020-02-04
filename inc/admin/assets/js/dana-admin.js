"use strict";

function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
    }
    return _typeof(obj);
}
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = b(a, a.document);
    a.lazySizes = c, "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports && (module.exports = c);
}(window, function (a, b) {
    "use strict";
    if (b.getElementsByClassName) {
        var c,
            d,
            e = b.documentElement,
            f = a.Date,
            g = a.HTMLPictureElement,
            h = "addEventListener",
            i = "getAttribute",
            j = a[h],
            k = a.setTimeout,
            l = a.requestAnimationFrame || k,
            m = a.requestIdleCallback,
            n = /^picture$/i,
            o = ["load", "error", "lazyincluded", "_lazyloaded"],
            p = {},
            q = Array.prototype.forEach,
            r = function r(a, b) {
                return p[b] || (p[b] = new RegExp("(\\s|^)" + b + "(\\s|$)")), p[b].test(a[i]("class") || "") && p[b];
            },
            s = function s(a, b) {
                r(a, b) || a.setAttribute("class", (a[i]("class") || "").trim() + " " + b);
            },
            t = function t(a, b) {
                var c;
                (c = r(a, b)) && a.setAttribute("class", (a[i]("class") || "").replace(c, " "));
            },
            u = function u(a, b, c) {
                var d = c ? h : "removeEventListener";
                c && u(a, b), o.forEach(function (c) {
                    a[d](c, b);
                });
            },
            v = function v(a, d, e, f, g) {
                var h = b.createEvent("Event");
                return e || (e = {}), e.instance = c, h.initEvent(d, !f, !g), h.detail = e, a.dispatchEvent(h), h;
            },
            w = function w(b, c) {
                var e;
                !g && (e = a.picturefill || d.pf) ? (c && c.src && !b[i]("srcset") && b.setAttribute("srcset", c.src), e({
                    reevaluate: !0,
                    elements: [b]
                })) : c && c.src && (b.src = c.src);
            },
            x = function x(a, b) {
                return (getComputedStyle(a, null) || {})[b];
            },
            y = function y(a, b, c) {
                for (c = c || a.offsetWidth; c < d.minSize && b && !a._lazysizesWidth;) {
                    c = b.offsetWidth, b = b.parentNode;
                }
                return c;
            },
            z = function () {
                var a,
                    c,
                    d = [],
                    e = [],
                    f = d,
                    g = function g() {
                        var b = f;
                        for (f = d.length ? e : d, a = !0, c = !1; b.length;) {
                            b.shift()();
                        }
                        a = !1;
                    },
                    h = function h(d, e) {
                        a && !e ? d.apply(this, arguments) : (f.push(d), c || (c = !0, (b.hidden ? k : l)(g)));
                    };
                return h._lsFlush = g, h;
            }(),
            A = function A(a, b) {
                return b ? function () {
                    z(a);
                } : function () {
                    var b = this,
                        c = arguments;
                    z(function () {
                        a.apply(b, c);
                    });
                };
            },
            B = function B(a) {
                var b,
                    c = 0,
                    e = d.throttleDelay,
                    g = d.ricTimeout,
                    h = function h() {
                        b = !1, c = f.now(), a();
                    },
                    i = m && g > 49 ? function () {
                        m(h, {
                            timeout: g
                        }), g !== d.ricTimeout && (g = d.ricTimeout);
                    } : A(function () {
                        k(h);
                    }, !0);
                return function (a) {
                    var d;
                    (a = !0 === a) && (g = 33), b || (b = !0, d = e - (f.now() - c), d < 0 && (d = 0), a || d < 9 ? i() : k(i, d));
                };
            },
            C = function C(a) {
                var b,
                    c,
                    d = 99,
                    e = function e() {
                        b = null, a();
                    },
                    g = function g() {
                        var a = f.now() - c;
                        a < d ? k(g, d - a) : (m || e)(e);
                    };
                return function () {
                    c = f.now(), b || (b = k(g, d));
                };
            };
        ! function () {
            var b,
                c = {
                    lazyClass: "lazyload",
                    loadedClass: "lazyloaded",
                    loadingClass: "lazyloading",
                    preloadClass: "lazypreload",
                    errorClass: "lazyerror",
                    autosizesClass: "lazyautosizes",
                    srcAttr: "data-src",
                    srcsetAttr: "data-srcset",
                    sizesAttr: "data-sizes",
                    minSize: 40,
                    customMedia: {},
                    init: !0,
                    expFactor: 1.5,
                    hFac: .8,
                    loadMode: 2,
                    loadHidden: !0,
                    ricTimeout: 0,
                    throttleDelay: 125
                };
            d = a.lazySizesConfig || a.lazysizesConfig || {};
            for (b in c) {
                b in d || (d[b] = c[b]);
            }
            a.lazySizesConfig = d, k(function () {
                d.init && F();
            });
        }();
        var D = function () {
                var g,
                    l,
                    m,
                    o,
                    p,
                    y,
                    D,
                    F,
                    G,
                    H,
                    I,
                    J,
                    K = /^img$/i,
                    L = /^iframe$/i,
                    M = "onscroll" in a && !/(gle|ing)bot/.test(navigator.userAgent),
                    N = 0,
                    O = 0,
                    P = 0,
                    Q = -1,
                    R = function R(a) {
                        P--, (!a || P < 0 || !a.target) && (P = 0);
                    },
                    S = function S(a) {
                        return null == J && (J = "hidden" == x(b.body, "visibility")), J || "hidden" != x(a.parentNode, "visibility") && "hidden" != x(a, "visibility");
                    },
                    T = function T(a, c) {
                        var d,
                            f = a,
                            g = S(a);
                        for (F -= c, I += c, G -= c, H += c; g && (f = f.offsetParent) && f != b.body && f != e;) {
                            (g = (x(f, "opacity") || 1) > 0) && "visible" != x(f, "overflow") && (d = f.getBoundingClientRect(), g = H > d.left && G < d.right && I > d.top - 1 && F < d.bottom + 1);
                        }
                        return g;
                    },
                    U = function U() {
                        var a,
                            f,
                            h,
                            j,
                            k,
                            m,
                            n,
                            p,
                            q,
                            r,
                            s,
                            t,
                            u = c.elements;
                        if ((o = d.loadMode) && P < 8 && (a = u.length)) {
                            for (f = 0, Q++, r = !d.expand || d.expand < 1 ? e.clientHeight > 500 && e.clientWidth > 500 ? 500 : 370 : d.expand, c._defEx = r, s = r * d.expFactor, t = d.hFac, J = null, O < s && P < 1 && Q > 2 && o > 2 && !b.hidden ? (O = s, Q = 0) : O = o > 1 && Q > 1 && P < 6 ? r : N; f < a; f++) {
                                if (u[f] && !u[f]._lazyRace)
                                    if (M) {
                                        if ((p = u[f][i]("data-expand")) && (m = 1 * p) || (m = O), q !== m && (y = innerWidth + m * t, D = innerHeight + m, n = -1 * m, q = m), h = u[f].getBoundingClientRect(), (I = h.bottom) >= n && (F = h.top) <= D && (H = h.right) >= n * t && (G = h.left) <= y && (I || H || G || F) && (d.loadHidden || S(u[f])) && (l && P < 3 && !p && (o < 3 || Q < 4) || T(u[f], m))) {
                                            if (aa(u[f]), k = !0, P > 9) break;
                                        } else !k && l && !j && P < 4 && Q < 4 && o > 2 && (g[0] || d.preloadAfterLoad) && (g[0] || !p && (I || H || G || F || "auto" != u[f][i](d.sizesAttr))) && (j = g[0] || u[f]);
                                    } else aa(u[f]);
                            }
                            j && !k && aa(j);
                        }
                    },
                    V = B(U),
                    W = function W(a) {
                        var b = a.target;
                        if (b._lazyCache) return void delete b._lazyCache;
                        R(a), s(b, d.loadedClass), t(b, d.loadingClass), u(b, Y), v(b, "lazyloaded");
                    },
                    X = A(W),
                    Y = function Y(a) {
                        X({
                            target: a.target
                        });
                    },
                    Z = function Z(a, b) {
                        try {
                            a.contentWindow.location.replace(b);
                        } catch (c) {
                            a.src = b;
                        }
                    },
                    $ = function $(a) {
                        var b,
                            c = a[i](d.srcsetAttr);
                        (b = d.customMedia[a[i]("data-media") || a[i]("media")]) && a.setAttribute("media", b), c && a.setAttribute("srcset", c);
                    },
                    _ = A(function (a, b, c, e, f) {
                        var g, h, j, l, o, p;
                        (o = v(a, "lazybeforeunveil", b)).defaultPrevented || (e && (c ? s(a, d.autosizesClass) : a.setAttribute("sizes", e)), h = a[i](d.srcsetAttr), g = a[i](d.srcAttr), f && (j = a.parentNode, l = j && n.test(j.nodeName || "")), p = b.firesLoad || "src" in a && (h || g || l), o = {
                            target: a
                        }, s(a, d.loadingClass), p && (clearTimeout(m), m = k(R, 2500), u(a, Y, !0)), l && q.call(j.getElementsByTagName("source"), $), h ? a.setAttribute("srcset", h) : g && !l && (L.test(a.nodeName) ? Z(a, g) : a.src = g), f && (h || l) && w(a, {
                            src: g
                        })), a._lazyRace && delete a._lazyRace, t(a, d.lazyClass), z(function () {
                            var b = a.complete && a.naturalWidth > 1;
                            p && !b || (b && s(a, "ls-is-cached"), W(o), a._lazyCache = !0, k(function () {
                                "_lazyCache" in a && delete a._lazyCache;
                            }, 9));
                        }, !0);
                    }),
                    aa = function aa(a) {
                        var b,
                            c = K.test(a.nodeName),
                            e = c && (a[i](d.sizesAttr) || a[i]("sizes")),
                            f = "auto" == e;
                        (!f && l || !c || !a[i]("src") && !a.srcset || a.complete || r(a, d.errorClass) || !r(a, d.lazyClass)) && (b = v(a, "lazyunveilread").detail, f && E.updateElem(a, !0, a.offsetWidth), a._lazyRace = !0, P++, _(a, b, f, e, c));
                    },
                    ba = function ba() {
                        if (!l) {
                            if (f.now() - p < 999) return void k(ba, 999);
                            var a = C(function () {
                                d.loadMode = 3, V();
                            });
                            l = !0, d.loadMode = 3, V(), j("scroll", function () {
                                3 == d.loadMode && (d.loadMode = 2), a();
                            }, !0);
                        }
                    };
                return {
                    _: function _() {
                        p = f.now(), c.elements = b.getElementsByClassName(d.lazyClass), g = b.getElementsByClassName(d.lazyClass + " " + d.preloadClass), j("scroll", V, !0), j("resize", V, !0), a.MutationObserver ? new MutationObserver(V).observe(e, {
                            childList: !0,
                            subtree: !0,
                            attributes: !0
                        }) : (e[h]("DOMNodeInserted", V, !0), e[h]("DOMAttrModified", V, !0), setInterval(V, 999)), j("hashchange", V, !0), ["focus", "mouseover", "click", "load", "transitionend", "animationend", "webkitAnimationEnd"].forEach(function (a) {
                            b[h](a, V, !0);
                        }), /d$|^c/.test(b.readyState) ? ba() : (j("load", ba), b[h]("DOMContentLoaded", V), k(ba, 2e4)), c.elements.length ? (U(), z._lsFlush()) : V();
                    },
                    checkElems: V,
                    unveil: aa
                };
            }(),
            E = function () {
                var a,
                    c = A(function (a, b, c, d) {
                        var e, f, g;
                        if (a._lazysizesWidth = d, d += "px", a.setAttribute("sizes", d), n.test(b.nodeName || ""))
                            for (e = b.getElementsByTagName("source"), f = 0, g = e.length; f < g; f++) {
                                e[f].setAttribute("sizes", d);
                            }
                        c.detail.dataAttr || w(a, c.detail);
                    }),
                    e = function e(a, b, d) {
                        var e,
                            f = a.parentNode;
                        f && (d = y(a, f, d), e = v(a, "lazybeforesizes", {
                            width: d,
                            dataAttr: !!b
                        }), e.defaultPrevented || (d = e.detail.width) && d !== a._lazysizesWidth && c(a, f, e, d));
                    },
                    f = function f() {
                        var b,
                            c = a.length;
                        if (c)
                            for (b = 0; b < c; b++) {
                                e(a[b]);
                            }
                    },
                    g = C(f);
                return {
                    _: function _() {
                        a = b.getElementsByClassName(d.autosizesClass), j("resize", g);
                    },
                    checkElems: g,
                    updateElem: e
                };
            }(),
            F = function F() {
                F.i || (F.i = !0, E._(), D._());
            };
        return c = {
            cfg: d,
            autoSizer: E,
            loader: D,
            init: F,
            uP: w,
            aC: s,
            rC: t,
            hC: r,
            fire: v,
            gW: y,
            rAF: z
        };
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    
    function d() {
        this.ratioElems = b.getElementsByClassName("lazyaspectratio"), this._setupEvents(), this.processImages();
    }
    if (a.addEventListener) {
        var e,
            f,
            g,
            h = Array.prototype.forEach,
            i = /^picture$/i,
            j = "data-aspectratio",
            k = "img[" + j + "]",
            _l = function l(b) {
                return a.matchMedia ? (_l = function l(a) {
                    return !a || (matchMedia(a) || {}).matches;
                })(b) : a.Modernizr && Modernizr.mq ? !b || Modernizr.mq(b) : !b;
            },
            m = c.aC,
            n = c.rC,
            o = c.cfg;
        d.prototype = {
            _setupEvents: function _setupEvents() {
                var a = this,
                    c = function c(b) {
                        b.naturalWidth < 36 ? a.addAspectRatio(b, !0) : a.removeAspectRatio(b, !0);
                    },
                    d = function d() {
                        a.processImages();
                    };
                b.addEventListener("load", function (a) {
                    a.target.getAttribute && a.target.getAttribute(j) && c(a.target);
                }, !0), addEventListener("resize", function () {
                    var b,
                        d = function d() {
                            h.call(a.ratioElems, c);
                        };
                    return function () {
                        clearTimeout(b), b = setTimeout(d, 99);
                    };
                }()), b.addEventListener("DOMContentLoaded", d), addEventListener("load", d);
            },
            processImages: function processImages(a) {
                var c, d;
                a || (a = b), c = "length" in a && !a.nodeName ? a : a.querySelectorAll(k);
                for (d = 0; d < c.length; d++) {
                    c[d].naturalWidth > 36 ? this.removeAspectRatio(c[d]) : this.addAspectRatio(c[d]);
                }
            },
            getSelectedRatio: function getSelectedRatio(a) {
                var b,
                    c,
                    d,
                    e,
                    f,
                    g = a.parentNode;
                if (g && i.test(g.nodeName || ""))
                    for (d = g.getElementsByTagName("source"), b = 0, c = d.length; b < c; b++) {
                        if (e = d[b].getAttribute("data-media") || d[b].getAttribute("media"), o.customMedia[e] && (e = o.customMedia[e]), _l(e)) {
                            f = d[b].getAttribute(j);
                            break;
                        }
                    }
                return f || a.getAttribute(j) || "";
            },
            parseRatio: function () {
                var a = /^\s*([+\d\.]+)(\s*[\/x]\s*([+\d\.]+))?\s*$/,
                    b = {};
                return function (c) {
                    var d;
                    return !b[c] && (d = c.match(a)) && (d[3] ? b[c] = d[1] / d[3] : b[c] = 1 * d[1]), b[c];
                };
            }(),
            addAspectRatio: function addAspectRatio(b, c) {
                var d,
                    e = b.offsetWidth,
                    f = b.offsetHeight;
                if (c || m(b, "lazyaspectratio"), e < 36 && f <= 0) return void((e || f && a.console) && console.log("Define width or height of image, so we can calculate the other dimension"));
                d = this.getSelectedRatio(b), (d = this.parseRatio(d)) && (e ? b.style.height = e / d + "px" : b.style.width = f * d + "px");
            },
            removeAspectRatio: function removeAspectRatio(a) {
                n(a, "lazyaspectratio"), a.style.height = "", a.style.width = "", a.removeAttribute(j);
            }
        }, f = function f() {
            g = a.jQuery || a.Zepto || a.shoestring || a.$, g && g.fn && !g.fn.imageRatio && g.fn.filter && g.fn.add && g.fn.find ? g.fn.imageRatio = function () {
                return e.processImages(this.find(k).add(this.filter(k))), this;
            } : g = !1;
        }, f(), setTimeout(f), e = new d(), a.imageRatio = e, "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? module.exports = e : "function" == typeof define && define.amd && define(e);
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    if (a.addEventListener) {
        var d = /\s+/g,
            e = /\s*\|\s+|\s+\|\s*/g,
            f = /^(.+?)(?:\s+\[\s*(.+?)\s*\])(?:\s+\[\s*(.+?)\s*\])?$/,
            g = /^\s*\(*\s*type\s*:\s*(.+?)\s*\)*\s*$/,
            h = /\(|\)|'/,
            i = {
                contain: 1,
                cover: 1
            },
            j = function j(a) {
                var b = c.gW(a, a.parentNode);
                return (!a._lazysizesWidth || b > a._lazysizesWidth) && (a._lazysizesWidth = b), a._lazysizesWidth;
            },
            k = function k(a) {
                var b;
                return b = (getComputedStyle(a) || {
                    getPropertyValue: function getPropertyValue() {}
                }).getPropertyValue("background-size"), !i[b] && i[a.style.backgroundSize] && (b = a.style.backgroundSize), b;
            },
            l = function l(a, b) {
                if (b) {
                    var c = b.match(g);
                    c && c[1] ? a.setAttribute("type", c[1]) : a.setAttribute("media", lazySizesConfig.customMedia[b] || b);
                }
            },
            m = function m(a, c, g) {
                var h = b.createElement("picture"),
                    i = c.getAttribute(lazySizesConfig.sizesAttr),
                    j = c.getAttribute("data-ratio"),
                    k = c.getAttribute("data-optimumx");
                c._lazybgset && c._lazybgset.parentNode == c && c.removeChild(c._lazybgset), Object.defineProperty(g, "_lazybgset", {
                    value: c,
                    writable: !0
                }), Object.defineProperty(c, "_lazybgset", {
                    value: h,
                    writable: !0
                }), a = a.replace(d, " ").split(e), h.style.display = "none", g.className = lazySizesConfig.lazyClass, 1 != a.length || i || (i = "auto"), a.forEach(function (a) {
                    var c,
                        d = b.createElement("source");
                    i && "auto" != i && d.setAttribute("sizes", i), (c = a.match(f)) ? (d.setAttribute(lazySizesConfig.srcsetAttr, c[1]), l(d, c[2]), l(d, c[3])) : d.setAttribute(lazySizesConfig.srcsetAttr, a), h.appendChild(d);
                }), i && (g.setAttribute(lazySizesConfig.sizesAttr, i), c.removeAttribute(lazySizesConfig.sizesAttr), c.removeAttribute("sizes")), k && g.setAttribute("data-optimumx", k), j && g.setAttribute("data-ratio", j), h.appendChild(g), c.appendChild(h);
            },
            n = function n(a) {
                if (a.target._lazybgset) {
                    var b = a.target,
                        d = b._lazybgset,
                        e = b.currentSrc || b.src;
                    if (e) {
                        var f = c.fire(d, "bgsetproxy", {
                            src: e,
                            useSrc: h.test(e) ? JSON.stringify(e) : e
                        });
                        f.defaultPrevented || (d.style.backgroundImage = "url(" + f.detail.useSrc + ")");
                    }
                    b._lazybgsetLoading && (c.fire(d, "_lazyloaded", {}, !1, !0), delete b._lazybgsetLoading);
                }
            };
        addEventListener("lazybeforeunveil", function (a) {
            var d, e, f;
            !a.defaultPrevented && (d = a.target.getAttribute("data-bgset")) && (f = a.target, e = b.createElement("img"), e.alt = "", e._lazybgsetLoading = !0, a.detail.firesLoad = !0, m(d, f, e), setTimeout(function () {
                c.loader.unveil(e), c.rAF(function () {
                    c.fire(e, "_lazyloaded", {}, !0, !0), e.complete && n({
                        target: e
                    });
                });
            }));
        }), b.addEventListener("load", n, !0), a.addEventListener("lazybeforesizes", function (a) {
            if (a.detail.instance == c && a.target._lazybgset && a.detail.dataAttr) {
                var b = a.target._lazybgset,
                    d = k(b);
                i[d] && (a.target._lazysizesParentFit = d, c.rAF(function () {
                    a.target.setAttribute("data-parent-fit", d), a.target._lazysizesParentFit && delete a.target._lazysizesParentFit;
                }));
            }
        }, !0), b.documentElement.addEventListener("lazybeforesizes", function (a) {
            !a.defaultPrevented && a.target._lazybgset && a.detail.instance == c && (a.detail.width = j(a.target._lazybgset));
        });
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    var d = [].slice,
        e = /blur-up["']*\s*:\s*["']*(always|auto)/,
        f = /image\/(jpeg|png|gif|svg\+xml)/,
        g = function g(b) {
            var d = b.getAttribute("data-media") || b.getAttribute("media"),
                e = b.getAttribute("type");
            return (!e || f.test(e)) && (!d || a.matchMedia(c.cfg.customMedia[d] || d).matches);
        },
        h = function h(a, b) {
            var c;
            return (a ? d.call(a.querySelectorAll("source, img")) : [b]).forEach(function (a) {
                if (!c) {
                    var b = a.getAttribute("data-lowsrc");
                    b && g(a) && (c = b);
                }
            }), c;
        },
        i = function i(a, d, e, f) {
            var g,
                h = !1,
                i = !1,
                j = "always" == f ? 0 : Date.now(),
                k = 0,
                l = (a || d).parentNode,
                m = function m() {
                    if (e) {
                        var j = function j() {
                            h = !0, g && (c.rAF(function () {
                                g && c.aC(g, "ls-blur-up-loaded");
                            }), g.removeEventListener("load", j), g.removeEventListener("error", j));
                        };
                        g = b.createElement("img"), g.addEventListener("load", j), g.addEventListener("error", j), g.className = "ls-blur-up-img", g.src = e, g.alt = "", g.setAttribute("aria-hidden", "true"), g.className += " ls-inview", l.insertBefore(g, (a || d).nextSibling), "always" != f && (g.style.visibility = "hidden", setTimeout(function () {
                            c.rAF(function () {
                                i || (g.style.visibility = "");
                            });
                        }, 20));
                    }
                },
                n = function n() {
                    g && c.rAF(function () {
                        try {
                            g.parentNode.removeChild(g);
                        } catch (a) {}
                        g = null;
                    });
                },
                o = function o(a) {
                    k++, i = a || i, a ? n() : k > 1 && setTimeout(n, 5e3);
                },
                p = function p() {
                    d.removeEventListener("load", p), d.removeEventListener("error", p), g && c.rAF(function () {
                        c.aC(g, "ls-original-loaded");
                    }), !h || Date.now() - j < 66 ? o(!0) : o();
                };
            m(), d.addEventListener("load", p), d.addEventListener("error", p);
            var q = function q(a) {
                l == a.target && (c.aC(g || d, "ls-inview"), o(), l.removeEventListener("lazybeforeunveil", q));
            };
            l.getAttribute("data-expand") || l.setAttribute("data-expand", -1), l.addEventListener("lazybeforeunveil", q), c.aC(l, c.cfg.lazyClass);
        };
    a.addEventListener("lazybeforeunveil", function (a) {
        var b = a.detail;
        if (b.instance == c && b.blurUp) {
            var d = a.target,
                e = d.parentNode;
            "PICTURE" != e.nodeName && (e = null), i(e, d, h(e, d) || "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==", b.blurUp);
        }
    }), a.addEventListener("lazyunveilread", function (a) {
        var b = a.detail;
        if (b.instance == c) {
            var d = a.target,
                f = (getComputedStyle(d, null) || {
                    fontFamily: ""
                }).fontFamily.match(e);
            (f || d.getAttribute("data-lowsrc")) && (b.blurUp = f && f[1] || c.cfg.blurupMode || "always");
        }
    });
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c(d) {
        b(a.lazySizes, d), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c, d) {
    "use strict";
    
    function e(a) {
        var b = getComputedStyle(a, null) || {},
            c = b.fontFamily || "",
            d = c.match(j) || "",
            e = d && c.match(k) || "";
        return e && (e = e[1]), {
            fit: d && d[1] || "",
            position: n[e] || e || "center"
        };
    }
    
    function f(a, b) {
        var d,
            e,
            f = c.cfg,
            g = a.cloneNode(!1),
            h = g.style,
            i = function i() {
                var b = a.currentSrc || a.src;
                b && e !== b && (e = b, h.backgroundImage = "url(" + (m.test(b) ? JSON.stringify(b) : b) + ")", d || (d = !0, c.rC(g, f.loadingClass), c.aC(g, f.loadedClass)));
            },
            j = function j() {
                c.rAF(i);
            };
        a._lazysizesParentFit = b.fit, a.addEventListener("lazyloaded", j, !0), a.addEventListener("load", j, !0), g.addEventListener("load", function () {
            var a = g.currentSrc || g.src;
            a && a != l && (g.src = l, g.srcset = "");
        }), c.rAF(function () {
            var d = a,
                e = a.parentNode;
            "PICTURE" == e.nodeName.toUpperCase() && (d = e, e = e.parentNode), c.rC(g, f.loadedClass), c.rC(g, f.lazyClass), c.aC(g, f.loadingClass), c.aC(g, f.objectFitClass || "lazysizes-display-clone"), g.getAttribute(f.srcsetAttr) && g.setAttribute(f.srcsetAttr, ""), g.getAttribute(f.srcAttr) && g.setAttribute(f.srcAttr, ""), g.src = l, g.srcset = "", h.backgroundRepeat = "no-repeat", h.backgroundPosition = b.position, h.backgroundSize = b.fit, d.style.display = "none", a.setAttribute("data-parent-fit", b.fit), a.setAttribute("data-parent-container", "prev"), e.insertBefore(g, d), a._lazysizesParentFit && delete a._lazysizesParentFit, a.complete && i();
        });
    }
    var g = b.createElement("a").style,
        h = "objectFit" in g,
        i = h && "objectPosition" in g,
        j = /object-fit["']*\s*:\s*["']*(contain|cover)/,
        k = /object-position["']*\s*:\s*["']*(.+?)(?=($|,|'|"|;))/,
        l = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
        m = /\(|\)|'/,
        n = {
            center: "center",
            "50% 50%": "center"
        };
    if (!h || !i) {
        var o = function o(a) {
            if (a.detail.instance == c) {
                var b = a.target,
                    d = e(b);
                !d.fit || h && "center" == d.position || f(b, d);
            }
        };
        a.addEventListener("lazyunveilread", o, !0), d && d.detail && o(d);
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    if (a.addEventListener) {
        var d = /\s+(\d+)(w|h)\s+(\d+)(w|h)/,
            e = /parent-fit["']*\s*:\s*["']*(contain|cover|width)/,
            f = /parent-container["']*\s*:\s*["']*(.+?)(?=(\s|$|,|'|"|;))/,
            g = /^picture$/i,
            h = function h(a) {
                return getComputedStyle(a, null) || {};
            },
            i = {
                getParent: function getParent(b, c) {
                    var d = b,
                        e = b.parentNode;
                    return c && "prev" != c || !e || !g.test(e.nodeName || "") || (e = e.parentNode), "self" != c && (d = "prev" == c ? b.previousElementSibling : c && (e.closest || a.jQuery) ? (e.closest ? e.closest(c) : jQuery(e).closest(c)[0]) || e : e), d;
                },
                getFit: function getFit(a) {
                    var b,
                        c,
                        d = h(a),
                        g = d.content || d.fontFamily,
                        j = {
                            fit: a._lazysizesParentFit || a.getAttribute("data-parent-fit")
                        };
                    return !j.fit && g && (b = g.match(e)) && (j.fit = b[1]), j.fit ? (c = a._lazysizesParentContainer || a.getAttribute("data-parent-container"), !c && g && (b = g.match(f)) && (c = b[1]), j.parent = i.getParent(a, c)) : j.fit = d.objectFit, j;
                },
                getImageRatio: function getImageRatio(b) {
                    var c,
                        e,
                        f,
                        h,
                        i,
                        j = b.parentNode,
                        k = j && g.test(j.nodeName || "") ? j.querySelectorAll("source, img") : [b];
                    for (c = 0; c < k.length; c++) {
                        if (b = k[c], e = b.getAttribute(lazySizesConfig.srcsetAttr) || b.getAttribute("srcset") || b.getAttribute("data-pfsrcset") || b.getAttribute("data-risrcset") || "", f = b._lsMedia || b.getAttribute("media"), f = lazySizesConfig.customMedia[b.getAttribute("data-media") || f] || f, e && (!f || (a.matchMedia && matchMedia(f) || {}).matches)) {
                            h = parseFloat(b.getAttribute("data-aspectratio")), !h && (i = e.match(d)) && (h = "w" == i[2] ? i[1] / i[3] : i[3] / i[1]);
                            break;
                        }
                    }
                    return h;
                },
                calculateSize: function calculateSize(a, b) {
                    var c,
                        d,
                        e,
                        f,
                        g = this.getFit(a),
                        h = g.fit,
                        i = g.parent;
                    return "width" == h || ("contain" == h || "cover" == h) && (e = this.getImageRatio(a)) ? (i ? b = i.clientWidth : i = a, f = b, "width" == h ? f = b : (d = i.clientHeight) > 40 && (c = b / d) && ("cover" == h && c < e || "contain" == h && c > e) && (f = b * (e / c)), f) : b;
                }
            };
        c.parentFit = i, b.addEventListener("lazybeforesizes", function (a) {
            if (!a.defaultPrevented && a.detail.instance == c) {
                var b = a.target;
                a.detail.width = i.calculateSize(b, a.detail.width);
            }
        });
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    var d, _e;
    "srcset" in b.createElement("img") && (d = /^img$/i, _e = function e(a) {
        a.target.style.backgroundSize = "", a.target.style.backgroundImage = "", a.target.removeEventListener(a.type, _e);
    }, b.addEventListener("lazybeforeunveil", function (a) {
        if (a.detail.instance == c) {
            var b = a.target;
            if (d.test(b.nodeName)) {
                var f = b.getAttribute("src");
                f && (b.style.backgroundSize = "100% 100%", b.style.backgroundImage = "url(" + f + ")", b.removeAttribute("src"), b.addEventListener("load", _e));
            }
        }
    }, !1));
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    
    function d(c, d) {
        var e = "vimeoCallback" + j,
            f = b.createElement("script");
        c += "&callback=" + e, j++, a[e] = function (b) {
            f.parentNode.removeChild(f), delete a[e], d(b);
        }, f.src = c, b.head.appendChild(f);
    }
    
    function e(a, b) {
        d(o.replace(k, a), function (a) {
            a && a.thumbnail_url && (b.style.backgroundImage = "url(" + a.thumbnail_url + ")");
        }), b.addEventListener("click", f);
    }
    
    function f(a) {
        var b = a.currentTarget,
            c = b.getAttribute("data-vimeo"),
            d = b.getAttribute("data-vimeoparams") || "";
        d && !l.test(d) && (d = "&" + d), a.preventDefault(), b.innerHTML = '<iframe src="' + p.replace(k, c) + d + '" frameborder="0" allowfullscreen="" width="640" height="390"></iframe>', b.removeEventListener("click", f);
    }
    
    function g(a, b) {
        b.style.backgroundImage = "url(" + m.replace(k, a) + ")", b.addEventListener("click", h);
    }
    
    function h(a) {
        var b = a.currentTarget,
            c = b.getAttribute("data-youtube"),
            d = b.getAttribute("data-ytparams") || "";
        d && !l.test(d) && (d = "&" + d), a.preventDefault(), b.innerHTML = '<iframe src="' + n.replace(k, c) + d + '" frameborder="0" allowfullscreen="" width="640" height="390"></iframe>', b.removeEventListener("click", h);
    }
    if (b.getElementsByClassName) {
        var i = "https:" == location.protocol ? "https:" : "http:",
            j = Date.now(),
            k = /\{\{id}}/,
            l = /^&/,
            m = i + "//img.youtube.com/vi/{{id}}/sddefault.jpg",
            n = i + "//www.youtube.com/embed/{{id}}?autoplay=1",
            o = i + "//vimeo.com/api/oembed.json?url=https%3A//vimeo.com/{{id}}",
            p = i + "//player.vimeo.com/video/{{id}}?autoplay=1";
        b.addEventListener("lazybeforeunveil", function (a) {
            if (a.detail.instance == c) {
                var b = a.target,
                    d = b.getAttribute("data-youtube"),
                    f = b.getAttribute("data-vimeo");
                d && b && g(d, b), f && b && e(f, b);
            }
        });
    }
});
/*! lazysizes - v4.1.8 */
! function (a, b) {
    var c = function c() {
        b(a.lazySizes), a.removeEventListener("lazyunveilread", c, !0);
    };
    b = b.bind(null, a, a.document), "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && module.exports ? b(require("lazysizes")) : a.lazySizes ? c() : a.addEventListener("lazyunveilread", c, !0);
}(window, function (a, b, c) {
    "use strict";
    
    function d() {
        if (a.lazySizes && !f) {
            var g = b.documentElement,
                h = function () {
                    var a,
                        b = function b() {
                            i.checkElements(), a = !1;
                        };
                    return function () {
                        a || (a = !0, setTimeout(b, 999));
                    };
                }();
            e = c.cfg, removeEventListener("lazybeforeunveil", d), "unloadClass" in e || (e.unloadClass = "lazyunload"), "unloadedClass" in e || (e.unloadedClass = "lazyunloaded"), "unloadHidden" in e || (e.unloadHidden = !0), "emptySrc" in e || (e.emptySrc = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="), "autoUnload" in e || (e.autoUnload = !0), "unloadPixelThreshold" in e || (e.unloadPixelThreshold = 6e4), e.autoUnload && g.addEventListener("load", function (a) {
                a.target.naturalWidth * a.target.naturalHeight > e.unloadPixelThreshold && a.target.className && a.target.className.indexOf && -1 != a.target.className.indexOf(lazySizesConfig.loadingClass) && -1 == a.target.className.indexOf(lazySizesConfig.preloadClass) && c.aC(a.target, lazySizesConfig.unloadClass);
            }, !0), c.unloader = i, f = b.getElementsByClassName([e.unloadClass, e.loadedClass].join(" ")), setInterval(h, 9999), addEventListener("lazybeforeunveil", h), addEventListener("lazybeforeunveil", i._reload, !0);
        }
    }
    if (b.addEventListener) {
        var e,
            f,
            g = [],
            h = a.requestAnimationFrame || setTimeout,
            i = {
                checkElements: function checkElements() {
                    var a,
                        b,
                        d,
                        j = 1.1 * (c._defEx + 99),
                        k = -1 * j,
                        l = k,
                        m = innerHeight + j,
                        n = innerWidth + j;
                    for (a = 0, b = f.length; a < b; a++) {
                        d = f[a].getBoundingClientRect(), (d.top > m || d.bottom < k || d.left > n || d.right < l || e.unloadHidden && !d.top && !d.bottom && !d.left && !d.right) && g.push(f[a]);
                    }
                    h(i.unloadElements);
                },
                unload: function unload(a) {
                    var b,
                        d,
                        f,
                        g,
                        h = a.parentNode;
                    if (c.rC(a, e.loadedClass), a.getAttribute(e.srcsetAttr) && (a.setAttribute("srcset", e.emptySrc), d = !0), h && "PICTURE" == h.nodeName.toUpperCase()) {
                        for (b = h.getElementsByTagName("source"), f = 0, g = b.length; f < g; f++) {
                            b[f].setAttribute("srcset", e.emptySrc);
                        }
                        d = !0;
                    }
                    c.hC(a, e.autosizesClass) && (c.rC(a, e.autosizesClass), a.setAttribute(e.sizesAttr, "auto")), (d || a.getAttribute(e.srcAttr)) && (a.src = e.emptySrc), c.aC(a, e.unloadedClass), c.aC(a, e.lazyClass), c.fire(a, "lazyafterunload");
                },
                unloadElements: function unloadElements(a) {
                    for (a = Array.isArray(a) ? a : g; a.length;) {
                        i.unload(a.shift());
                    }
                },
                _reload: function _reload(a) {
                    c.hC(a.target, e.unloadedClass) && a.detail && (a.detail.reloaded = !0, c.rC(a.target, e.unloadedClass));
                }
            };
        addEventListener("lazybeforeunveil", d);
    }
});