$(document).ready(function () {
    $(".header__top .custom-select__item").on("click", function () {
        var href = $(this).attr('data-value');
        window.location.href = href;
    });

    ymaps.ready(function () {
        var x = $('#map').attr('data-x');
        var y = $('#map').attr('data-y');
        init('map', x, y)
    })

    function init(map_name, x, y) {

        var myMap = new ymaps.Map(map_name, {
            center: [x, y],
            zoom: 13,
        });

        // Все виды меток
        // https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage-docpage/


        // Собственное изображение для метки с контентом
        var placemark4 = new ymaps.Placemark([x, y], {
            // hintContent: 'Собственный значок метки с контентом',
        }, {
            // Опции.
            preset: "twirl#redClusterIcons", gridSize: 100
        });

        myMap.geoObjects.add(placemark4);
    }

});

function openSingle(object){
    var href = $(object).attr('data-link');
    window.location.href = href;
}

function init(map_name, x, y) {

    var myMap = new ymaps.Map(map_name, {
        center: [x, y],
        zoom: 13,
    });

    // Все виды меток
    // https://tech.yandex.ru/maps/doc/jsapi/2.1/ref/reference/option.presetStorage-docpage/


    // Собственное изображение для метки с контентом
    var placemark4 = new ymaps.Placemark([x, y], {
        // hintContent: 'Собственный значок метки с контентом',
    }, {
        // Опции.

        // Необходимо указать данный тип макета.
        iconLayout: 'default#image',

        // Своё изображение иконки метки.
        iconImageHref: '/img/map.svg',
        // Размеры метки.
        iconImageSize: [131, 62],
        // Смещение левого верхнего угла иконки относительно
        // её "ножки" (точки привязки).
        iconImageOffset: [-72, -62],
    });

    myMap.geoObjects.add(placemark4);
}

$(document).ready(function () {

    $(".filter-sort__form .custom-select__item").on("click", function () {
        document.cookie = 'sort=' + $(this).attr('data-value');
        window.location.href = location.pathname;
    });

});

function get_user_menu() {

    $.ajax({
        type: 'POST',
        url: "/auth/check",
        response: 'text',
        dataType: "html",
        cache: false,
        success: function (data) {

            if (data == 'guest') {

                $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallbackRegisterRequest", function (data, textStatus, jqxhr) {

                });

                $('.login').animate({
                    left: '0px'
                }, 250);

            }

        }
    })

}

function getPhone(object) {

    var id = $(object).attr('data-id');
    var price = $(object).attr('data-price');
    var city = $(object).attr('data-city');
    var rayon = $(object).attr('data-rayon');
    var age = $(object).attr('data-age');

    if (typeof $(object).attr('data-num') !== typeof undefined) {

        window.location.href = 'tel:+' + $(object).attr('data-num');

    } else {

        $.ajax({
            type: 'POST',
            url: "/phone/get", //Путь к обработчику
            data: 'id=' + id + '&price=' + price + '&city_id=' + city + '&rayon=' + rayon + '&age=' + age,
            cache: false,
            success: function (data) {
                $(object).attr('data-num', data);
                $(object).text(data);
                window.location.href = 'tel:+' + data;
            }
        })

    }

}

function get_claim_modal() {

    $.ajax({
        type: 'POST',
        url: "/claim/get-modal", //Путь к обработчику
        cache: false,
        success: function (data) {

            $('.claim__modal-bg').html(data);

            var claim_modal = document.querySelector(".claim__modal-bg");

            document.querySelector("html").classList.toggle("lock");
            document.querySelector(".wrapper").classList.toggle("lock");
            claim_modal.classList.toggle("active");

        }
    })

}

function close_modal(object){

    $(object).closest('.modal').toggleClass('active');

    document.querySelector("html").classList.toggle("lock");
    document.querySelector(".wrapper").classList.toggle("lock");

}

function setSort() {

    if ($('#sort-select').val()) {

        document.cookie = 'sort=' + $('#sort-select').val();

    }

    window.location.href = location.pathname;

}

function inView($elem) {
    var $window = $(window);

    var docViewTop = $window.scrollTop();
    var docViewBottom = docViewTop + $window.height();

    var elemTop = $elem.offset().top;
    var elemBottom = elemTop + $elem.height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}

var changeURL = debounce(function () {
    $('[data-url]').each(function () {
        if (inView($(this))) {

            if (window.location.pathname + window.location.search != $(this).attr('data-url') && $(this).attr('data-url').length > 0) {

                window.history.pushState('', document.title, $(this).attr('data-url'));
                yaCounter70919698.hit($(this).attr('data-url'));

            }
        }
    });
}, 1);

function debounce(func, wait, immediate) {
    var timeout;
    return function () {
        var context = this, args = arguments;
        var later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

$(window).scroll(function () {

    var target = $('.pager');
    var targetPos = target.offset().top;
    var winHeight = $(window).height();
    var scrollToElem = targetPos - winHeight;

    var winScrollTop = $(this).scrollTop();

    var page = $(target).attr('data-page');

    var url = $(target).attr('data-adress');
    var request = $(target).attr('data-reqest');

    var accept = $(target).attr('data-accept');

    changeURL();

    if (winScrollTop > (scrollToElem - 100)) {

        var single = $(target).attr('data-single');

        if (single == 1) {

            $('[data-post-id]').each(function () {

                id = id + $(this).attr('data-post-id') + ',';

            });

        } else {

            var id = [];

            $('[data-post-id]').each(function () {

                id.push($(this).attr('data-post-id'));

            });

            $(target).removeClass('pager');

            $.ajax({
                type: 'POST',
                url: '' + url,
                data: 'page=' + page + '&req=' + request + '&id=' + JSON.stringify(id),
                async: false,
                dataType: "html",
                headers: {
                    "Accept": accept,
                },
                cache: false,
                success: function (data) {

                    if (data !== '') {

                        $('.content-post').append(data);

                        page = $(target).attr('data-page', Number(page) + 1);

                        $(target).addClass('pager');

                    } else {

                        $(target).remove();
                        $('.dots').remove();

                    }

                }
            })

        }

    }
});


$('.login-icon-close').click(function () {

    $('body').css('overflow', 'inherit');

    $('.login').animate({

        left: '-120%'

    }, 200);

});

$('.register-icon-close').click(function () {

    $('body').css('overflow', 'inherit');

    $('.register').animate({

        left: '-120%'

    }, 200);

});

var onloadCallbackRegisterRequest = function () {
    grecaptcha.render('register_recapcha', {
        'sitekey': '6Lffq2EkAAAAAK4PuAXJjhnE1NOP1uUjANyEUxe_'
    });
};

function get_register_btn() {

    $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallbackRegisterRequest", function (data, textStatus, jqxhr) {

    });

    $('.register').animate({

        left: '0px'

    }, 250);

}


!function (e, t) {
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (e.document) return t(e);
        throw new Error("jQuery requires a window with a document")
    } : t(e)
}("undefined" != typeof window ? window : this, function (w, H) {
    function W(e, t) {
        return t.toUpperCase()
    }

    var e = [], k = w.document, d = e.slice, P = e.concat, z = e.push, o = e.indexOf, R = {}, I = R.toString,
        f = R.hasOwnProperty, v = {}, t = "2.2.4", S = function (e, t) {
            return new S.fn.init(e, t)
        }, _ = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, F = /^-ms-/, B = /-([\da-z])/gi;

    function X(e) {
        var t = !!e && "length" in e && e.length, i = S.type(e);
        return "function" !== i && !S.isWindow(e) && ("array" === i || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }

    S.fn = S.prototype = {
        jquery: t, constructor: S, selector: "", length: 0, toArray: function () {
            return d.call(this)
        }, get: function (e) {
            return null != e ? e < 0 ? this[e + this.length] : this[e] : d.call(this)
        }, pushStack: function (e) {
            e = S.merge(this.constructor(), e);
            return e.prevObject = this, e.context = this.context, e
        }, each: function (e) {
            return S.each(this, e)
        }, map: function (i) {
            return this.pushStack(S.map(this, function (e, t) {
                return i.call(e, t, e)
            }))
        }, slice: function () {
            return this.pushStack(d.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (e) {
            var t = this.length, e = +e + (e < 0 ? t : 0);
            return this.pushStack(0 <= e && e < t ? [this[e]] : [])
        }, end: function () {
            return this.prevObject || this.constructor()
        }, push: z, sort: e.sort, splice: e.splice
    }, S.extend = S.fn.extend = function () {
        var e, t, i, n, o, s = arguments[0] || {}, r = 1, l = arguments.length, a = !1;
        for ("boolean" == typeof s && (a = s, s = arguments[r] || {}, r++), "object" == typeof s || S.isFunction(s) || (s = {}), r === l && (s = this, r--); r < l; r++) if (null != (e = arguments[r])) for (t in e) o = s[t], i = e[t], s !== i && (a && i && (S.isPlainObject(i) || (n = S.isArray(i))) ? (o = n ? (n = !1, o && S.isArray(o) ? o : []) : o && S.isPlainObject(o) ? o : {}, s[t] = S.extend(a, o, i)) : void 0 !== i && (s[t] = i));
        return s
    }, S.extend({
        expando: "jQuery" + (t + Math.random()).replace(/\D/g, ""), isReady: !0, error: function (e) {
            throw new Error(e)
        }, noop: function () {
        }, isFunction: function (e) {
            return "function" === S.type(e)
        }, isArray: Array.isArray, isWindow: function (e) {
            return null != e && e === e.window
        }, isNumeric: function (e) {
            var t = e && e.toString();
            return !S.isArray(e) && 0 <= t - parseFloat(t) + 1
        }, isPlainObject: function (e) {
            if ("object" !== S.type(e) || e.nodeType || S.isWindow(e)) return !1;
            if (e.constructor && !f.call(e, "constructor") && !f.call(e.constructor.prototype || {}, "isPrototypeOf")) return !1;
            for (var t in e) ;
            return void 0 === t || f.call(e, t)
        }, isEmptyObject: function (e) {
            for (var t in e) return !1;
            return !0
        }, type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? R[I.call(e)] || "object" : typeof e
        }, globalEval: function (e) {
            var t, i = eval;
            (e = S.trim(e)) && (1 === e.indexOf("use strict") ? ((t = k.createElement("script")).text = e, k.head.appendChild(t).parentNode.removeChild(t)) : i(e))
        }, camelCase: function (e) {
            return e.replace(F, "ms-").replace(B, W)
        }, nodeName: function (e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        }, each: function (e, t) {
            var i, n = 0;
            if (X(e)) for (i = e.length; n < i && !1 !== t.call(e[n], n, e[n]); n++) ; else for (n in e) if (!1 === t.call(e[n], n, e[n])) break;
            return e
        }, trim: function (e) {
            return null == e ? "" : (e + "").replace(_, "")
        }, makeArray: function (e, t) {
            t = t || [];
            return null != e && (X(Object(e)) ? S.merge(t, "string" == typeof e ? [e] : e) : z.call(t, e)), t
        }, inArray: function (e, t, i) {
            return null == t ? -1 : o.call(t, e, i)
        }, merge: function (e, t) {
            for (var i = +t.length, n = 0, o = e.length; n < i; n++) e[o++] = t[n];
            return e.length = o, e
        }, grep: function (e, t, i) {
            for (var n = [], o = 0, s = e.length, r = !i; o < s; o++) !t(e[o], o) != r && n.push(e[o]);
            return n
        }, map: function (e, t, i) {
            var n, o, s = 0, r = [];
            if (X(e)) for (n = e.length; s < n; s++) null != (o = t(e[s], s, i)) && r.push(o); else for (s in e) o = t(e[s], s, i), null != o && r.push(o);
            return P.apply([], r)
        }, guid: 1, proxy: function (e, t) {
            var i, n;
            return "string" == typeof t && (n = e[t], t = e, e = n), S.isFunction(e) ? (i = d.call(arguments, 2), (n = function () {
                return e.apply(t || this, i.concat(d.call(arguments)))
            }).guid = e.guid = e.guid || S.guid++, n) : void 0
        }, now: Date.now, support: v
    }), "function" == typeof Symbol && (S.fn[Symbol.iterator] = e[Symbol.iterator]), S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (e, t) {
        R["[object " + t + "]"] = t.toLowerCase()
    });

    function n(e, t, i) {
        for (var n = [], o = void 0 !== i; (e = e[t]) && 9 !== e.nodeType;) if (1 === e.nodeType) {
            if (o && S(e).is(i)) break;
            n.push(e)
        }
        return n
    }

    function V(e, t) {
        for (var i = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && i.push(e);
        return i
    }

    var t = function (H) {
            function u(e, t, i) {
                var n = "0x" + t - 65536;
                return n != n || i ? t : n < 0 ? String.fromCharCode(65536 + n) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320)
            }

            function W() {
                k()
            }

            var e, f, x, s, P, v, z, R, w, a, c, k, S, t, T, g, n, o, m, C = "sizzle" + +new Date, y = H.document, E = 0,
                I = 0, _ = ce(), F = ce(), b = ce(), B = function (e, t) {
                    return e === t && (c = !0), 0
                }, X = {}.hasOwnProperty, i = [], V = i.pop, Y = i.push, A = i.push, U = i.slice, $ = function (e, t) {
                    for (var i = 0, n = e.length; i < n; i++) if (e[i] === t) return i;
                    return -1
                },
                G = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                r = "[\\x20\\t\\r\\n\\f]", l = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
                Q = "\\[" + r + "*(" + l + ")(?:" + r + "*([*^$|!~]?=)" + r + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + l + "))|)" + r + "*\\]",
                J = ":(" + l + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + Q + ")*)|.*)\\)|)",
                K = new RegExp(r + "+", "g"), O = new RegExp("^" + r + "+|((?:^|[^\\\\])(?:\\\\.)*)" + r + "+$", "g"),
                Z = new RegExp("^" + r + "*," + r + "*"), ee = new RegExp("^" + r + "*([>+~]|" + r + ")" + r + "*"),
                te = new RegExp("=" + r + "*([^\\]'\"]*?)" + r + "*\\]", "g"), ie = new RegExp(J),
                ne = new RegExp("^" + l + "$"), p = {
                    ID: new RegExp("^#(" + l + ")"),
                    CLASS: new RegExp("^\\.(" + l + ")"),
                    TAG: new RegExp("^(" + l + "|[*])"),
                    ATTR: new RegExp("^" + Q),
                    PSEUDO: new RegExp("^" + J),
                    CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + r + "*(even|odd|(([+-]|)(\\d*)n|)" + r + "*(?:([+-]|)" + r + "*(\\d+)|))" + r + "*\\)|)", "i"),
                    bool: new RegExp("^(?:" + G + ")$", "i"),
                    needsContext: new RegExp("^" + r + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + r + "*((?:-\\d)?\\d*)" + r + "*\\)|)(?=[^-]|$)", "i")
                }, oe = /^(?:input|select|textarea|button)$/i, se = /^h\d$/i, d = /^[^{]+\{\s*\[native \w/,
                re = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, le = /[+~]/, ae = /'|\\/g,
                h = new RegExp("\\\\([\\da-f]{1,6}" + r + "?|(" + r + ")|.)", "ig");
            try {
                A.apply(i = U.call(y.childNodes), y.childNodes), i[y.childNodes.length].nodeType
            } catch (e) {
                A = {
                    apply: i.length ? function (e, t) {
                        Y.apply(e, U.call(t))
                    } : function (e, t) {
                        for (var i = e.length, n = 0; e[i++] = t[n++];) ;
                        e.length = i - 1
                    }
                }
            }

            function L(e, t, i, n) {
                var o, s, r, l, a, c, d, u, p = t && t.ownerDocument, h = t ? t.nodeType : 9;
                if (i = i || [], "string" != typeof e || !e || 1 !== h && 9 !== h && 11 !== h) return i;
                if (!n && ((t ? t.ownerDocument || t : y) !== S && k(t), t = t || S, T)) {
                    if (11 !== h && (c = re.exec(e))) if (o = c[1]) {
                        if (9 === h) {
                            if (!(r = t.getElementById(o))) return i;
                            if (r.id === o) return i.push(r), i
                        } else if (p && (r = p.getElementById(o)) && m(t, r) && r.id === o) return i.push(r), i
                    } else {
                        if (c[2]) return A.apply(i, t.getElementsByTagName(e)), i;
                        if ((o = c[3]) && f.getElementsByClassName && t.getElementsByClassName) return A.apply(i, t.getElementsByClassName(o)), i
                    }
                    if (f.qsa && !b[e + " "] && (!g || !g.test(e))) {
                        if (1 !== h) p = t, u = e; else if ("object" !== t.nodeName.toLowerCase()) {
                            for ((l = t.getAttribute("id")) ? l = l.replace(ae, "\\$&") : t.setAttribute("id", l = C), s = (d = v(e)).length, a = ne.test(l) ? "#" + l : "[id='" + l + "']"; s--;) d[s] = a + " " + q(d[s]);
                            u = d.join(","), p = le.test(e) && pe(t.parentNode) || t
                        }
                        if (u) try {
                            return A.apply(i, p.querySelectorAll(u)), i
                        } catch (e) {
                        } finally {
                            l === C && t.removeAttribute("id")
                        }
                    }
                }
                return R(e.replace(O, "$1"), t, i, n)
            }

            function ce() {
                var i = [];

                function n(e, t) {
                    return i.push(e + " ") > x.cacheLength && delete n[i.shift()], n[e + " "] = t
                }

                return n
            }

            function N(e) {
                return e[C] = !0, e
            }

            function D(e) {
                var t = S.createElement("div");
                try {
                    return !!e(t)
                } catch (e) {
                    return !1
                } finally {
                    t.parentNode && t.parentNode.removeChild(t)
                }
            }

            function de(e, t) {
                for (var i = e.split("|"), n = i.length; n--;) x.attrHandle[i[n]] = t
            }

            function ue(e, t) {
                var i = t && e,
                    n = i && 1 === e.nodeType && 1 === t.nodeType && (~t.sourceIndex || 1 << 31) - (~e.sourceIndex || 1 << 31);
                if (n) return n;
                if (i) for (; i = i.nextSibling;) if (i === t) return -1;
                return e ? 1 : -1
            }

            function M(r) {
                return N(function (s) {
                    return s = +s, N(function (e, t) {
                        for (var i, n = r([], e.length, s), o = n.length; o--;) e[i = n[o]] && (e[i] = !(t[i] = e[i]))
                    })
                })
            }

            function pe(e) {
                return e && void 0 !== e.getElementsByTagName && e
            }

            for (e in f = L.support = {}, P = L.isXML = function (e) {
                e = e && (e.ownerDocument || e).documentElement;
                return !!e && "HTML" !== e.nodeName
            }, k = L.setDocument = function (e) {
                var e = e ? e.ownerDocument || e : y;
                return e !== S && 9 === e.nodeType && e.documentElement && (t = (S = e).documentElement, T = !P(S), (e = S.defaultView) && e.top !== e && (e.addEventListener ? e.addEventListener("unload", W, !1) : e.attachEvent && e.attachEvent("onunload", W)), f.attributes = D(function (e) {
                    return e.className = "i", !e.getAttribute("className")
                }), f.getElementsByTagName = D(function (e) {
                    return e.appendChild(S.createComment("")), !e.getElementsByTagName("*").length
                }), f.getElementsByClassName = d.test(S.getElementsByClassName), f.getById = D(function (e) {
                    return t.appendChild(e).id = C, !S.getElementsByName || !S.getElementsByName(C).length
                }), f.getById ? (x.find.ID = function (e, t) {
                    if (void 0 !== t.getElementById && T) return (t = t.getElementById(e)) ? [t] : []
                }, x.filter.ID = function (e) {
                    var t = e.replace(h, u);
                    return function (e) {
                        return e.getAttribute("id") === t
                    }
                }) : (delete x.find.ID, x.filter.ID = function (e) {
                    var t = e.replace(h, u);
                    return function (e) {
                        e = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                        return e && e.value === t
                    }
                }), x.find.TAG = f.getElementsByTagName ? function (e, t) {
                    return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : f.qsa ? t.querySelectorAll(e) : void 0
                } : function (e, t) {
                    var i, n = [], o = 0, s = t.getElementsByTagName(e);
                    if ("*" !== e) return s;
                    for (; i = s[o++];) 1 === i.nodeType && n.push(i);
                    return n
                }, x.find.CLASS = f.getElementsByClassName && function (e, t) {
                    return void 0 !== t.getElementsByClassName && T ? t.getElementsByClassName(e) : void 0
                }, n = [], g = [], (f.qsa = d.test(S.querySelectorAll)) && (D(function (e) {
                    t.appendChild(e).innerHTML = "<a id='" + C + "'></a><select id='" + C + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && g.push("[*^$]=" + r + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || g.push("\\[" + r + "*(?:value|" + G + ")"), e.querySelectorAll("[id~=" + C + "-]").length || g.push("~="), e.querySelectorAll(":checked").length || g.push(":checked"), e.querySelectorAll("a#" + C + "+*").length || g.push(".#.+[+~]")
                }), D(function (e) {
                    var t = S.createElement("input");
                    t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && g.push("name" + r + "*[*^$|!~]?="), e.querySelectorAll(":enabled").length || g.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), g.push(",.*:")
                })), (f.matchesSelector = d.test(o = t.matches || t.webkitMatchesSelector || t.mozMatchesSelector || t.oMatchesSelector || t.msMatchesSelector)) && D(function (e) {
                    f.disconnectedMatch = o.call(e, "div"), o.call(e, "[s!='']:x"), n.push("!=", J)
                }), g = g.length && new RegExp(g.join("|")), n = n.length && new RegExp(n.join("|")), e = d.test(t.compareDocumentPosition), m = e || d.test(t.contains) ? function (e, t) {
                    var i = 9 === e.nodeType ? e.documentElement : e, t = t && t.parentNode;
                    return e === t || !(!t || 1 !== t.nodeType || !(i.contains ? i.contains(t) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(t)))
                } : function (e, t) {
                    if (t) for (; t = t.parentNode;) if (t === e) return !0;
                    return !1
                }, B = e ? function (e, t) {
                    var i;
                    return e === t ? (c = !0, 0) : (i = !e.compareDocumentPosition - !t.compareDocumentPosition) || (1 & (i = (e.ownerDocument || e) === (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !f.sortDetached && t.compareDocumentPosition(e) === i ? e === S || e.ownerDocument === y && m(y, e) ? -1 : t === S || t.ownerDocument === y && m(y, t) ? 1 : a ? $(a, e) - $(a, t) : 0 : 4 & i ? -1 : 1)
                } : function (e, t) {
                    if (e === t) return c = !0, 0;
                    var i, n = 0, o = e.parentNode, s = t.parentNode, r = [e], l = [t];
                    if (!o || !s) return e === S ? -1 : t === S ? 1 : o ? -1 : s ? 1 : a ? $(a, e) - $(a, t) : 0;
                    if (o === s) return ue(e, t);
                    for (i = e; i = i.parentNode;) r.unshift(i);
                    for (i = t; i = i.parentNode;) l.unshift(i);
                    for (; r[n] === l[n];) n++;
                    return n ? ue(r[n], l[n]) : r[n] === y ? -1 : l[n] === y ? 1 : 0
                }), S
            }, L.matches = function (e, t) {
                return L(e, null, null, t)
            }, L.matchesSelector = function (e, t) {
                if ((e.ownerDocument || e) !== S && k(e), t = t.replace(te, "='$1']"), f.matchesSelector && T && !b[t + " "] && (!n || !n.test(t)) && (!g || !g.test(t))) try {
                    var i = o.call(e, t);
                    if (i || f.disconnectedMatch || e.document && 11 !== e.document.nodeType) return i
                } catch (e) {
                }
                return 0 < L(t, S, null, [e]).length
            }, L.contains = function (e, t) {
                return (e.ownerDocument || e) !== S && k(e), m(e, t)
            }, L.attr = function (e, t) {
                (e.ownerDocument || e) !== S && k(e);
                var i = x.attrHandle[t.toLowerCase()],
                    i = i && X.call(x.attrHandle, t.toLowerCase()) ? i(e, t, !T) : void 0;
                return void 0 !== i ? i : f.attributes || !T ? e.getAttribute(t) : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            }, L.error = function (e) {
                throw new Error("Syntax error, unrecognized expression: " + e)
            }, L.uniqueSort = function (e) {
                var t, i = [], n = 0, o = 0;
                if (c = !f.detectDuplicates, a = !f.sortStable && e.slice(0), e.sort(B), c) {
                    for (; t = e[o++];) t === e[o] && (n = i.push(o));
                    for (; n--;) e.splice(i[n], 1)
                }
                return a = null, e
            }, s = L.getText = function (e) {
                var t, i = "", n = 0, o = e.nodeType;
                if (o) {
                    if (1 === o || 9 === o || 11 === o) {
                        if ("string" == typeof e.textContent) return e.textContent;
                        for (e = e.firstChild; e; e = e.nextSibling) i += s(e)
                    } else if (3 === o || 4 === o) return e.nodeValue
                } else for (; t = e[n++];) i += s(t);
                return i
            }, (x = L.selectors = {
                cacheLength: 50,
                createPseudo: N,
                match: p,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {dir: "parentNode", first: !0},
                    " ": {dir: "parentNode"},
                    "+": {dir: "previousSibling", first: !0},
                    "~": {dir: "previousSibling"}
                },
                preFilter: {
                    ATTR: function (e) {
                        return e[1] = e[1].replace(h, u), e[3] = (e[3] || e[4] || e[5] || "").replace(h, u), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                    }, CHILD: function (e) {
                        return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || L.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && L.error(e[0]), e
                    }, PSEUDO: function (e) {
                        var t, i = !e[6] && e[2];
                        return p.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : i && ie.test(i) && (t = (t = v(i, !0)) && i.indexOf(")", i.length - t) - i.length) && (e[0] = e[0].slice(0, t), e[2] = i.slice(0, t)), e.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function (e) {
                        var t = e.replace(h, u).toLowerCase();
                        return "*" === e ? function () {
                            return !0
                        } : function (e) {
                            return e.nodeName && e.nodeName.toLowerCase() === t
                        }
                    }, CLASS: function (e) {
                        var t = _[e + " "];
                        return t || (t = new RegExp("(^|" + r + ")" + e + "(" + r + "|$)")) && _(e, function (e) {
                            return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                        })
                    }, ATTR: function (t, i, n) {
                        return function (e) {
                            e = L.attr(e, t);
                            return null == e ? "!=" === i : !i || (e += "", "=" === i ? e === n : "!=" === i ? e !== n : "^=" === i ? n && 0 === e.indexOf(n) : "*=" === i ? n && -1 < e.indexOf(n) : "$=" === i ? n && e.slice(-n.length) === n : "~=" === i ? -1 < (" " + e.replace(K, " ") + " ").indexOf(n) : "|=" === i && (e === n || e.slice(0, n.length + 1) === n + "-"))
                        }
                    }, CHILD: function (f, e, t, v, g) {
                        var m = "nth" !== f.slice(0, 3), y = "last" !== f.slice(-4), b = "of-type" === e;
                        return 1 === v && 0 === g ? function (e) {
                            return !!e.parentNode
                        } : function (e, t, i) {
                            var n, o, s, r, l, a, c = m != y ? "nextSibling" : "previousSibling", d = e.parentNode,
                                u = b && e.nodeName.toLowerCase(), p = !i && !b, h = !1;
                            if (d) {
                                if (m) {
                                    for (; c;) {
                                        for (r = e; r = r[c];) if (b ? r.nodeName.toLowerCase() === u : 1 === r.nodeType) return !1;
                                        a = c = "only" === f && !a && "nextSibling"
                                    }
                                    return !0
                                }
                                if (a = [y ? d.firstChild : d.lastChild], y && p) {
                                    for (h = (l = (n = (o = (s = (r = d)[C] || (r[C] = {}))[r.uniqueID] || (s[r.uniqueID] = {}))[f] || [])[0] === E && n[1]) && n[2], r = l && d.childNodes[l]; r = ++l && r && r[c] || (h = l = 0, a.pop());) if (1 === r.nodeType && ++h && r === e) {
                                        o[f] = [E, l, h];
                                        break
                                    }
                                } else if (!1 === (h = p ? l = (n = (o = (s = (r = e)[C] || (r[C] = {}))[r.uniqueID] || (s[r.uniqueID] = {}))[f] || [])[0] === E && n[1] : h)) for (; (r = ++l && r && r[c] || (h = l = 0, a.pop())) && ((b ? r.nodeName.toLowerCase() !== u : 1 !== r.nodeType) || !++h || (p && ((o = (s = r[C] || (r[C] = {}))[r.uniqueID] || (s[r.uniqueID] = {}))[f] = [E, h]), r !== e));) ;
                                return (h -= g) === v || h % v == 0 && 0 <= h / v
                            }
                        }
                    }, PSEUDO: function (e, s) {
                        var t, r = x.pseudos[e] || x.setFilters[e.toLowerCase()] || L.error("unsupported pseudo: " + e);
                        return r[C] ? r(s) : 1 < r.length ? (t = [e, e, "", s], x.setFilters.hasOwnProperty(e.toLowerCase()) ? N(function (e, t) {
                            for (var i, n = r(e, s), o = n.length; o--;) e[i = $(e, n[o])] = !(t[i] = n[o])
                        }) : function (e) {
                            return r(e, 0, t)
                        }) : r
                    }
                },
                pseudos: {
                    not: N(function (e) {
                        var n = [], o = [], l = z(e.replace(O, "$1"));
                        return l[C] ? N(function (e, t, i, n) {
                            for (var o, s = l(e, null, n, []), r = e.length; r--;) (o = s[r]) && (e[r] = !(t[r] = o))
                        }) : function (e, t, i) {
                            return n[0] = e, l(n, null, i, o), n[0] = null, !o.pop()
                        }
                    }), has: N(function (t) {
                        return function (e) {
                            return 0 < L(t, e).length
                        }
                    }), contains: N(function (t) {
                        return t = t.replace(h, u), function (e) {
                            return -1 < (e.textContent || e.innerText || s(e)).indexOf(t)
                        }
                    }), lang: N(function (i) {
                        return ne.test(i || "") || L.error("unsupported lang: " + i), i = i.replace(h, u).toLowerCase(), function (e) {
                            var t;
                            do {
                                if (t = T ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === i || 0 === t.indexOf(i + "-")
                            } while ((e = e.parentNode) && 1 === e.nodeType);
                            return !1
                        }
                    }), target: function (e) {
                        var t = H.location && H.location.hash;
                        return t && t.slice(1) === e.id
                    }, root: function (e) {
                        return e === t
                    }, focus: function (e) {
                        return e === S.activeElement && (!S.hasFocus || S.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                    }, enabled: function (e) {
                        return !1 === e.disabled
                    }, disabled: function (e) {
                        return !0 === e.disabled
                    }, checked: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && !!e.checked || "option" === t && !!e.selected
                    }, selected: function (e) {
                        return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                    }, empty: function (e) {
                        for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeType < 6) return !1;
                        return !0
                    }, parent: function (e) {
                        return !x.pseudos.empty(e)
                    }, header: function (e) {
                        return se.test(e.nodeName)
                    }, input: function (e) {
                        return oe.test(e.nodeName)
                    }, button: function (e) {
                        var t = e.nodeName.toLowerCase();
                        return "input" === t && "button" === e.type || "button" === t
                    }, text: function (e) {
                        return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (e = e.getAttribute("type")) || "text" === e.toLowerCase())
                    }, first: M(function () {
                        return [0]
                    }), last: M(function (e, t) {
                        return [t - 1]
                    }), eq: M(function (e, t, i) {
                        return [i < 0 ? i + t : i]
                    }), even: M(function (e, t) {
                        for (var i = 0; i < t; i += 2) e.push(i);
                        return e
                    }), odd: M(function (e, t) {
                        for (var i = 1; i < t; i += 2) e.push(i);
                        return e
                    }), lt: M(function (e, t, i) {
                        for (var n = i < 0 ? i + t : i; 0 <= --n;) e.push(n);
                        return e
                    }), gt: M(function (e, t, i) {
                        for (var n = i < 0 ? i + t : i; ++n < t;) e.push(n);
                        return e
                    })
                }
            }).pseudos.nth = x.pseudos.eq, {
                radio: !0,
                checkbox: !0,
                file: !0,
                password: !0,
                image: !0
            }) x.pseudos[e] = function (t) {
                return function (e) {
                    return "input" === e.nodeName.toLowerCase() && e.type === t
                }
            }(e);
            for (e in {submit: !0, reset: !0}) x.pseudos[e] = function (i) {
                return function (e) {
                    var t = e.nodeName.toLowerCase();
                    return ("input" === t || "button" === t) && e.type === i
                }
            }(e);

            function he() {
            }

            function q(e) {
                for (var t = 0, i = e.length, n = ""; t < i; t++) n += e[t].value;
                return n
            }

            function fe(r, e, t) {
                var l = e.dir, a = t && "parentNode" === l, c = I++;
                return e.first ? function (e, t, i) {
                    for (; e = e[l];) if (1 === e.nodeType || a) return r(e, t, i)
                } : function (e, t, i) {
                    var n, o, s = [E, c];
                    if (i) {
                        for (; e = e[l];) if ((1 === e.nodeType || a) && r(e, t, i)) return !0
                    } else for (; e = e[l];) if (1 === e.nodeType || a) {
                        if ((n = (o = (o = e[C] || (e[C] = {}))[e.uniqueID] || (o[e.uniqueID] = {}))[l]) && n[0] === E && n[1] === c) return s[2] = n[2];
                        if ((o[l] = s)[2] = r(e, t, i)) return !0
                    }
                }
            }

            function ve(o) {
                return 1 < o.length ? function (e, t, i) {
                    for (var n = o.length; n--;) if (!o[n](e, t, i)) return !1;
                    return !0
                } : o[0]
            }

            function j(e, t, i, n, o) {
                for (var s, r = [], l = 0, a = e.length, c = null != t; l < a; l++) !(s = e[l]) || i && !i(s, n, o) || (r.push(s), c && t.push(l));
                return r
            }

            function ge(h, f, v, g, m, e) {
                return g && !g[C] && (g = ge(g)), m && !m[C] && (m = ge(m, e)), N(function (e, t, i, n) {
                    var o, s, r, l = [], a = [], c = t.length, d = e || function (e, t, i) {
                            for (var n = 0, o = t.length; n < o; n++) L(e, t[n], i);
                            return i
                        }(f || "*", i.nodeType ? [i] : i, []), u = !h || !e && f ? d : j(d, l, h, i, n),
                        p = v ? m || (e ? h : c || g) ? [] : t : u;
                    if (v && v(u, p, i, n), g) for (o = j(p, a), g(o, [], i, n), s = o.length; s--;) (r = o[s]) && (p[a[s]] = !(u[a[s]] = r));
                    if (e) {
                        if (m || h) {
                            if (m) {
                                for (o = [], s = p.length; s--;) (r = p[s]) && o.push(u[s] = r);
                                m(null, p = [], o, n)
                            }
                            for (s = p.length; s--;) (r = p[s]) && -1 < (o = m ? $(e, r) : l[s]) && (e[o] = !(t[o] = r))
                        }
                    } else p = j(p === t ? p.splice(c, p.length) : p), m ? m(null, t, p, n) : A.apply(t, p)
                })
            }

            function me(g, m) {
                function e(e, t, i, n, o) {
                    var s, r, l, a = 0, c = "0", d = e && [], u = [], p = w, h = e || b && x.find.TAG("*", o),
                        f = E += null == p ? 1 : Math.random() || .1, v = h.length;
                    for (o && (w = t === S || t || o); c !== v && null != (s = h[c]); c++) {
                        if (b && s) {
                            for (r = 0, t || s.ownerDocument === S || (k(s), i = !T); l = g[r++];) if (l(s, t || S, i)) {
                                n.push(s);
                                break
                            }
                            o && (E = f)
                        }
                        y && ((s = !l && s) && a--, e) && d.push(s)
                    }
                    if (a += c, y && c !== a) {
                        for (r = 0; l = m[r++];) l(d, u, t, i);
                        if (e) {
                            if (0 < a) for (; c--;) d[c] || u[c] || (u[c] = V.call(n));
                            u = j(u)
                        }
                        A.apply(n, u), o && !e && 0 < u.length && 1 < a + m.length && L.uniqueSort(n)
                    }
                    return o && (E = f, w = p), d
                }

                var y = 0 < m.length, b = 0 < g.length;
                return y ? N(e) : e
            }

            return he.prototype = x.filters = x.pseudos, x.setFilters = new he, v = L.tokenize = function (e, t) {
                var i, n, o, s, r, l, a, c = F[e + " "];
                if (c) return t ? 0 : c.slice(0);
                for (r = e, l = [], a = x.preFilter; r;) {
                    for (s in i && !(n = Z.exec(r)) || (n && (r = r.slice(n[0].length) || r), l.push(o = [])), i = !1, (n = ee.exec(r)) && (i = n.shift(), o.push({
                        value: i,
                        type: n[0].replace(O, " ")
                    }), r = r.slice(i.length)), x.filter) !(n = p[s].exec(r)) || a[s] && !(n = a[s](n)) || (i = n.shift(), o.push({
                        value: i,
                        type: s,
                        matches: n
                    }), r = r.slice(i.length));
                    if (!i) break
                }
                return t ? r.length : r ? L.error(e) : F(e, l).slice(0)
            }, z = L.compile = function (e, t) {
                var i, n = [], o = [], s = b[e + " "];
                if (!s) {
                    for (i = (t = t || v(e)).length; i--;) ((s = function e(t) {
                        for (var n, i, o, s = t.length, r = x.relative[t[0].type], l = r || x.relative[" "], a = r ? 1 : 0, c = fe(function (e) {
                            return e === n
                        }, l, !0), d = fe(function (e) {
                            return -1 < $(n, e)
                        }, l, !0), u = [function (e, t, i) {
                            return e = !r && (i || t !== w) || ((n = t).nodeType ? c : d)(e, t, i), n = null, e
                        }]; a < s; a++) if (i = x.relative[t[a].type]) u = [fe(ve(u), i)]; else {
                            if ((i = x.filter[t[a].type].apply(null, t[a].matches))[C]) {
                                for (o = ++a; o < s && !x.relative[t[o].type]; o++) ;
                                return ge(1 < a && ve(u), 1 < a && q(t.slice(0, a - 1).concat({value: " " === t[a - 2].type ? "*" : ""})).replace(O, "$1"), i, a < o && e(t.slice(a, o)), o < s && e(t = t.slice(o)), o < s && q(t))
                            }
                            u.push(i)
                        }
                        return ve(u)
                    }(t[i]))[C] ? n : o).push(s);
                    (s = b(e, me(o, n))).selector = e
                }
                return s
            }, R = L.select = function (e, t, i, n) {
                var o, s, r, l, a, c = "function" == typeof e && e, d = !n && v(e = c.selector || e);
                if (i = i || [], 1 === d.length) {
                    if (2 < (s = d[0] = d[0].slice(0)).length && "ID" === (r = s[0]).type && f.getById && 9 === t.nodeType && T && x.relative[s[1].type]) {
                        if (!(t = (x.find.ID(r.matches[0].replace(h, u), t) || [])[0])) return i;
                        c && (t = t.parentNode), e = e.slice(s.shift().value.length)
                    }
                    for (o = p.needsContext.test(e) ? 0 : s.length; o-- && (r = s[o], !x.relative[l = r.type]);) if ((a = x.find[l]) && (n = a(r.matches[0].replace(h, u), le.test(s[0].type) && pe(t.parentNode) || t))) {
                        if (s.splice(o, 1), e = n.length && q(s)) break;
                        return A.apply(i, n), i
                    }
                }
                return (c || z(e, d))(n, t, !T, i, !t || le.test(e) && pe(t.parentNode) || t), i
            }, f.sortStable = C.split("").sort(B).join("") === C, f.detectDuplicates = !!c, k(), f.sortDetached = D(function (e) {
                return 1 & e.compareDocumentPosition(S.createElement("div"))
            }), D(function (e) {
                return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
            }) || de("type|href|height|width", function (e, t, i) {
                return i ? void 0 : e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
            }), f.attributes && D(function (e) {
                return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
            }) || de("value", function (e, t, i) {
                return i || "input" !== e.nodeName.toLowerCase() ? void 0 : e.defaultValue
            }), D(function (e) {
                return null == e.getAttribute("disabled")
            }) || de(G, function (e, t, i) {
                return i ? void 0 : !0 === e[t] ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            }), L
        }(w),
        Y = (S.find = t, S.expr = t.selectors, S.expr[":"] = S.expr.pseudos, S.uniqueSort = S.unique = t.uniqueSort, S.text = t.getText, S.isXMLDoc = t.isXML, S.contains = t.contains, S.expr.match.needsContext),
        U = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/, G = /^.[^:#\[\.,]*$/;

    function Q(e, i, n) {
        if (S.isFunction(i)) return S.grep(e, function (e, t) {
            return !!i.call(e, t, e) !== n
        });
        if (i.nodeType) return S.grep(e, function (e) {
            return e === i !== n
        });
        if ("string" == typeof i) {
            if (G.test(i)) return S.filter(i, e, n);
            i = S.filter(i, e)
        }
        return S.grep(e, function (e) {
            return -1 < o.call(i, e) !== n
        })
    }

    S.filter = function (e, t, i) {
        var n = t[0];
        return i && (e = ":not(" + e + ")"), 1 === t.length && 1 === n.nodeType ? S.find.matchesSelector(n, e) ? [n] : [] : S.find.matches(e, S.grep(t, function (e) {
            return 1 === e.nodeType
        }))
    }, S.fn.extend({
        find: function (e) {
            var t, i = this.length, n = [], o = this;
            if ("string" != typeof e) return this.pushStack(S(e).filter(function () {
                for (t = 0; t < i; t++) if (S.contains(o[t], this)) return !0
            }));
            for (t = 0; t < i; t++) S.find(e, o[t], n);
            return (n = this.pushStack(1 < i ? S.unique(n) : n)).selector = this.selector ? this.selector + " " + e : e, n
        }, filter: function (e) {
            return this.pushStack(Q(this, e || [], !1))
        }, not: function (e) {
            return this.pushStack(Q(this, e || [], !0))
        }, is: function (e) {
            return !!Q(this, "string" == typeof e && Y.test(e) ? S(e) : e || [], !1).length
        }
    });
    var J, K = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/, Z = ((S.fn.init = function (e, t, i) {
            if (e) {
                if (i = i || J, "string" != typeof e) return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : S.isFunction(e) ? void 0 !== i.ready ? i.ready(e) : e(S) : (void 0 !== e.selector && (this.selector = e.selector, this.context = e.context), S.makeArray(e, this));
                if (!(n = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : K.exec(e)) || !n[1] && t) return (!t || t.jquery ? t || i : this.constructor(t)).find(e);
                if (n[1]) {
                    if (t = t instanceof S ? t[0] : t, S.merge(this, S.parseHTML(n[1], t && t.nodeType ? t.ownerDocument || t : k, !0)), U.test(n[1]) && S.isPlainObject(t)) for (var n in t) S.isFunction(this[n]) ? this[n](t[n]) : this.attr(n, t[n])
                } else (i = k.getElementById(n[2])) && i.parentNode && (this.length = 1, this[0] = i), this.context = k, this.selector = e
            }
            return this
        }).prototype = S.fn, J = S(k), /^(?:parents|prev(?:Until|All))/),
        ee = {children: !0, contents: !0, next: !0, prev: !0};

    function te(e, t) {
        for (; (e = e[t]) && 1 !== e.nodeType;) ;
        return e
    }

    S.fn.extend({
        has: function (e) {
            var t = S(e, this), i = t.length;
            return this.filter(function () {
                for (var e = 0; e < i; e++) if (S.contains(this, t[e])) return !0
            })
        }, closest: function (e, t) {
            for (var i, n = 0, o = this.length, s = [], r = Y.test(e) || "string" != typeof e ? S(e, t || this.context) : 0; n < o; n++) for (i = this[n]; i && i !== t; i = i.parentNode) if (i.nodeType < 11 && (r ? -1 < r.index(i) : 1 === i.nodeType && S.find.matchesSelector(i, e))) {
                s.push(i);
                break
            }
            return this.pushStack(1 < s.length ? S.uniqueSort(s) : s)
        }, index: function (e) {
            return e ? "string" == typeof e ? o.call(S(e), this[0]) : o.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            return this.pushStack(S.uniqueSort(S.merge(this.get(), S(e, t))))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), S.each({
        parent: function (e) {
            e = e.parentNode;
            return e && 11 !== e.nodeType ? e : null
        }, parents: function (e) {
            return n(e, "parentNode")
        }, parentsUntil: function (e, t, i) {
            return n(e, "parentNode", i)
        }, next: function (e) {
            return te(e, "nextSibling")
        }, prev: function (e) {
            return te(e, "previousSibling")
        }, nextAll: function (e) {
            return n(e, "nextSibling")
        }, prevAll: function (e) {
            return n(e, "previousSibling")
        }, nextUntil: function (e, t, i) {
            return n(e, "nextSibling", i)
        }, prevUntil: function (e, t, i) {
            return n(e, "previousSibling", i)
        }, siblings: function (e) {
            return V((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return V(e.firstChild)
        }, contents: function (e) {
            return e.contentDocument || S.merge([], e.childNodes)
        }
    }, function (n, o) {
        S.fn[n] = function (e, t) {
            var i = S.map(this, o, e);
            return (t = "Until" !== n.slice(-5) ? e : t) && "string" == typeof t && (i = S.filter(t, i)), 1 < this.length && (ee[n] || S.uniqueSort(i), Z.test(n)) && i.reverse(), this.pushStack(i)
        }
    });
    var ie, T = /\S+/g;

    function ne() {
        k.removeEventListener("DOMContentLoaded", ne), w.removeEventListener("load", ne), S.ready()
    }

    S.Callbacks = function (n) {
        var e, i;
        n = "string" == typeof n ? (e = n, i = {}, S.each(e.match(T) || [], function (e, t) {
            i[t] = !0
        }), i) : S.extend({}, n);

        function o() {
            for (l = n.once, r = s = !0; c.length; d = -1) for (t = c.shift(); ++d < a.length;) !1 === a[d].apply(t[0], t[1]) && n.stopOnFalse && (d = a.length, t = !1);
            n.memory || (t = !1), s = !1, l && (a = t ? [] : "")
        }

        var s, t, r, l, a = [], c = [], d = -1, u = {
            add: function () {
                return a && (t && !s && (d = a.length - 1, c.push(t)), function i(e) {
                    S.each(e, function (e, t) {
                        S.isFunction(t) ? n.unique && u.has(t) || a.push(t) : t && t.length && "string" !== S.type(t) && i(t)
                    })
                }(arguments), t) && !s && o(), this
            }, remove: function () {
                return S.each(arguments, function (e, t) {
                    for (var i; -1 < (i = S.inArray(t, a, i));) a.splice(i, 1), i <= d && d--
                }), this
            }, has: function (e) {
                return e ? -1 < S.inArray(e, a) : 0 < a.length
            }, empty: function () {
                return a = a && [], this
            }, disable: function () {
                return l = c = [], a = t = "", this
            }, disabled: function () {
                return !a
            }, lock: function () {
                return l = c = [], t || (a = t = ""), this
            }, locked: function () {
                return !!l
            }, fireWith: function (e, t) {
                return l || (t = [e, (t = t || []).slice ? t.slice() : t], c.push(t), s) || o(), this
            }, fire: function () {
                return u.fireWith(this, arguments), this
            }, fired: function () {
                return !!r
            }
        };
        return u
    }, S.extend({
        Deferred: function (e) {
            var s = [["resolve", "done", S.Callbacks("once memory"), "resolved"], ["reject", "fail", S.Callbacks("once memory"), "rejected"], ["notify", "progress", S.Callbacks("memory")]],
                o = "pending", r = {
                    state: function () {
                        return o
                    }, always: function () {
                        return l.done(arguments).fail(arguments), this
                    }, then: function () {
                        var o = arguments;
                        return S.Deferred(function (n) {
                            S.each(s, function (e, t) {
                                var i = S.isFunction(o[e]) && o[e];
                                l[t[1]](function () {
                                    var e = i && i.apply(this, arguments);
                                    e && S.isFunction(e.promise) ? e.promise().progress(n.notify).done(n.resolve).fail(n.reject) : n[t[0] + "With"](this === r ? n.promise() : this, i ? [e] : arguments)
                                })
                            }), o = null
                        }).promise()
                    }, promise: function (e) {
                        return null != e ? S.extend(e, r) : r
                    }
                }, l = {};
            return r.pipe = r.then, S.each(s, function (e, t) {
                var i = t[2], n = t[3];
                r[t[1]] = i.add, n && i.add(function () {
                    o = n
                }, s[1 ^ e][2].disable, s[2][2].lock), l[t[0]] = function () {
                    return l[t[0] + "With"](this === l ? r : this, arguments), this
                }, l[t[0] + "With"] = i.fireWith
            }), r.promise(l), e && e.call(l, l), l
        }, when: function (e) {
            function t(t, i, n) {
                return function (e) {
                    i[t] = this, n[t] = 1 < arguments.length ? d.call(arguments) : e, n === o ? c.notifyWith(i, n) : --a || c.resolveWith(i, n)
                }
            }

            var o, i, n, s = 0, r = d.call(arguments), l = r.length,
                a = 1 !== l || e && S.isFunction(e.promise) ? l : 0, c = 1 === a ? e : S.Deferred();
            if (1 < l) for (o = new Array(l), i = new Array(l), n = new Array(l); s < l; s++) r[s] && S.isFunction(r[s].promise) ? r[s].promise().progress(t(s, i, o)).done(t(s, n, r)).fail(c.reject) : --a;
            return a || c.resolveWith(n, r), c.promise()
        }
    }), S.fn.ready = function (e) {
        return S.ready.promise().done(e), this
    }, S.extend({
        isReady: !1, readyWait: 1, holdReady: function (e) {
            e ? S.readyWait++ : S.ready(!0)
        }, ready: function (e) {
            (!0 === e ? --S.readyWait : S.isReady) || (S.isReady = !0) !== e && 0 < --S.readyWait || (ie.resolveWith(k, [S]), S.fn.triggerHandler && (S(k).triggerHandler("ready"), S(k).off("ready")))
        }
    }), S.ready.promise = function (e) {
        return ie || (ie = S.Deferred(), "complete" === k.readyState || "loading" !== k.readyState && !k.documentElement.doScroll ? w.setTimeout(S.ready) : (k.addEventListener("DOMContentLoaded", ne), w.addEventListener("load", ne))), ie.promise(e)
    }, S.ready.promise();

    function u(e, t, i, n, o, s, r) {
        var l = 0, a = e.length, c = null == i;
        if ("object" === S.type(i)) for (l in o = !0, i) u(e, t, l, i[l], !0, s, r); else if (void 0 !== n && (o = !0, S.isFunction(n) || (r = !0), t = c ? r ? (t.call(e, n), null) : (c = t, function (e, t, i) {
            return c.call(S(e), i)
        }) : t)) for (; l < a; l++) t(e[l], i, r ? n : n.call(e[l], l, t(e[l], i)));
        return o ? e : c ? t.call(e) : a ? t(e[0], i) : s
    }

    function g(e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    }

    function i() {
        this.expando = S.expando + i.uid++
    }

    i.uid = 1, i.prototype = {
        register: function (e, t) {
            t = t || {};
            return e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                writable: !0,
                configurable: !0
            }), e[this.expando]
        }, cache: function (e) {
            var t;
            return g(e) ? ((t = e[this.expando]) || (t = {}, g(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t) : {}
        }, set: function (e, t, i) {
            var n, o = this.cache(e);
            if ("string" == typeof t) o[t] = i; else for (n in t) o[n] = t[n];
            return o
        }, get: function (e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][t]
        }, access: function (e, t, i) {
            var n;
            return void 0 === t || t && "string" == typeof t && void 0 === i ? void 0 !== (n = this.get(e, t)) ? n : this.get(e, S.camelCase(t)) : (this.set(e, t, i), void 0 !== i ? i : t)
        }, remove: function (e, t) {
            var i, n, o, s = e[this.expando];
            if (void 0 !== s) {
                if (void 0 === t) this.register(e); else {
                    i = (n = S.isArray(t) ? t.concat(t.map(S.camelCase)) : (o = S.camelCase(t), t in s ? [t, o] : (n = o) in s ? [n] : n.match(T) || [])).length;
                    for (; i--;) delete s[n[i]]
                }
                void 0 !== t && !S.isEmptyObject(s) || (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        }, hasData: function (e) {
            e = e[this.expando];
            return void 0 !== e && !S.isEmptyObject(e)
        }
    };
    var m = new i, a = new i, oe = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, se = /[A-Z]/g;

    function re(e, t, i) {
        var n;
        if (void 0 === i && 1 === e.nodeType) if (n = "data-" + t.replace(se, "-$&").toLowerCase(), "string" == typeof (i = e.getAttribute(n))) {
            try {
                i = "true" === i || "false" !== i && ("null" === i ? null : +i + "" === i ? +i : oe.test(i) ? S.parseJSON(i) : i)
            } catch (e) {
            }
            a.set(e, t, i)
        } else i = void 0;
        return i
    }

    S.extend({
        hasData: function (e) {
            return a.hasData(e) || m.hasData(e)
        }, data: function (e, t, i) {
            return a.access(e, t, i)
        }, removeData: function (e, t) {
            a.remove(e, t)
        }, _data: function (e, t, i) {
            return m.access(e, t, i)
        }, _removeData: function (e, t) {
            m.remove(e, t)
        }
    }), S.fn.extend({
        data: function (n, e) {
            var t, i, o, s = this[0], r = s && s.attributes;
            if (void 0 !== n) return "object" == typeof n ? this.each(function () {
                a.set(this, n)
            }) : u(this, function (t) {
                var e, i;
                if (s && void 0 === t) return void 0 !== (e = a.get(s, n) || a.get(s, n.replace(se, "-$&").toLowerCase())) || (i = S.camelCase(n), void 0 !== (e = a.get(s, i))) || void 0 !== (e = re(s, i, void 0)) ? e : void 0;
                i = S.camelCase(n), this.each(function () {
                    var e = a.get(this, i);
                    a.set(this, i, t), -1 < n.indexOf("-") && void 0 !== e && a.set(this, n, t)
                })
            }, null, e, 1 < arguments.length, null, !0);
            if (this.length && (o = a.get(s), 1 === s.nodeType) && !m.get(s, "hasDataAttrs")) {
                for (t = r.length; t--;) r[t] && 0 === (i = r[t].name).indexOf("data-") && (i = S.camelCase(i.slice(5)), re(s, i, o[i]));
                m.set(s, "hasDataAttrs", !0)
            }
            return o
        }, removeData: function (e) {
            return this.each(function () {
                a.remove(this, e)
            })
        }
    }), S.extend({
        queue: function (e, t, i) {
            var n;
            return e ? (n = m.get(e, t = (t || "fx") + "queue"), i && (!n || S.isArray(i) ? n = m.access(e, t, S.makeArray(i)) : n.push(i)), n || []) : void 0
        }, dequeue: function (e, t) {
            t = t || "fx";
            var i = S.queue(e, t), n = i.length, o = i.shift(), s = S._queueHooks(e, t);
            "inprogress" === o && (o = i.shift(), n--), o && ("fx" === t && i.unshift("inprogress"), delete s.stop, o.call(e, function () {
                S.dequeue(e, t)
            }, s)), !n && s && s.empty.fire()
        }, _queueHooks: function (e, t) {
            var i = t + "queueHooks";
            return m.get(e, i) || m.access(e, i, {
                empty: S.Callbacks("once memory").add(function () {
                    m.remove(e, [t + "queue", i])
                })
            })
        }
    }), S.fn.extend({
        queue: function (t, i) {
            var e = 2;
            return "string" != typeof t && (i = t, t = "fx", e--), arguments.length < e ? S.queue(this[0], t) : void 0 === i ? this : this.each(function () {
                var e = S.queue(this, t, i);
                S._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && S.dequeue(this, t)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                S.dequeue(this, e)
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, t) {
            function i() {
                --o || s.resolveWith(r, [r])
            }

            var n, o = 1, s = S.Deferred(), r = this, l = this.length;
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; l--;) (n = m.get(r[l], e + "queueHooks")) && n.empty && (o++, n.empty.add(i));
            return i(), s.promise(t)
        }
    });

    function y(e, t) {
        return "none" === S.css(e = t || e, "display") || !S.contains(e.ownerDocument, e)
    }

    var e = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, p = new RegExp("^(?:([+-])=|)(" + e + ")([a-z%]*)$", "i"),
        l = ["Top", "Right", "Bottom", "Left"];

    function le(e, t, i, n) {
        var o, s = 1, r = 20, l = n ? function () {
                return n.cur()
            } : function () {
                return S.css(e, t, "")
            }, a = l(), c = i && i[3] || (S.cssNumber[t] ? "" : "px"),
            d = (S.cssNumber[t] || "px" !== c && +a) && p.exec(S.css(e, t));
        if (d && d[3] !== c) for (c = c || d[3], i = i || [], d = +a || 1; S.style(e, t, (d /= s = s || ".5") + c), s !== (s = l() / a) && 1 !== s && --r;) ;
        return i && (d = +d || +a || 0, o = i[1] ? d + (i[1] + 1) * i[2] : +i[2], n) && (n.unit = c, n.start = d, n.end = o), o
    }

    var ae = /^(?:checkbox|radio)$/i, ce = /<([\w:-]+)/, de = /^$|\/(?:java|ecma)script/i, b = {
        option: [1, "<select multiple='multiple'>", "</select>"],
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function x(e, t) {
        var i = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [];
        return void 0 === t || t && S.nodeName(e, t) ? S.merge([e], i) : i
    }

    function ue(e, t) {
        for (var i = 0, n = e.length; i < n; i++) m.set(e[i], "globalEval", !t || m.get(t[i], "globalEval"))
    }

    b.optgroup = b.option, b.tbody = b.tfoot = b.colgroup = b.caption = b.thead, b.th = b.td;
    var pe = /<|&#?\w+;/;

    function he(e, t, i, n, o) {
        for (var s, r, l, a, c, d = t.createDocumentFragment(), u = [], p = 0, h = e.length; p < h; p++) if ((s = e[p]) || 0 === s) if ("object" === S.type(s)) S.merge(u, s.nodeType ? [s] : s); else if (pe.test(s)) {
            for (r = r || d.appendChild(t.createElement("div")), l = (ce.exec(s) || ["", ""])[1].toLowerCase(), l = b[l] || b._default, r.innerHTML = l[1] + S.htmlPrefilter(s) + l[2], c = l[0]; c--;) r = r.lastChild;
            S.merge(u, r.childNodes), (r = d.firstChild).textContent = ""
        } else u.push(t.createTextNode(s));
        for (d.textContent = "", p = 0; s = u[p++];) if (n && -1 < S.inArray(s, n)) o && o.push(s); else if (a = S.contains(s.ownerDocument, s), r = x(d.appendChild(s), "script"), a && ue(r), i) for (c = 0; s = r[c++];) de.test(s.type || "") && i.push(s);
        return d
    }

    t = k.createDocumentFragment().appendChild(k.createElement("div")), (L = k.createElement("input")).setAttribute("type", "radio"), L.setAttribute("checked", "checked"), L.setAttribute("name", "t"), t.appendChild(L), v.checkClone = t.cloneNode(!0).cloneNode(!0).lastChild.checked, t.innerHTML = "<textarea>x</textarea>", v.noCloneChecked = !!t.cloneNode(!0).lastChild.defaultValue;
    var fe = /^key/, ve = /^(?:mouse|pointer|contextmenu|drag|drop)|click/, ge = /^([^.]*)(?:\.(.+)|)/;

    function me() {
        return !0
    }

    function c() {
        return !1
    }

    function ye() {
        try {
            return k.activeElement
        } catch (e) {
        }
    }

    function be(e, t, i, n, o, s) {
        var r, l;
        if ("object" == typeof t) {
            for (l in "string" != typeof i && (n = n || i, i = void 0), t) be(e, l, i, n, t[l], s);
            return e
        }
        if (null == n && null == o ? (o = i, n = i = void 0) : null == o && ("string" == typeof i ? (o = n, n = void 0) : (o = n, n = i, i = void 0)), !1 === o) o = c; else if (!o) return e;
        return 1 === s && (r = o, (o = function (e) {
            return S().off(e), r.apply(this, arguments)
        }).guid = r.guid || (r.guid = S.guid++)), e.each(function () {
            S.event.add(this, t, o, n, i)
        })
    }

    S.event = {
        global: {},
        add: function (t, e, i, n, o) {
            var s, r, l, a, c, d, u, p, h, f = m.get(t);
            if (f) for (i.handler && (i = (s = i).handler, o = s.selector), i.guid || (i.guid = S.guid++), l = (l = f.events) || (f.events = {}), r = (r = f.handle) || (f.handle = function (e) {
                return void 0 !== S && S.event.triggered !== e.type ? S.event.dispatch.apply(t, arguments) : void 0
            }), a = (e = (e || "").match(T) || [""]).length; a--;) u = h = (p = ge.exec(e[a]) || [])[1], p = (p[2] || "").split(".").sort(), u && (c = S.event.special[u] || {}, u = (o ? c.delegateType : c.bindType) || u, c = S.event.special[u] || {}, h = S.extend({
                type: u,
                origType: h,
                data: n,
                handler: i,
                guid: i.guid,
                selector: o,
                needsContext: o && S.expr.match.needsContext.test(o),
                namespace: p.join(".")
            }, s), (d = l[u]) || ((d = l[u] = []).delegateCount = 0, c.setup && !1 !== c.setup.call(t, n, p, r)) || t.addEventListener && t.addEventListener(u, r), c.add && (c.add.call(t, h), h.handler.guid || (h.handler.guid = i.guid)), o ? d.splice(d.delegateCount++, 0, h) : d.push(h), S.event.global[u] = !0)
        },
        remove: function (e, t, i, n, o) {
            var s, r, l, a, c, d, u, p, h, f, v, g = m.hasData(e) && m.get(e);
            if (g && (a = g.events)) {
                for (c = (t = (t || "").match(T) || [""]).length; c--;) if (h = v = (l = ge.exec(t[c]) || [])[1], f = (l[2] || "").split(".").sort(), h) {
                    for (u = S.event.special[h] || {}, p = a[h = (n ? u.delegateType : u.bindType) || h] || [], l = l[2] && new RegExp("(^|\\.)" + f.join("\\.(?:.*\\.|)") + "(\\.|$)"), r = s = p.length; s--;) d = p[s], !o && v !== d.origType || i && i.guid !== d.guid || l && !l.test(d.namespace) || n && n !== d.selector && ("**" !== n || !d.selector) || (p.splice(s, 1), d.selector && p.delegateCount--, u.remove && u.remove.call(e, d));
                    r && !p.length && (u.teardown && !1 !== u.teardown.call(e, f, g.handle) || S.removeEvent(e, h, g.handle), delete a[h])
                } else for (h in a) S.event.remove(e, h + t[c], i, n, !0);
                S.isEmptyObject(a) && m.remove(e, "handle events")
            }
        },
        dispatch: function (e) {
            e = S.event.fix(e);
            var t, i, n, o, s, r = d.call(arguments), l = (m.get(this, "events") || {})[e.type] || [],
                a = S.event.special[e.type] || {};
            if ((r[0] = e).delegateTarget = this, !a.preDispatch || !1 !== a.preDispatch.call(this, e)) {
                for (s = S.event.handlers.call(this, e, l), t = 0; (n = s[t++]) && !e.isPropagationStopped();) for (e.currentTarget = n.elem, i = 0; (o = n.handlers[i++]) && !e.isImmediatePropagationStopped();) e.rnamespace && !e.rnamespace.test(o.namespace) || (e.handleObj = o, e.data = o.data, void 0 !== (o = ((S.event.special[o.origType] || {}).handle || o.handler).apply(n.elem, r)) && !1 === (e.result = o) && (e.preventDefault(), e.stopPropagation()));
                return a.postDispatch && a.postDispatch.call(this, e), e.result
            }
        },
        handlers: function (e, t) {
            var i, n, o, s, r = [], l = t.delegateCount, a = e.target;
            if (l && a.nodeType && ("click" !== e.type || isNaN(e.button) || e.button < 1)) for (; a !== this; a = a.parentNode || this) if (1 === a.nodeType && (!0 !== a.disabled || "click" !== e.type)) {
                for (n = [], i = 0; i < l; i++) void 0 === n[o = (s = t[i]).selector + " "] && (n[o] = s.needsContext ? -1 < S(o, this).index(a) : S.find(o, this, null, [a]).length), n[o] && n.push(s);
                n.length && r.push({elem: a, handlers: n})
            }
            return l < t.length && r.push({elem: this, handlers: t.slice(l)}), r
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, t) {
                var i, n, o = t.button;
                return null == e.pageX && null != t.clientX && (i = (n = e.target.ownerDocument || k).documentElement, n = n.body, e.pageX = t.clientX + (i && i.scrollLeft || n && n.scrollLeft || 0) - (i && i.clientLeft || n && n.clientLeft || 0), e.pageY = t.clientY + (i && i.scrollTop || n && n.scrollTop || 0) - (i && i.clientTop || n && n.clientTop || 0)), e.which || void 0 === o || (e.which = 1 & o ? 1 : 2 & o ? 3 : 4 & o ? 2 : 0), e
            }
        },
        fix: function (e) {
            if (e[S.expando]) return e;
            var t, i, n, o = e.type, s = e, r = this.fixHooks[o];
            for (r || (this.fixHooks[o] = r = ve.test(o) ? this.mouseHooks : fe.test(o) ? this.keyHooks : {}), n = r.props ? this.props.concat(r.props) : this.props, e = new S.Event(s), t = n.length; t--;) e[i = n[t]] = s[i];
            return e.target || (e.target = k), 3 === e.target.nodeType && (e.target = e.target.parentNode), r.filter ? r.filter(e, s) : e
        },
        special: {
            load: {noBubble: !0}, focus: {
                trigger: function () {
                    return this !== ye() && this.focus ? (this.focus(), !1) : void 0
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === ye() && this.blur ? (this.blur(), !1) : void 0
                }, delegateType: "focusout"
            }, click: {
                trigger: function () {
                    return "checkbox" === this.type && this.click && S.nodeName(this, "input") ? (this.click(), !1) : void 0
                }, _default: function (e) {
                    return S.nodeName(e.target, "a")
                }
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, S.removeEvent = function (e, t, i) {
        e.removeEventListener && e.removeEventListener(t, i)
    }, S.Event = function (e, t) {
        return this instanceof S.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? me : c) : this.type = e, t && S.extend(this, t), this.timeStamp = e && e.timeStamp || S.now(), void (this[S.expando] = !0)) : new S.Event(e, t)
    }, S.Event.prototype = {
        constructor: S.Event,
        isDefaultPrevented: c,
        isPropagationStopped: c,
        isImmediatePropagationStopped: c,
        isSimulated: !1,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = me, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = me, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = me, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, S.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (e, o) {
        S.event.special[e] = {
            delegateType: o, bindType: o, handle: function (e) {
                var t, i = e.relatedTarget, n = e.handleObj;
                return i && (i === this || S.contains(this, i)) || (e.type = n.origType, t = n.handler.apply(this, arguments), e.type = o), t
            }
        }
    }), S.fn.extend({
        on: function (e, t, i, n) {
            return be(this, e, t, i, n)
        }, one: function (e, t, i, n) {
            return be(this, e, t, i, n, 1)
        }, off: function (e, t, i) {
            var n, o;
            if (e && e.preventDefault && e.handleObj) n = e.handleObj, S(e.delegateTarget).off(n.namespace ? n.origType + "." + n.namespace : n.origType, n.selector, n.handler); else {
                if ("object" != typeof e) return !1 !== t && "function" != typeof t || (i = t, t = void 0), !1 === i && (i = c), this.each(function () {
                    S.event.remove(this, e, i, t)
                });
                for (o in e) this.off(o, t, e[o])
            }
            return this
        }
    });
    var xe = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi, we = /<script|<style|<link/i,
        ke = /checked\s*(?:[^=]|=\s*.checked.)/i, Se = /^true\/(.*)/, Te = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function Ce(e, t) {
        return S.nodeName(e, "table") && S.nodeName(11 !== t.nodeType ? t : t.firstChild, "tr") ? e.getElementsByTagName("tbody")[0] || e.appendChild(e.ownerDocument.createElement("tbody")) : e
    }

    function Ee(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function Ae(e) {
        var t = Se.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function $e(e, t) {
        var i, n, o, s, r, l;
        if (1 === t.nodeType) {
            if (m.hasData(e) && (s = m.access(e), r = m.set(t, s), l = s.events)) for (o in delete r.handle, r.events = {}, l) for (i = 0, n = l[o].length; i < n; i++) S.event.add(t, o, l[o][i]);
            a.hasData(e) && (s = a.access(e), r = S.extend({}, s), a.set(t, r))
        }
    }

    function C(i, n, o, s) {
        n = P.apply([], n);
        var e, t, r, l, a, c, d = 0, u = i.length, p = u - 1, h = n[0], f = S.isFunction(h);
        if (f || 1 < u && "string" == typeof h && !v.checkClone && ke.test(h)) return i.each(function (e) {
            var t = i.eq(e);
            f && (n[0] = h.call(this, e, t.html())), C(t, n, o, s)
        });
        if (u && (t = (e = he(n, i[0].ownerDocument, !1, i, s)).firstChild, 1 === e.childNodes.length && (e = t), t || s)) {
            for (l = (r = S.map(x(e, "script"), Ee)).length; d < u; d++) a = e, d !== p && (a = S.clone(a, !0, !0), l) && S.merge(r, x(a, "script")), o.call(i[d], a, d);
            if (l) for (c = r[r.length - 1].ownerDocument, S.map(r, Ae), d = 0; d < l; d++) a = r[d], de.test(a.type || "") && !m.access(a, "globalEval") && S.contains(c, a) && (a.src ? S._evalUrl && S._evalUrl(a.src) : S.globalEval(a.textContent.replace(Te, "")))
        }
        return i
    }

    function Oe(e, t, i) {
        for (var n, o = t ? S.filter(t, e) : e, s = 0; null != (n = o[s]); s++) i || 1 !== n.nodeType || S.cleanData(x(n)), n.parentNode && (i && S.contains(n.ownerDocument, n) && ue(x(n, "script")), n.parentNode.removeChild(n));
        return e
    }

    S.extend({
        htmlPrefilter: function (e) {
            return e.replace(xe, "<$1></$2>")
        }, clone: function (e, t, i) {
            var n, o, s, r, l, a, c, d = e.cloneNode(!0), u = S.contains(e.ownerDocument, e);
            if (!(v.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || S.isXMLDoc(e))) for (r = x(d), n = 0, o = (s = x(e)).length; n < o; n++) l = s[n], a = r[n], c = void 0, "input" === (c = a.nodeName.toLowerCase()) && ae.test(l.type) ? a.checked = l.checked : "input" !== c && "textarea" !== c || (a.defaultValue = l.defaultValue);
            if (t) if (i) for (s = s || x(e), r = r || x(d), n = 0, o = s.length; n < o; n++) $e(s[n], r[n]); else $e(e, d);
            return 0 < (r = x(d, "script")).length && ue(r, !u && x(e, "script")), d
        }, cleanData: function (e) {
            for (var t, i, n, o = S.event.special, s = 0; void 0 !== (i = e[s]); s++) if (g(i)) {
                if (t = i[m.expando]) {
                    if (t.events) for (n in t.events) o[n] ? S.event.remove(i, n) : S.removeEvent(i, n, t.handle);
                    i[m.expando] = void 0
                }
                i[a.expando] && (i[a.expando] = void 0)
            }
        }
    }), S.fn.extend({
        domManip: C, detach: function (e) {
            return Oe(this, e, !0)
        }, remove: function (e) {
            return Oe(this, e)
        }, text: function (e) {
            return u(this, function (e) {
                return void 0 === e ? S.text(this) : this.empty().each(function () {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                })
            }, null, e, arguments.length)
        }, append: function () {
            return C(this, arguments, function (e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || Ce(this, e).appendChild(e)
            })
        }, prepend: function () {
            return C(this, arguments, function (e) {
                var t;
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (t = Ce(this, e)).insertBefore(e, t.firstChild)
            })
        }, before: function () {
            return C(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return C(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (S.cleanData(x(e, !1)), e.textContent = "");
            return this
        }, clone: function (e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function () {
                return S.clone(this, e, t)
            })
        }, html: function (e) {
            return u(this, function (e) {
                var t = this[0] || {}, i = 0, n = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !we.test(e) && !b[(ce.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = S.htmlPrefilter(e);
                    try {
                        for (; i < n; i++) 1 === (t = this[i] || {}).nodeType && (S.cleanData(x(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {
                    }
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function () {
            var i = [];
            return C(this, arguments, function (e) {
                var t = this.parentNode;
                S.inArray(this, i) < 0 && (S.cleanData(x(this)), t) && t.replaceChild(e, this)
            }, i)
        }
    }), S.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, r) {
        S.fn[e] = function (e) {
            for (var t, i = [], n = S(e), o = n.length - 1, s = 0; s <= o; s++) t = s === o ? this : this.clone(!0), S(n[s])[r](t), z.apply(i, t.get());
            return this.pushStack(i)
        }
    });
    var Le, Ne = {HTML: "block", BODY: "block"};

    function De(e, t) {
        e = S(t.createElement(e)).appendTo(t.body), t = S.css(e[0], "display");
        return e.detach(), t
    }

    function Me(e) {
        var t = k, i = Ne[e];
        return i || ("none" !== (i = De(e, t)) && i || ((t = (Le = (Le || S("<iframe frameborder='0' width='0' height='0'/>")).appendTo(t.documentElement))[0].contentDocument).write(), t.close(), i = De(e, t), Le.detach()), Ne[e] = i), i
    }

    function qe(e) {
        var t = e.ownerDocument.defaultView;
        return (t = t && t.opener ? t : w).getComputedStyle(e)
    }

    function je(e, t, i, n) {
        var o, s = {};
        for (o in t) s[o] = e.style[o], e.style[o] = t[o];
        for (o in i = i.apply(e, n || []), t) e.style[o] = s[o];
        return i
    }

    var He, s, We, Pe, r, h, ze = /^margin/, Re = new RegExp("^(" + e + ")(?!px)[a-z%]+$", "i"), E = k.documentElement;

    function Ie() {
        h.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", h.innerHTML = "", E.appendChild(r);
        var e = w.getComputedStyle(h);
        He = "1%" !== e.top, Pe = "2px" === e.marginLeft, s = "4px" === e.width, h.style.marginRight = "50%", We = "4px" === e.marginRight, E.removeChild(r)
    }

    function A(e, t, i) {
        var n, o, s = e.style;
        return "" !== (o = (i = i || qe(e)) ? i.getPropertyValue(t) || i[t] : void 0) && void 0 !== o || S.contains(e.ownerDocument, e) || (o = S.style(e, t)), i && !v.pixelMarginRight() && Re.test(o) && ze.test(t) && (e = s.width, t = s.minWidth, n = s.maxWidth, s.minWidth = s.maxWidth = s.width = o, o = i.width, s.width = e, s.minWidth = t, s.maxWidth = n), void 0 !== o ? o + "" : o
    }

    function _e(e, t) {
        return {
            get: function () {
                return e() ? void delete this.get : (this.get = t).apply(this, arguments)
            }
        }
    }

    r = k.createElement("div"), (h = k.createElement("div")).style && (h.style.backgroundClip = "content-box", h.cloneNode(!0).style.backgroundClip = "", v.clearCloneStyle = "content-box" === h.style.backgroundClip, r.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", r.appendChild(h), S.extend(v, {
        pixelPosition: function () {
            return Ie(), He
        }, boxSizingReliable: function () {
            return null == s && Ie(), s
        }, pixelMarginRight: function () {
            return null == s && Ie(), We
        }, reliableMarginLeft: function () {
            return null == s && Ie(), Pe
        }, reliableMarginRight: function () {
            var e, t = h.appendChild(k.createElement("div"));
            return t.style.cssText = h.style.cssText = "-webkit-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", t.style.marginRight = t.style.width = "0", h.style.width = "1px", E.appendChild(r), e = !parseFloat(w.getComputedStyle(t).marginRight), E.removeChild(r), h.removeChild(t), e
        }
    }));
    var Fe = /^(none|table(?!-c[ea]).+)/, Be = {position: "absolute", visibility: "hidden", display: "block"},
        Xe = {letterSpacing: "0", fontWeight: "400"}, Ve = ["Webkit", "O", "Moz", "ms"],
        Ye = k.createElement("div").style;

    function Ue(e) {
        if (e in Ye) return e;
        for (var t = e[0].toUpperCase() + e.slice(1), i = Ve.length; i--;) if ((e = Ve[i] + t) in Ye) return e
    }

    function Ge(e, t, i) {
        var n = p.exec(t);
        return n ? Math.max(0, n[2] - (i || 0)) + (n[3] || "px") : t
    }

    function Qe(e, t, i, n, o) {
        for (var s = i === (n ? "border" : "content") ? 4 : "width" === t ? 1 : 0, r = 0; s < 4; s += 2) "margin" === i && (r += S.css(e, i + l[s], !0, o)), n ? ("content" === i && (r -= S.css(e, "padding" + l[s], !0, o)), "margin" !== i && (r -= S.css(e, "border" + l[s] + "Width", !0, o))) : (r += S.css(e, "padding" + l[s], !0, o), "padding" !== i && (r += S.css(e, "border" + l[s] + "Width", !0, o)));
        return r
    }

    function Je(e, t, i) {
        var n = !0, o = "width" === t ? e.offsetWidth : e.offsetHeight, s = qe(e),
            r = "border-box" === S.css(e, "boxSizing", !1, s);
        if (o <= 0 || null == o) {
            if (((o = A(e, t, s)) < 0 || null == o) && (o = e.style[t]), Re.test(o)) return o;
            n = r && (v.boxSizingReliable() || o === e.style[t]), o = parseFloat(o) || 0
        }
        return o + Qe(e, t, i || (r ? "border" : "content"), n, s) + "px"
    }

    function Ke(e, t) {
        for (var i, n, o, s = [], r = 0, l = e.length; r < l; r++) (n = e[r]).style && (s[r] = m.get(n, "olddisplay"), i = n.style.display, t ? (s[r] || "none" !== i || (n.style.display = ""), "" === n.style.display && y(n) && (s[r] = m.access(n, "olddisplay", Me(n.nodeName)))) : (o = y(n), "none" === i && o || m.set(n, "olddisplay", o ? i : S.css(n, "display"))));
        for (r = 0; r < l; r++) !(n = e[r]).style || t && "none" !== n.style.display && "" !== n.style.display || (n.style.display = t ? s[r] || "" : "none");
        return e
    }

    function $(e, t, i, n, o) {
        return new $.prototype.init(e, t, i, n, o)
    }

    S.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) return "" === (t = A(e, "opacity")) ? "1" : t
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {float: "cssFloat"},
        style: function (e, t, i, n) {
            var o, s, r, l, a;
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) return l = S.camelCase(t), a = e.style, t = S.cssProps[l] || (S.cssProps[l] = Ue(l) || l), r = S.cssHooks[t] || S.cssHooks[l], void 0 === i ? r && "get" in r && void 0 !== (o = r.get(e, !1, n)) ? o : a[t] : ("string" === (s = typeof i) && (o = p.exec(i)) && o[1] && (i = le(e, t, o), s = "number"), void (null != i && i == i && ("number" === s && (i += o && o[3] || (S.cssNumber[l] ? "" : "px")), v.clearCloneStyle || "" !== i || 0 !== t.indexOf("background") || (a[t] = "inherit"), r && "set" in r && void 0 === (i = r.set(e, i, n)) || (a[t] = i))))
        },
        css: function (e, t, i, n) {
            var o, s = S.camelCase(t);
            return t = S.cssProps[s] || (S.cssProps[s] = Ue(s) || s), "normal" === (o = void 0 === (o = (s = S.cssHooks[t] || S.cssHooks[s]) && "get" in s ? s.get(e, !0, i) : o) ? A(e, t, n) : o) && t in Xe && (o = Xe[t]), ("" === i || i) && (s = parseFloat(o), !0 === i || isFinite(s)) ? s || 0 : o
        }
    }), S.each(["height", "width"], function (e, o) {
        S.cssHooks[o] = {
            get: function (e, t, i) {
                return t ? Fe.test(S.css(e, "display")) && 0 === e.offsetWidth ? je(e, Be, function () {
                    return Je(e, o, i)
                }) : Je(e, o, i) : void 0
            }, set: function (e, t, i) {
                var n = i && qe(e), i = i && Qe(e, o, i, "border-box" === S.css(e, "boxSizing", !1, n), n);
                return i && (n = p.exec(t)) && "px" !== (n[3] || "px") && (e.style[o] = t, t = S.css(e, o)), Ge(0, t, i)
            }
        }
    }), S.cssHooks.marginLeft = _e(v.reliableMarginLeft, function (e, t) {
        return t ? (parseFloat(A(e, "marginLeft")) || e.getBoundingClientRect().left - je(e, {marginLeft: 0}, function () {
            return e.getBoundingClientRect().left
        })) + "px" : void 0
    }), S.cssHooks.marginRight = _e(v.reliableMarginRight, function (e, t) {
        return t ? je(e, {display: "inline-block"}, A, [e, "marginRight"]) : void 0
    }), S.each({margin: "", padding: "", border: "Width"}, function (o, s) {
        S.cssHooks[o + s] = {
            expand: function (e) {
                for (var t = 0, i = {}, n = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) i[o + l[t] + s] = n[t] || n[t - 2] || n[0];
                return i
            }
        }, ze.test(o) || (S.cssHooks[o + s].set = Ge)
    }), S.fn.extend({
        css: function (e, t) {
            return u(this, function (e, t, i) {
                var n, o, s = {}, r = 0;
                if (S.isArray(t)) {
                    for (n = qe(e), o = t.length; r < o; r++) s[t[r]] = S.css(e, t[r], !1, n);
                    return s
                }
                return void 0 !== i ? S.style(e, t, i) : S.css(e, t)
            }, e, t, 1 < arguments.length)
        }, show: function () {
            return Ke(this, !0)
        }, hide: function () {
            return Ke(this)
        }, toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function () {
                y(this) ? S(this).show() : S(this).hide()
            })
        }
    }), ((S.Tween = $).prototype = {
        constructor: $, init: function (e, t, i, n, o, s) {
            this.elem = e, this.prop = i, this.easing = o || S.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = n, this.unit = s || (S.cssNumber[i] ? "" : "px")
        }, cur: function () {
            var e = $.propHooks[this.prop];
            return (e && e.get ? e : $.propHooks._default).get(this)
        }, run: function (e) {
            var t, i = $.propHooks[this.prop];
            return this.options.duration ? this.pos = t = S.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), (i && i.set ? i : $.propHooks._default).set(this), this
        }
    }).init.prototype = $.prototype, ($.propHooks = {
        _default: {
            get: function (e) {
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (e = S.css(e.elem, e.prop, "")) && "auto" !== e ? e : 0
            }, set: function (e) {
                S.fx.step[e.prop] ? S.fx.step[e.prop](e) : 1 !== e.elem.nodeType || null == e.elem.style[S.cssProps[e.prop]] && !S.cssHooks[e.prop] ? e.elem[e.prop] = e.now : S.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }).scrollTop = $.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, S.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }, _default: "swing"
    }, S.fx = $.prototype.init, S.fx.step = {};
    var O, Ze, L, et = /^(?:toggle|show|hide)$/, tt = /queueHooks$/;

    function it() {
        return w.setTimeout(function () {
            O = void 0
        }), O = S.now()
    }

    function nt(e, t) {
        var i, n = 0, o = {height: e};
        for (t = t ? 1 : 0; n < 4; n += 2 - t) o["margin" + (i = l[n])] = o["padding" + i] = e;
        return t && (o.opacity = o.width = e), o
    }

    function ot(e, t, i) {
        for (var n, o = (N.tweeners[t] || []).concat(N.tweeners["*"]), s = 0, r = o.length; s < r; s++) if (n = o[s].call(i, t, e)) return n
    }

    function N(o, e, t) {
        var i, s, n, r, l, a, c, d = 0, u = N.prefilters.length, p = S.Deferred().always(function () {
            delete h.elem
        }), h = function () {
            if (s) return !1;
            for (var e = O || it(), e = Math.max(0, f.startTime + f.duration - e), t = 1 - (e / f.duration || 0), i = 0, n = f.tweens.length; i < n; i++) f.tweens[i].run(t);
            return p.notifyWith(o, [f, t, e]), t < 1 && n ? e : (p.resolveWith(o, [f]), !1)
        }, f = p.promise({
            elem: o,
            props: S.extend({}, e),
            opts: S.extend(!0, {specialEasing: {}, easing: S.easing._default}, t),
            originalProperties: e,
            originalOptions: t,
            startTime: O || it(),
            duration: t.duration,
            tweens: [],
            createTween: function (e, t) {
                t = S.Tween(o, f.opts, e, t, f.opts.specialEasing[e] || f.opts.easing);
                return f.tweens.push(t), t
            },
            stop: function (e) {
                var t = 0, i = e ? f.tweens.length : 0;
                if (!s) {
                    for (s = !0; t < i; t++) f.tweens[t].run(1);
                    e ? (p.notifyWith(o, [f, 1, 0]), p.resolveWith(o, [f, e])) : p.rejectWith(o, [f, e])
                }
                return this
            }
        }), v = f.props, g = v, m = f.opts.specialEasing;
        for (n in g) if (r = S.camelCase(n), l = m[r], a = g[n], S.isArray(a) && (l = a[1], a = g[n] = a[0]), n !== r && (g[r] = a, delete g[n]), c = S.cssHooks[r], c && "expand" in c) for (n in a = c.expand(a), delete g[r], a) n in g || (g[n] = a[n], m[n] = l); else m[r] = l;
        for (; d < u; d++) if (i = N.prefilters[d].call(f, o, v, f.opts)) return S.isFunction(i.stop) && (S._queueHooks(f.elem, f.opts.queue).stop = S.proxy(i.stop, i)), i;
        return S.map(v, ot, f), S.isFunction(f.opts.start) && f.opts.start.call(o, f), S.fx.timer(S.extend(h, {
            elem: o,
            anim: f,
            queue: f.opts.queue
        })), f.progress(f.opts.progress).done(f.opts.done, f.opts.complete).fail(f.opts.fail).always(f.opts.always)
    }

    S.Animation = S.extend(N, {
        tweeners: {
            "*": [function (e, t) {
                var i = this.createTween(e, t);
                return le(i.elem, e, p.exec(t), i), i
            }]
        }, tweener: function (e, t) {
            for (var i, n = 0, o = (e = S.isFunction(e) ? (t = e, ["*"]) : e.match(T)).length; n < o; n++) i = e[n], N.tweeners[i] = N.tweeners[i] || [], N.tweeners[i].unshift(t)
        }, prefilters: [function (t, e, i) {
            var n, o, s, r, l, a, c, d = this, u = {}, p = t.style, h = t.nodeType && y(t), f = m.get(t, "fxshow");
            for (n in i.queue || (null == (l = S._queueHooks(t, "fx")).unqueued && (l.unqueued = 0, a = l.empty.fire, l.empty.fire = function () {
                l.unqueued || a()
            }), l.unqueued++, d.always(function () {
                d.always(function () {
                    l.unqueued--, S.queue(t, "fx").length || l.empty.fire()
                })
            })), 1 === t.nodeType && ("height" in e || "width" in e) && (i.overflow = [p.overflow, p.overflowX, p.overflowY], "inline" === ("none" === (c = S.css(t, "display")) ? m.get(t, "olddisplay") || Me(t.nodeName) : c)) && "none" === S.css(t, "float") && (p.display = "inline-block"), i.overflow && (p.overflow = "hidden", d.always(function () {
                p.overflow = i.overflow[0], p.overflowX = i.overflow[1], p.overflowY = i.overflow[2]
            })), e) if (o = e[n], et.exec(o)) {
                if (delete e[n], s = s || "toggle" === o, o === (h ? "hide" : "show")) {
                    if ("show" !== o || !f || void 0 === f[n]) continue;
                    h = !0
                }
                u[n] = f && f[n] || S.style(t, n)
            } else c = void 0;
            if (S.isEmptyObject(u)) "inline" === ("none" === c ? Me(t.nodeName) : c) && (p.display = c); else for (n in f ? "hidden" in f && (h = f.hidden) : f = m.access(t, "fxshow", {}), s && (f.hidden = !h), h ? S(t).show() : d.done(function () {
                S(t).hide()
            }), d.done(function () {
                for (var e in m.remove(t, "fxshow"), u) S.style(t, e, u[e])
            }), u) r = ot(h ? f[n] : 0, n, d), n in f || (f[n] = r.start, h && (r.end = r.start, r.start = "width" === n || "height" === n ? 1 : 0))
        }], prefilter: function (e, t) {
            t ? N.prefilters.unshift(e) : N.prefilters.push(e)
        }
    }), S.speed = function (e, t, i) {
        var n = e && "object" == typeof e ? S.extend({}, e) : {
            complete: i || !i && t || S.isFunction(e) && e,
            duration: e,
            easing: i && t || t && !S.isFunction(t) && t
        };
        return n.duration = S.fx.off ? 0 : "number" == typeof n.duration ? n.duration : n.duration in S.fx.speeds ? S.fx.speeds[n.duration] : S.fx.speeds._default, null != n.queue && !0 !== n.queue || (n.queue = "fx"), n.old = n.complete, n.complete = function () {
            S.isFunction(n.old) && n.old.call(this), n.queue && S.dequeue(this, n.queue)
        }, n
    }, S.fn.extend({
        fadeTo: function (e, t, i, n) {
            return this.filter(y).css("opacity", 0).show().end().animate({opacity: t}, e, i, n)
        }, animate: function (t, e, i, n) {
            function o() {
                var e = N(this, S.extend({}, t), r);
                (s || m.get(this, "finish")) && e.stop(!0)
            }

            var s = S.isEmptyObject(t), r = S.speed(e, i, n);
            return o.finish = o, s || !1 === r.queue ? this.each(o) : this.queue(r.queue, o)
        }, stop: function (o, e, s) {
            function r(e) {
                var t = e.stop;
                delete e.stop, t(s)
            }

            return "string" != typeof o && (s = e, e = o, o = void 0), e && !1 !== o && this.queue(o || "fx", []), this.each(function () {
                var e = !0, t = null != o && o + "queueHooks", i = S.timers, n = m.get(this);
                if (t) n[t] && n[t].stop && r(n[t]); else for (t in n) n[t] && n[t].stop && tt.test(t) && r(n[t]);
                for (t = i.length; t--;) i[t].elem !== this || null != o && i[t].queue !== o || (i[t].anim.stop(s), e = !1, i.splice(t, 1));
                !e && s || S.dequeue(this, o)
            })
        }, finish: function (r) {
            return !1 !== r && (r = r || "fx"), this.each(function () {
                var e, t = m.get(this), i = t[r + "queue"], n = t[r + "queueHooks"], o = S.timers, s = i ? i.length : 0;
                for (t.finish = !0, S.queue(this, r, []), n && n.stop && n.stop.call(this, !0), e = o.length; e--;) o[e].elem === this && o[e].queue === r && (o[e].anim.stop(!0), o.splice(e, 1));
                for (e = 0; e < s; e++) i[e] && i[e].finish && i[e].finish.call(this);
                delete t.finish
            })
        }
    }), S.each(["toggle", "show", "hide"], function (e, n) {
        var o = S.fn[n];
        S.fn[n] = function (e, t, i) {
            return null == e || "boolean" == typeof e ? o.apply(this, arguments) : this.animate(nt(n, !0), e, t, i)
        }
    }), S.each({
        slideDown: nt("show"),
        slideUp: nt("hide"),
        slideToggle: nt("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, n) {
        S.fn[e] = function (e, t, i) {
            return this.animate(n, e, t, i)
        }
    }), S.timers = [], S.fx.tick = function () {
        var e, t = 0, i = S.timers;
        for (O = S.now(); t < i.length; t++) (e = i[t])() || i[t] !== e || i.splice(t--, 1);
        i.length || S.fx.stop(), O = void 0
    }, S.fx.timer = function (e) {
        S.timers.push(e), e() ? S.fx.start() : S.timers.pop()
    }, S.fx.interval = 13, S.fx.start = function () {
        Ze = Ze || w.setInterval(S.fx.tick, S.fx.interval)
    }, S.fx.stop = function () {
        w.clearInterval(Ze), Ze = null
    }, S.fx.speeds = {slow: 600, fast: 200, _default: 400}, S.fn.delay = function (n, e) {
        return n = S.fx && S.fx.speeds[n] || n, this.queue(e = e || "fx", function (e, t) {
            var i = w.setTimeout(e, n);
            t.stop = function () {
                w.clearTimeout(i)
            }
        })
    }, L = k.createElement("input"), t = k.createElement("select"), e = t.appendChild(k.createElement("option")), L.type = "checkbox", v.checkOn = "" !== L.value, v.optSelected = e.selected, t.disabled = !0, v.optDisabled = !e.disabled, (L = k.createElement("input")).value = "t", L.type = "radio", v.radioValue = "t" === L.value;
    var st, D = S.expr.attrHandle, rt = (S.fn.extend({
        attr: function (e, t) {
            return u(this, S.attr, e, t, 1 < arguments.length)
        }, removeAttr: function (e) {
            return this.each(function () {
                S.removeAttr(this, e)
            })
        }
    }), S.extend({
        attr: function (e, t, i) {
            var n, o, s = e.nodeType;
            if (3 !== s && 8 !== s && 2 !== s) return void 0 === e.getAttribute ? S.prop(e, t, i) : (1 === s && S.isXMLDoc(e) || (t = t.toLowerCase(), o = S.attrHooks[t] || (S.expr.match.bool.test(t) ? st : void 0)), void 0 !== i ? null === i ? void S.removeAttr(e, t) : o && "set" in o && void 0 !== (n = o.set(e, i, t)) ? n : (e.setAttribute(t, i + ""), i) : !(o && "get" in o && null !== (n = o.get(e, t))) && null == (n = S.find.attr(e, t)) ? void 0 : n)
        }, attrHooks: {
            type: {
                set: function (e, t) {
                    var i;
                    if (!v.radioValue && "radio" === t && S.nodeName(e, "input")) return i = e.value, e.setAttribute("type", t), i && (e.value = i), t
                }
            }
        }, removeAttr: function (e, t) {
            var i, n, o = 0, s = t && t.match(T);
            if (s && 1 === e.nodeType) for (; i = s[o++];) n = S.propFix[i] || i, S.expr.match.bool.test(i) && (e[n] = !1), e.removeAttribute(i)
        }
    }), st = {
        set: function (e, t, i) {
            return !1 === t ? S.removeAttr(e, i) : e.setAttribute(i, i), i
        }
    }, S.each(S.expr.match.bool.source.match(/\w+/g), function (e, t) {
        var s = D[t] || S.find.attr;
        D[t] = function (e, t, i) {
            var n, o;
            return i || (o = D[t], D[t] = n, n = null != s(e, t, i) ? t.toLowerCase() : null, D[t] = o), n
        }
    }), /^(?:input|select|textarea|button)$/i), lt = /^(?:a|area)$/i, at = (S.fn.extend({
        prop: function (e, t) {
            return u(this, S.prop, e, t, 1 < arguments.length)
        }, removeProp: function (e) {
            return this.each(function () {
                delete this[S.propFix[e] || e]
            })
        }
    }), S.extend({
        prop: function (e, t, i) {
            var n, o, s = e.nodeType;
            if (3 !== s && 8 !== s && 2 !== s) return 1 === s && S.isXMLDoc(e) || (t = S.propFix[t] || t, o = S.propHooks[t]), void 0 !== i ? o && "set" in o && void 0 !== (n = o.set(e, i, t)) ? n : e[t] = i : o && "get" in o && null !== (n = o.get(e, t)) ? n : e[t]
        }, propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = S.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : rt.test(e.nodeName) || lt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }, propFix: {for: "htmlFor", class: "className"}
    }), v.optSelected || (S.propHooks.selected = {
        get: function (e) {
            e = e.parentNode;
            return e && e.parentNode && e.parentNode.selectedIndex, null
        }, set: function (e) {
            e = e.parentNode;
            e && (e.selectedIndex, e.parentNode) && e.parentNode.selectedIndex
        }
    }), S.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        S.propFix[this.toLowerCase()] = this
    }), /[\t\r\n\f]/g);

    function M(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    S.fn.extend({
        addClass: function (t) {
            var e, i, n, o, s, r, l = 0;
            if (S.isFunction(t)) return this.each(function (e) {
                S(this).addClass(t.call(this, e, M(this)))
            });
            if ("string" == typeof t && t) for (e = t.match(T) || []; i = this[l++];) if (r = M(i), n = 1 === i.nodeType && (" " + r + " ").replace(at, " ")) {
                for (s = 0; o = e[s++];) n.indexOf(" " + o + " ") < 0 && (n += o + " ");
                r !== (r = S.trim(n)) && i.setAttribute("class", r)
            }
            return this
        }, removeClass: function (t) {
            var e, i, n, o, s, r, l = 0;
            if (S.isFunction(t)) return this.each(function (e) {
                S(this).removeClass(t.call(this, e, M(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ("string" == typeof t && t) for (e = t.match(T) || []; i = this[l++];) if (r = M(i), n = 1 === i.nodeType && (" " + r + " ").replace(at, " ")) {
                for (s = 0; o = e[s++];) for (; -1 < n.indexOf(" " + o + " ");) n = n.replace(" " + o + " ", " ");
                r !== (r = S.trim(n)) && i.setAttribute("class", r)
            }
            return this
        }, toggleClass: function (o, t) {
            var s = typeof o;
            return "boolean" == typeof t && "string" == s ? t ? this.addClass(o) : this.removeClass(o) : S.isFunction(o) ? this.each(function (e) {
                S(this).toggleClass(o.call(this, e, M(this), t), t)
            }) : this.each(function () {
                var e, t, i, n;
                if ("string" == s) for (t = 0, i = S(this), n = o.match(T) || []; e = n[t++];) i.hasClass(e) ? i.removeClass(e) : i.addClass(e); else void 0 !== o && "boolean" != s || ((e = M(this)) && m.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", !e && !1 !== o && m.get(this, "__className__") || ""))
            })
        }, hasClass: function (e) {
            for (var t, i = 0, n = " " + e + " "; t = this[i++];) if (1 === t.nodeType && -1 < (" " + M(t) + " ").replace(at, " ").indexOf(n)) return !0;
            return !1
        }
    });
    var ct = /\r/g, dt = /[\x20\t\r\n\f]+/g, ut = (S.fn.extend({
            val: function (t) {
                var i, e, n, o = this[0];
                return arguments.length ? (n = S.isFunction(t), this.each(function (e) {
                    1 === this.nodeType && (null == (e = n ? t.call(this, e, S(this).val()) : t) ? e = "" : "number" == typeof e ? e += "" : S.isArray(e) && (e = S.map(e, function (e) {
                        return null == e ? "" : e + ""
                    })), (i = S.valHooks[this.type] || S.valHooks[this.nodeName.toLowerCase()]) && "set" in i && void 0 !== i.set(this, e, "value") || (this.value = e))
                })) : o ? (i = S.valHooks[o.type] || S.valHooks[o.nodeName.toLowerCase()]) && "get" in i && void 0 !== (e = i.get(o, "value")) ? e : "string" == typeof (e = o.value) ? e.replace(ct, "") : null == e ? "" : e : void 0
            }
        }), S.extend({
            valHooks: {
                option: {
                    get: function (e) {
                        var t = S.find.attr(e, "value");
                        return null != t ? t : S.trim(S.text(e)).replace(dt, " ")
                    }
                }, select: {
                    get: function (e) {
                        for (var t, i = e.options, n = e.selectedIndex, o = "select-one" === e.type || n < 0, s = o ? null : [], r = o ? n + 1 : i.length, l = n < 0 ? r : o ? n : 0; l < r; l++) if (((t = i[l]).selected || l === n) && (v.optDisabled ? !t.disabled : null === t.getAttribute("disabled")) && (!t.parentNode.disabled || !S.nodeName(t.parentNode, "optgroup"))) {
                            if (t = S(t).val(), o) return t;
                            s.push(t)
                        }
                        return s
                    }, set: function (e, t) {
                        for (var i, n, o = e.options, s = S.makeArray(t), r = o.length; r--;) ((n = o[r]).selected = -1 < S.inArray(S.valHooks.option.get(n), s)) && (i = !0);
                        return i || (e.selectedIndex = -1), s
                    }
                }
            }
        }), S.each(["radio", "checkbox"], function () {
            S.valHooks[this] = {
                set: function (e, t) {
                    return S.isArray(t) ? e.checked = -1 < S.inArray(S(e).val(), t) : void 0
                }
            }, v.checkOn || (S.valHooks[this].get = function (e) {
                return null === e.getAttribute("value") ? "on" : e.value
            })
        }), /^(?:focusinfocus|focusoutblur)$/), q = (S.extend(S.event, {
            trigger: function (e, t, i, n) {
                var o, s, r, l, a, c, d = [i || k], u = f.call(e, "type") ? e.type : e,
                    p = f.call(e, "namespace") ? e.namespace.split(".") : [], h = s = i = i || k;
                if (3 !== i.nodeType && 8 !== i.nodeType && !ut.test(u + S.event.triggered) && (-1 < u.indexOf(".") && (u = (p = u.split(".")).shift(), p.sort()), l = u.indexOf(":") < 0 && "on" + u, (e = e[S.expando] ? e : new S.Event(u, "object" == typeof e && e)).isTrigger = n ? 2 : 3, e.namespace = p.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = i), t = null == t ? [e] : S.makeArray(t, [e]), c = S.event.special[u] || {}, n || !c.trigger || !1 !== c.trigger.apply(i, t))) {
                    if (!n && !c.noBubble && !S.isWindow(i)) {
                        for (r = c.delegateType || u, ut.test(r + u) || (h = h.parentNode); h; h = h.parentNode) d.push(h), s = h;
                        s === (i.ownerDocument || k) && d.push(s.defaultView || s.parentWindow || w)
                    }
                    for (o = 0; (h = d[o++]) && !e.isPropagationStopped();) e.type = 1 < o ? r : c.bindType || u, (a = (m.get(h, "events") || {})[e.type] && m.get(h, "handle")) && a.apply(h, t), (a = l && h[l]) && a.apply && g(h) && (e.result = a.apply(h, t), !1 === e.result) && e.preventDefault();
                    return e.type = u, n || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(d.pop(), t) || !g(i) || l && S.isFunction(i[u]) && !S.isWindow(i) && ((s = i[l]) && (i[l] = null), i[S.event.triggered = u](), S.event.triggered = void 0, s) && (i[l] = s), e.result
                }
            }, simulate: function (e, t, i) {
                i = S.extend(new S.Event, i, {type: e, isSimulated: !0});
                S.event.trigger(i, null, t)
            }
        }), S.fn.extend({
            trigger: function (e, t) {
                return this.each(function () {
                    S.event.trigger(e, t, this)
                })
            }, triggerHandler: function (e, t) {
                var i = this[0];
                return i ? S.event.trigger(e, t, i, !0) : void 0
            }
        }), S.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (e, i) {
            S.fn[i] = function (e, t) {
                return 0 < arguments.length ? this.on(i, null, e, t) : this.trigger(i)
            }
        }), S.fn.extend({
            hover: function (e, t) {
                return this.mouseenter(e).mouseleave(t || e)
            }
        }), v.focusin = "onfocusin" in w, v.focusin || S.each({focus: "focusin", blur: "focusout"}, function (i, n) {
            function o(e) {
                S.event.simulate(n, e.target, S.event.fix(e))
            }

            S.event.special[n] = {
                setup: function () {
                    var e = this.ownerDocument || this, t = m.access(e, n);
                    t || e.addEventListener(i, o, !0), m.access(e, n, (t || 0) + 1)
                }, teardown: function () {
                    var e = this.ownerDocument || this, t = m.access(e, n) - 1;
                    t ? m.access(e, n, t) : (e.removeEventListener(i, o, !0), m.remove(e, n))
                }
            }
        }), w.location), pt = S.now(), ht = /\?/, ft = (S.parseJSON = function (e) {
            return JSON.parse(e + "")
        }, S.parseXML = function (e) {
            var t;
            if (!e || "string" != typeof e) return null;
            try {
                t = (new w.DOMParser).parseFromString(e, "text/xml")
            } catch (e) {
                t = void 0
            }
            return t && !t.getElementsByTagName("parsererror").length || S.error("Invalid XML: " + e), t
        }, /#.*$/), vt = /([?&])_=[^&]*/, gt = /^(.*?):[ \t]*([^\r\n]*)$/gm, mt = /^(?:GET|HEAD)$/, yt = /^\/\//, bt = {},
        xt = {}, wt = "*/".concat("*"), kt = k.createElement("a");

    function St(s) {
        return function (e, t) {
            "string" != typeof e && (t = e, e = "*");
            var i, n = 0, o = e.toLowerCase().match(T) || [];
            if (S.isFunction(t)) for (; i = o[n++];) "+" === i[0] ? (i = i.slice(1) || "*", (s[i] = s[i] || []).unshift(t)) : (s[i] = s[i] || []).push(t)
        }
    }

    function Tt(t, n, o, s) {
        var r = {}, l = t === xt;

        function a(e) {
            var i;
            return r[e] = !0, S.each(t[e] || [], function (e, t) {
                t = t(n, o, s);
                return "string" != typeof t || l || r[t] ? l ? !(i = t) : void 0 : (n.dataTypes.unshift(t), a(t), !1)
            }), i
        }

        return a(n.dataTypes[0]) || !r["*"] && a("*")
    }

    function Ct(e, t) {
        var i, n, o = S.ajaxSettings.flatOptions || {};
        for (i in t) void 0 !== t[i] && ((o[i] ? e : n = n || {})[i] = t[i]);
        return n && S.extend(!0, e, n), e
    }

    kt.href = q.href, S.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: q.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(q.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": wt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": S.parseJSON, "text xml": S.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? Ct(Ct(e, S.ajaxSettings), t) : Ct(S.ajaxSettings, e)
        },
        ajaxPrefilter: St(bt),
        ajaxTransport: St(xt),
        ajax: function (e, t) {
            "object" == typeof e && (t = e, e = void 0);
            var a, c, d, i, u, p, n, h = S.ajaxSetup({}, t = t || {}), f = h.context || h,
                v = h.context && (f.nodeType || f.jquery) ? S(f) : S.event, g = S.Deferred(),
                m = S.Callbacks("once memory"), y = h.statusCode || {}, o = {}, s = {}, b = 0, r = "canceled", x = {
                    readyState: 0, getResponseHeader: function (e) {
                        var t;
                        if (2 === b) {
                            if (!i) for (i = {}; t = gt.exec(d);) i[t[1].toLowerCase()] = t[2];
                            t = i[e.toLowerCase()]
                        }
                        return null == t ? null : t
                    }, getAllResponseHeaders: function () {
                        return 2 === b ? d : null
                    }, setRequestHeader: function (e, t) {
                        var i = e.toLowerCase();
                        return b || (e = s[i] = s[i] || e, o[e] = t), this
                    }, overrideMimeType: function (e) {
                        return b || (h.mimeType = e), this
                    }, statusCode: function (e) {
                        if (e) if (b < 2) for (var t in e) y[t] = [y[t], e[t]]; else x.always(e[x.status]);
                        return this
                    }, abort: function (e) {
                        e = e || r;
                        return a && a.abort(e), l(0, e), this
                    }
                };
            if (g.promise(x).complete = m.add, x.success = x.done, x.error = x.fail, h.url = ((e || h.url || q.href) + "").replace(ft, "").replace(yt, q.protocol + "//"), h.type = t.method || t.type || h.method || h.type, h.dataTypes = S.trim(h.dataType || "*").toLowerCase().match(T) || [""], null == h.crossDomain) {
                e = k.createElement("a");
                try {
                    e.href = h.url, e.href = e.href, h.crossDomain = kt.protocol + "//" + kt.host != e.protocol + "//" + e.host
                } catch (e) {
                    h.crossDomain = !0
                }
            }
            if (h.data && h.processData && "string" != typeof h.data && (h.data = S.param(h.data, h.traditional)), Tt(bt, h, t, x), 2 !== b) {
                for (n in (p = S.event && h.global) && 0 == S.active++ && S.event.trigger("ajaxStart"), h.type = h.type.toUpperCase(), h.hasContent = !mt.test(h.type), c = h.url, h.hasContent || (h.data && (c = h.url += (ht.test(c) ? "&" : "?") + h.data, delete h.data), !1 === h.cache && (h.url = vt.test(c) ? c.replace(vt, "$1_=" + pt++) : c + (ht.test(c) ? "&" : "?") + "_=" + pt++)), h.ifModified && (S.lastModified[c] && x.setRequestHeader("If-Modified-Since", S.lastModified[c]), S.etag[c]) && x.setRequestHeader("If-None-Match", S.etag[c]), (h.data && h.hasContent && !1 !== h.contentType || t.contentType) && x.setRequestHeader("Content-Type", h.contentType), x.setRequestHeader("Accept", h.dataTypes[0] && h.accepts[h.dataTypes[0]] ? h.accepts[h.dataTypes[0]] + ("*" !== h.dataTypes[0] ? ", " + wt + "; q=0.01" : "") : h.accepts["*"]), h.headers) x.setRequestHeader(n, h.headers[n]);
                if (h.beforeSend && (!1 === h.beforeSend.call(f, x, h) || 2 === b)) return x.abort();
                for (n in r = "abort", {success: 1, error: 1, complete: 1}) x[n](h[n]);
                if (a = Tt(xt, h, t, x)) {
                    if (x.readyState = 1, p && v.trigger("ajaxSend", [x, h]), 2 === b) return x;
                    h.async && 0 < h.timeout && (u = w.setTimeout(function () {
                        x.abort("timeout")
                    }, h.timeout));
                    try {
                        b = 1, a.send(o, l)
                    } catch (e) {
                        if (!(b < 2)) throw e;
                        l(-1, e)
                    }
                } else l(-1, "No Transport")
            }
            return x;

            function l(e, t, i, n) {
                var o, s, r, l = t;
                2 !== b && (b = 2, u && w.clearTimeout(u), a = void 0, d = n || "", x.readyState = 0 < e ? 4 : 0, n = 200 <= e && e < 300 || 304 === e, i && (r = function (e, t, i) {
                    for (var n, o, s, r, l = e.contents, a = e.dataTypes; "*" === a[0];) a.shift(), void 0 === n && (n = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (n) for (o in l) if (l[o] && l[o].test(n)) {
                        a.unshift(o);
                        break
                    }
                    if (a[0] in i) s = a[0]; else {
                        for (o in i) {
                            if (!a[0] || e.converters[o + " " + a[0]]) {
                                s = o;
                                break
                            }
                            r = r || o
                        }
                        s = s || r
                    }
                    return s ? (s !== a[0] && a.unshift(s), i[s]) : void 0
                }(h, x, i)), r = function (e, t, i, n) {
                    var o, s, r, l, a, c = {}, d = e.dataTypes.slice();
                    if (d[1]) for (r in e.converters) c[r.toLowerCase()] = e.converters[r];
                    for (s = d.shift(); s;) if (e.responseFields[s] && (i[e.responseFields[s]] = t), !a && n && e.dataFilter && (t = e.dataFilter(t, e.dataType)), a = s, s = d.shift()) if ("*" === s) s = a; else if ("*" !== a && a !== s) {
                        if (!(r = c[a + " " + s] || c["* " + s])) for (o in c) if (l = o.split(" "), l[1] === s && (r = c[a + " " + l[0]] || c["* " + l[0]])) {
                            !0 === r ? r = c[o] : !0 !== c[o] && (s = l[0], d.unshift(l[1]));
                            break
                        }
                        if (!0 !== r) if (r && e.throws) t = r(t); else try {
                            t = r(t)
                        } catch (e) {
                            return {state: "parsererror", error: r ? e : "No conversion from " + a + " to " + s}
                        }
                    }
                    return {state: "success", data: t}
                }(h, r, x, n), n ? (h.ifModified && ((i = x.getResponseHeader("Last-Modified")) && (S.lastModified[c] = i), i = x.getResponseHeader("etag")) && (S.etag[c] = i), 204 === e || "HEAD" === h.type ? l = "nocontent" : 304 === e ? l = "notmodified" : (l = r.state, o = r.data, n = !(s = r.error))) : (s = l, !e && l || (l = "error", e < 0 && (e = 0))), x.status = e, x.statusText = (t || l) + "", n ? g.resolveWith(f, [o, l, x]) : g.rejectWith(f, [x, l, s]), x.statusCode(y), y = void 0, p && v.trigger(n ? "ajaxSuccess" : "ajaxError", [x, h, n ? o : s]), m.fireWith(f, [x, l]), p) && (v.trigger("ajaxComplete", [x, h]), --S.active || S.event.trigger("ajaxStop"))
            }
        },
        getJSON: function (e, t, i) {
            return S.get(e, t, i, "json")
        },
        getScript: function (e, t) {
            return S.get(e, void 0, t, "script")
        }
    }), S.each(["get", "post"], function (e, o) {
        S[o] = function (e, t, i, n) {
            return S.isFunction(t) && (n = n || i, i = t, t = void 0), S.ajax(S.extend({
                url: e,
                type: o,
                dataType: n,
                data: t,
                success: i
            }, S.isPlainObject(e) && e))
        }
    }), S._evalUrl = function (e) {
        return S.ajax({url: e, type: "GET", dataType: "script", async: !1, global: !1, throws: !0})
    }, S.fn.extend({
        wrapAll: function (t) {
            var e;
            return S.isFunction(t) ? this.each(function (e) {
                S(this).wrapAll(t.call(this, e))
            }) : (this[0] && (e = S(t, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && e.insertBefore(this[0]), e.map(function () {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            }).append(this)), this)
        }, wrapInner: function (i) {
            return S.isFunction(i) ? this.each(function (e) {
                S(this).wrapInner(i.call(this, e))
            }) : this.each(function () {
                var e = S(this), t = e.contents();
                t.length ? t.wrapAll(i) : e.append(i)
            })
        }, wrap: function (t) {
            var i = S.isFunction(t);
            return this.each(function (e) {
                S(this).wrapAll(i ? t.call(this, e) : t)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                S.nodeName(this, "body") || S(this).replaceWith(this.childNodes)
            }).end()
        }
    }), S.expr.filters.hidden = function (e) {
        return !S.expr.filters.visible(e)
    }, S.expr.filters.visible = function (e) {
        return 0 < e.offsetWidth || 0 < e.offsetHeight || 0 < e.getClientRects().length
    };
    var Et = /%20/g, At = /\[\]$/, $t = /\r?\n/g, Ot = /^(?:submit|button|image|reset|file)$/i,
        Lt = /^(?:input|select|textarea|keygen)/i;
    S.param = function (e, t) {
        function i(e, t) {
            t = S.isFunction(t) ? t() : null == t ? "" : t, o[o.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
        }

        var n, o = [];
        if (void 0 === t && (t = S.ajaxSettings && S.ajaxSettings.traditional), S.isArray(e) || e.jquery && !S.isPlainObject(e)) S.each(e, function () {
            i(this.name, this.value)
        }); else for (n in e) !function i(n, e, o, s) {
            if (S.isArray(e)) S.each(e, function (e, t) {
                o || At.test(n) ? s(n, t) : i(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, o, s)
            }); else if (o || "object" !== S.type(e)) s(n, e); else for (var t in e) i(n + "[" + t + "]", e[t], o, s)
        }(n, e[n], t, i);
        return o.join("&").replace(Et, "+")
    }, S.fn.extend({
        serialize: function () {
            return S.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = S.prop(this, "elements");
                return e ? S.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !S(this).is(":disabled") && Lt.test(this.nodeName) && !Ot.test(e) && (this.checked || !ae.test(e))
            }).map(function (e, t) {
                var i = S(this).val();
                return null == i ? null : S.isArray(i) ? S.map(i, function (e) {
                    return {name: t.name, value: e.replace($t, "\r\n")}
                }) : {name: t.name, value: i.replace($t, "\r\n")}
            }).get()
        }
    }), S.ajaxSettings.xhr = function () {
        try {
            return new w.XMLHttpRequest
        } catch (e) {
        }
    };
    var Nt = {0: 200, 1223: 204}, j = S.ajaxSettings.xhr(),
        Dt = (v.cors = !!j && "withCredentials" in j, v.ajax = j = !!j, S.ajaxTransport(function (o) {
            var s, r;
            return v.cors || j && !o.crossDomain ? {
                send: function (e, t) {
                    var i, n = o.xhr();
                    if (n.open(o.type, o.url, o.async, o.username, o.password), o.xhrFields) for (i in o.xhrFields) n[i] = o.xhrFields[i];
                    for (i in o.mimeType && n.overrideMimeType && n.overrideMimeType(o.mimeType), o.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) n.setRequestHeader(i, e[i]);
                    s = function (e) {
                        return function () {
                            s && (s = r = n.onload = n.onerror = n.onabort = n.onreadystatechange = null, "abort" === e ? n.abort() : "error" === e ? "number" != typeof n.status ? t(0, "error") : t(n.status, n.statusText) : t(Nt[n.status] || n.status, n.statusText, "text" !== (n.responseType || "text") || "string" != typeof n.responseText ? {binary: n.response} : {text: n.responseText}, n.getAllResponseHeaders()))
                        }
                    }, n.onload = s(), r = n.onerror = s("error"), void 0 !== n.onabort ? n.onabort = r : n.onreadystatechange = function () {
                        4 === n.readyState && w.setTimeout(function () {
                            s && r()
                        })
                    }, s = s("abort");
                    try {
                        n.send(o.hasContent && o.data || null)
                    } catch (e) {
                        if (s) throw e
                    }
                }, abort: function () {
                    s && s()
                }
            } : void 0
        }), S.ajaxSetup({
            accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
            contents: {script: /\b(?:java|ecma)script\b/},
            converters: {
                "text script": function (e) {
                    return S.globalEval(e), e
                }
            }
        }), S.ajaxPrefilter("script", function (e) {
            void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
        }), S.ajaxTransport("script", function (i) {
            var n, o;
            if (i.crossDomain) return {
                send: function (e, t) {
                    n = S("<script>").prop({charset: i.scriptCharset, src: i.url}).on("load error", o = function (e) {
                        n.remove(), o = null, e && t("error" === e.type ? 404 : 200, e.type)
                    }), k.head.appendChild(n[0])
                }, abort: function () {
                    o && o()
                }
            }
        }), []), Mt = /(=)\?(?=&|$)|\?\?/, qt = (S.ajaxSetup({
            jsonp: "callback", jsonpCallback: function () {
                var e = Dt.pop() || S.expando + "_" + pt++;
                return this[e] = !0, e
            }
        }), S.ajaxPrefilter("json jsonp", function (e, t, i) {
            var n, o, s,
                r = !1 !== e.jsonp && (Mt.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Mt.test(e.data) && "data");
            return r || "jsonp" === e.dataTypes[0] ? (n = e.jsonpCallback = S.isFunction(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, r ? e[r] = e[r].replace(Mt, "$1" + n) : !1 !== e.jsonp && (e.url += (ht.test(e.url) ? "&" : "?") + e.jsonp + "=" + n), e.converters["script json"] = function () {
                return s || S.error(n + " was not called"), s[0]
            }, e.dataTypes[0] = "json", o = w[n], w[n] = function () {
                s = arguments
            }, i.always(function () {
                void 0 === o ? S(w).removeProp(n) : w[n] = o, e[n] && (e.jsonpCallback = t.jsonpCallback, Dt.push(n)), s && S.isFunction(o) && o(s[0]), s = o = void 0
            }), "script") : void 0
        }), S.parseHTML = function (e, t, i) {
            if (!e || "string" != typeof e) return null;
            "boolean" == typeof t && (i = t, t = !1), t = t || k;
            var n = U.exec(e), i = !i && [];
            return n ? [t.createElement(n[1])] : (n = he([e], t, i), i && i.length && S(i).remove(), S.merge([], n.childNodes))
        }, S.fn.load);

    function jt(e) {
        return S.isWindow(e) ? e : 9 === e.nodeType && e.defaultView
    }

    S.fn.load = function (e, t, i) {
        var n, o, s, r, l;
        return "string" != typeof e && qt ? qt.apply(this, arguments) : (r = this, -1 < (l = e.indexOf(" ")) && (n = S.trim(e.slice(l)), e = e.slice(0, l)), S.isFunction(t) ? (i = t, t = void 0) : t && "object" == typeof t && (o = "POST"), 0 < r.length && S.ajax({
            url: e,
            type: o || "GET",
            dataType: "html",
            data: t
        }).done(function (e) {
            s = arguments, r.html(n ? S("<div>").append(S.parseHTML(e)).find(n) : e)
        }).always(i && function (e, t) {
            r.each(function () {
                i.apply(this, s || [e.responseText, t, e])
            })
        }), this)
    }, S.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        S.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), S.expr.filters.animated = function (t) {
        return S.grep(S.timers, function (e) {
            return t === e.elem
        }).length
    }, S.offset = {
        setOffset: function (e, t, i) {
            var n, o, s, r, l = S.css(e, "position"), a = S(e), c = {};
            "static" === l && (e.style.position = "relative"), s = a.offset(), n = S.css(e, "top"), r = S.css(e, "left"), l = ("absolute" === l || "fixed" === l) && -1 < (n + r).indexOf("auto") ? (o = (l = a.position()).top, l.left) : (o = parseFloat(n) || 0, parseFloat(r) || 0), null != (t = S.isFunction(t) ? t.call(e, i, S.extend({}, s)) : t).top && (c.top = t.top - s.top + o), null != t.left && (c.left = t.left - s.left + l), "using" in t ? t.using.call(e, c) : a.css(c)
        }
    }, S.fn.extend({
        offset: function (t) {
            var e, i, n, o;
            return arguments.length ? void 0 === t ? this : this.each(function (e) {
                S.offset.setOffset(this, t, e)
            }) : (n = {
                top: 0,
                left: 0
            }, (o = (i = this[0]) && i.ownerDocument) ? (e = o.documentElement, S.contains(e, i) ? (n = i.getBoundingClientRect(), i = jt(o), {
                top: n.top + i.pageYOffset - e.clientTop,
                left: n.left + i.pageXOffset - e.clientLeft
            }) : n) : void 0)
        }, position: function () {
            var e, t, i, n;
            if (this[0]) return i = this[0], n = {
                top: 0,
                left: 0
            }, "fixed" === S.css(i, "position") ? t = i.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), (n = S.nodeName(e[0], "html") ? n : e.offset()).top += S.css(e[0], "borderTopWidth", !0), n.left += S.css(e[0], "borderLeftWidth", !0)), {
                top: t.top - n.top - S.css(i, "marginTop", !0),
                left: t.left - n.left - S.css(i, "marginLeft", !0)
            }
        }, offsetParent: function () {
            return this.map(function () {
                for (var e = this.offsetParent; e && "static" === S.css(e, "position");) e = e.offsetParent;
                return e || E
            })
        }
    }), S.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (t, o) {
        var s = "pageYOffset" === o;
        S.fn[t] = function (e) {
            return u(this, function (e, t, i) {
                var n = jt(e);
                return void 0 === i ? n ? n[o] : e[t] : void (n ? n.scrollTo(s ? n.pageXOffset : i, s ? i : n.pageYOffset) : e[t] = i)
            }, t, e, arguments.length)
        }
    }), S.each(["top", "left"], function (e, i) {
        S.cssHooks[i] = _e(v.pixelPosition, function (e, t) {
            return t ? (t = A(e, i), Re.test(t) ? S(e).position()[i] + "px" : t) : void 0
        })
    }), S.each({Height: "height", Width: "width"}, function (s, r) {
        S.each({padding: "inner" + s, content: r, "": "outer" + s}, function (n, e) {
            S.fn[e] = function (e, t) {
                var i = arguments.length && (n || "boolean" != typeof e),
                    o = n || (!0 === e || !0 === t ? "margin" : "border");
                return u(this, function (e, t, i) {
                    var n;
                    return S.isWindow(e) ? e.document.documentElement["client" + s] : 9 === e.nodeType ? (n = e.documentElement, Math.max(e.body["scroll" + s], n["scroll" + s], e.body["offset" + s], n["offset" + s], n["client" + s])) : void 0 === i ? S.css(e, t, o) : S.style(e, t, i, o)
                }, r, i ? e : void 0, i, null)
            }
        })
    }), S.fn.extend({
        bind: function (e, t, i) {
            return this.on(e, null, t, i)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, i, n) {
            return this.on(t, e, i, n)
        }, undelegate: function (e, t, i) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", i)
        }, size: function () {
            return this.length
        }
    }), S.fn.andSelf = S.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
        return S
    });
    var Ht = w.jQuery, Wt = w.$;
    return S.noConflict = function (e) {
        return w.$ === S && (w.$ = Wt), e && w.jQuery === S && (w.jQuery = Ht), S
    }, H || (w.jQuery = w.$ = S), S
}), !function (e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "undefined" != typeof exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (c) {
    "use strict";
    var n, r = window.Slick || {};
    n = 0, (r = function (e, t) {
        var i = this;
        i.defaults = {
            accessibility: !0,
            adaptiveHeight: !1,
            appendArrows: c(e),
            appendDots: c(e),
            arrows: !0,
            asNavFor: null,
            prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
            nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
            autoplay: !1,
            autoplaySpeed: 3e3,
            centerMode: !1,
            centerPadding: "50px",
            cssEase: "ease",
            customPaging: function (e, t) {
                return c('<button type="button" />').text(t + 1)
            },
            dots: !1,
            dotsClass: "slick-dots",
            draggable: !0,
            easing: "linear",
            edgeFriction: .35,
            fade: !1,
            focusOnSelect: !1,
            focusOnChange: !1,
            infinite: !0,
            initialSlide: 0,
            lazyLoad: "ondemand",
            mobileFirst: !1,
            pauseOnHover: !0,
            pauseOnFocus: !0,
            pauseOnDotsHover: !1,
            respondTo: "window",
            responsive: null,
            rows: 1,
            rtl: !1,
            slide: "",
            slidesPerRow: 1,
            slidesToShow: 1,
            slidesToScroll: 1,
            speed: 500,
            swipe: !0,
            swipeToSlide: !1,
            touchMove: !0,
            touchThreshold: 5,
            useCSS: !0,
            useTransform: !0,
            variableWidth: !1,
            vertical: !1,
            verticalSwiping: !1,
            waitForAnimate: !0,
            zIndex: 1e3
        }, i.initials = {
            animating: !1,
            dragging: !1,
            autoPlayTimer: null,
            currentDirection: 0,
            currentLeft: null,
            currentSlide: 0,
            direction: 1,
            $dots: null,
            listWidth: null,
            listHeight: null,
            loadIndex: 0,
            $nextArrow: null,
            $prevArrow: null,
            scrolling: !1,
            slideCount: null,
            slideWidth: null,
            $slideTrack: null,
            $slides: null,
            sliding: !1,
            slideOffset: 0,
            swipeLeft: null,
            swiping: !1,
            $list: null,
            touchObject: {},
            transformsEnabled: !1,
            unslicked: !1
        }, c.extend(i, i.initials), i.activeBreakpoint = null, i.animType = null, i.animProp = null, i.breakpoints = [], i.breakpointSettings = [], i.cssTransitions = !1, i.focussed = !1, i.interrupted = !1, i.hidden = "hidden", i.paused = !0, i.positionProp = null, i.respondTo = null, i.rowCount = 1, i.shouldClick = !0, i.$slider = c(e), i.$slidesCache = null, i.transformType = null, i.transitionType = null, i.visibilityChange = "visibilitychange", i.windowWidth = 0, i.windowTimer = null, e = c(e).data("slick") || {}, i.options = c.extend({}, i.defaults, t, e), i.currentSlide = i.options.initialSlide, i.originalSettings = i.options, void 0 !== document.mozHidden ? (i.hidden = "mozHidden", i.visibilityChange = "mozvisibilitychange") : void 0 !== document.webkitHidden && (i.hidden = "webkitHidden", i.visibilityChange = "webkitvisibilitychange"), i.autoPlay = c.proxy(i.autoPlay, i), i.autoPlayClear = c.proxy(i.autoPlayClear, i), i.autoPlayIterator = c.proxy(i.autoPlayIterator, i), i.changeSlide = c.proxy(i.changeSlide, i), i.clickHandler = c.proxy(i.clickHandler, i), i.selectHandler = c.proxy(i.selectHandler, i), i.setPosition = c.proxy(i.setPosition, i), i.swipeHandler = c.proxy(i.swipeHandler, i), i.dragHandler = c.proxy(i.dragHandler, i), i.keyHandler = c.proxy(i.keyHandler, i), i.instanceUid = n++, i.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, i.registerBreakpoints(), i.init(!0)
    }).prototype.activateADA = function () {
        this.$slideTrack.find(".slick-active").attr({"aria-hidden": "false"}).find("a, input, button, select").attr({tabindex: "0"})
    }, r.prototype.addSlide = r.prototype.slickAdd = function (e, t, i) {
        var n = this;
        if ("boolean" == typeof t) i = t, t = null; else if (t < 0 || t >= n.slideCount) return !1;
        n.unload(), "number" == typeof t ? 0 === t && 0 === n.$slides.length ? c(e).appendTo(n.$slideTrack) : i ? c(e).insertBefore(n.$slides.eq(t)) : c(e).insertAfter(n.$slides.eq(t)) : !0 === i ? c(e).prependTo(n.$slideTrack) : c(e).appendTo(n.$slideTrack), n.$slides = n.$slideTrack.children(this.options.slide), n.$slideTrack.children(this.options.slide).detach(), n.$slideTrack.append(n.$slides), n.$slides.each(function (e, t) {
            c(t).attr("data-slick-index", e)
        }), n.$slidesCache = n.$slides, n.reinit()
    }, r.prototype.animateHeight = function () {
        var e, t = this;
        1 === t.options.slidesToShow && !0 === t.options.adaptiveHeight && !1 === t.options.vertical && (e = t.$slides.eq(t.currentSlide).outerHeight(!0), t.$list.animate({height: e}, t.options.speed))
    }, r.prototype.animateSlide = function (e, t) {
        var i = {}, n = this;
        n.animateHeight(), !0 === n.options.rtl && !1 === n.options.vertical && (e = -e), !1 === n.transformsEnabled ? !1 === n.options.vertical ? n.$slideTrack.animate({left: e}, n.options.speed, n.options.easing, t) : n.$slideTrack.animate({top: e}, n.options.speed, n.options.easing, t) : !1 === n.cssTransitions ? (!0 === n.options.rtl && (n.currentLeft = -n.currentLeft), c({animStart: n.currentLeft}).animate({animStart: e}, {
            duration: n.options.speed,
            easing: n.options.easing,
            step: function (e) {
                e = Math.ceil(e), !1 === n.options.vertical ? i[n.animType] = "translate(" + e + "px, 0px)" : i[n.animType] = "translate(0px," + e + "px)", n.$slideTrack.css(i)
            },
            complete: function () {
                t && t.call()
            }
        })) : (n.applyTransition(), e = Math.ceil(e), !1 === n.options.vertical ? i[n.animType] = "translate3d(" + e + "px, 0px, 0px)" : i[n.animType] = "translate3d(0px," + e + "px, 0px)", n.$slideTrack.css(i), t && setTimeout(function () {
            n.disableTransition(), t.call()
        }, n.options.speed))
    }, r.prototype.getNavTarget = function () {
        var e = this.options.asNavFor;
        return e = e && null !== e ? c(e).not(this.$slider) : e
    }, r.prototype.asNavFor = function (t) {
        var e = this.getNavTarget();
        null !== e && "object" == typeof e && e.each(function () {
            var e = c(this).slick("getSlick");
            e.unslicked || e.slideHandler(t, !0)
        })
    }, r.prototype.applyTransition = function (e) {
        var t = this, i = {};
        !1 === t.options.fade ? i[t.transitionType] = t.transformType + " " + t.options.speed + "ms " + t.options.cssEase : i[t.transitionType] = "opacity " + t.options.speed + "ms " + t.options.cssEase, (!1 === t.options.fade ? t.$slideTrack : t.$slides.eq(e)).css(i)
    }, r.prototype.autoPlay = function () {
        var e = this;
        e.autoPlayClear(), e.slideCount > e.options.slidesToShow && (e.autoPlayTimer = setInterval(e.autoPlayIterator, e.options.autoplaySpeed))
    }, r.prototype.autoPlayClear = function () {
        this.autoPlayTimer && clearInterval(this.autoPlayTimer)
    }, r.prototype.autoPlayIterator = function () {
        var e = this, t = e.currentSlide + e.options.slidesToScroll;
        e.paused || e.interrupted || e.focussed || (!1 === e.options.infinite && (1 === e.direction && e.currentSlide + 1 === e.slideCount - 1 ? e.direction = 0 : 0 === e.direction && (t = e.currentSlide - e.options.slidesToScroll, e.currentSlide - 1 == 0) && (e.direction = 1)), e.slideHandler(t))
    }, r.prototype.buildArrows = function () {
        var e = this;
        !0 === e.options.arrows && (e.$prevArrow = c(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = c(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), !0 !== e.options.infinite && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({
            "aria-disabled": "true",
            tabindex: "-1"
        }))
    }, r.prototype.buildDots = function () {
        var e, t, i = this;
        if (!0 === i.options.dots) {
            for (i.$slider.addClass("slick-dotted"), t = c("<ul />").addClass(i.options.dotsClass), e = 0; e <= i.getDotCount(); e += 1) t.append(c("<li />").append(i.options.customPaging.call(this, i, e)));
            i.$dots = t.appendTo(i.options.appendDots), i.$dots.find("li").first().addClass("slick-active")
        }
    }, r.prototype.buildOut = function () {
        var e = this;
        e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function (e, t) {
            c(t).attr("data-slick-index", e).data("originalStyling", c(t).attr("style") || "")
        }), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? c('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), !0 !== e.options.centerMode && !0 !== e.options.swipeToSlide || (e.options.slidesToScroll = 1), c("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), !0 === e.options.draggable && e.$list.addClass("draggable")
    }, r.prototype.buildRows = function () {
        var e, t, i, n = this, o = document.createDocumentFragment(), s = n.$slider.children();
        if (1 < n.options.rows) {
            for (i = n.options.slidesPerRow * n.options.rows, t = Math.ceil(s.length / i), e = 0; e < t; e++) {
                for (var r = document.createElement("div"), l = 0; l < n.options.rows; l++) {
                    for (var a = document.createElement("div"), c = 0; c < n.options.slidesPerRow; c++) {
                        var d = e * i + (l * n.options.slidesPerRow + c);
                        s.get(d) && a.appendChild(s.get(d))
                    }
                    r.appendChild(a)
                }
                o.appendChild(r)
            }
            n.$slider.empty().append(o), n.$slider.children().children().children().css({
                width: 100 / n.options.slidesPerRow + "%",
                display: "inline-block"
            })
        }
    }, r.prototype.checkResponsive = function (e, t) {
        var i, n, o, s = this, r = !1, l = s.$slider.width(), a = window.innerWidth || c(window).width();
        if ("window" === s.respondTo ? o = a : "slider" === s.respondTo ? o = l : "min" === s.respondTo && (o = Math.min(a, l)), s.options.responsive && s.options.responsive.length && null !== s.options.responsive) {
            for (i in n = null, s.breakpoints) s.breakpoints.hasOwnProperty(i) && (!1 === s.originalSettings.mobileFirst ? o < s.breakpoints[i] && (n = s.breakpoints[i]) : o > s.breakpoints[i] && (n = s.breakpoints[i]));
            null !== n ? null !== s.activeBreakpoint && n === s.activeBreakpoint && !t || (s.activeBreakpoint = n, "unslick" === s.breakpointSettings[n] ? s.unslick(n) : (s.options = c.extend({}, s.originalSettings, s.breakpointSettings[n]), !0 === e && (s.currentSlide = s.options.initialSlide), s.refresh(e)), r = n) : null !== s.activeBreakpoint && (s.activeBreakpoint = null, s.options = s.originalSettings, !0 === e && (s.currentSlide = s.options.initialSlide), s.refresh(e), r = n), e || !1 === r || s.$slider.trigger("breakpoint", [s, r])
        }
    }, r.prototype.changeSlide = function (e, t) {
        var i, n = this, o = c(e.currentTarget);
        switch (o.is("a") && e.preventDefault(), o.is("li") || (o = o.closest("li")), i = n.slideCount % n.options.slidesToScroll != 0 ? 0 : (n.slideCount - n.currentSlide) % n.options.slidesToScroll, e.data.message) {
            case"previous":
                s = 0 == i ? n.options.slidesToScroll : n.options.slidesToShow - i, n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide - s, !1, t);
                break;
            case"next":
                s = 0 == i ? n.options.slidesToScroll : i, n.slideCount > n.options.slidesToShow && n.slideHandler(n.currentSlide + s, !1, t);
                break;
            case"index":
                var s = 0 === e.data.index ? 0 : e.data.index || o.index() * n.options.slidesToScroll;
                n.slideHandler(n.checkNavigable(s), !1, t), o.children().trigger("focus");
                break;
            default:
                return
        }
    }, r.prototype.checkNavigable = function (e) {
        var t = this.getNavigableIndexes(), i = 0;
        if (e > t[t.length - 1]) e = t[t.length - 1]; else for (var n in t) {
            if (e < t[n]) {
                e = i;
                break
            }
            i = t[n]
        }
        return e
    }, r.prototype.cleanUpEvents = function () {
        var e = this;
        e.options.dots && null !== e.$dots && (c("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", c.proxy(e.interrupt, e, !0)).off("mouseleave.slick", c.proxy(e.interrupt, e, !1)), !0 === e.options.accessibility) && e.$dots.off("keydown.slick", e.keyHandler), e.$slider.off("focus.slick blur.slick"), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide), !0 === e.options.accessibility) && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow) && e.$nextArrow.off("keydown.slick", e.keyHandler), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), c(document).off(e.visibilityChange, e.visibility), e.cleanUpSlideEvents(), !0 === e.options.accessibility && e.$list.off("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && c(e.$slideTrack).children().off("click.slick", e.selectHandler), c(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), c(window).off("resize.slick.slick-" + e.instanceUid, e.resize), c("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), c(window).off("load.slick.slick-" + e.instanceUid, e.setPosition)
    }, r.prototype.cleanUpSlideEvents = function () {
        var e = this;
        e.$list.off("mouseenter.slick", c.proxy(e.interrupt, e, !0)), e.$list.off("mouseleave.slick", c.proxy(e.interrupt, e, !1))
    }, r.prototype.cleanUpRows = function () {
        var e;
        1 < this.options.rows && ((e = this.$slides.children().children()).removeAttr("style"), this.$slider.empty().append(e))
    }, r.prototype.clickHandler = function (e) {
        !1 === this.shouldClick && (e.stopImmediatePropagation(), e.stopPropagation(), e.preventDefault())
    }, r.prototype.destroy = function (e) {
        var t = this;
        t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), c(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow)) && t.$prevArrow.remove(), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow)) && t.$nextArrow.remove(), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
            c(this).attr("style", c(this).data("originalStyling"))
        }), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.$slider.removeClass("slick-dotted"), t.unslicked = !0, e || t.$slider.trigger("destroy", [t])
    }, r.prototype.disableTransition = function (e) {
        var t = {};
        t[this.transitionType] = "", (!1 === this.options.fade ? this.$slideTrack : this.$slides.eq(e)).css(t)
    }, r.prototype.fadeSlide = function (e, t) {
        var i = this;
        !1 === i.cssTransitions ? (i.$slides.eq(e).css({zIndex: i.options.zIndex}), i.$slides.eq(e).animate({opacity: 1}, i.options.speed, i.options.easing, t)) : (i.applyTransition(e), i.$slides.eq(e).css({
            opacity: 1,
            zIndex: i.options.zIndex
        }), t && setTimeout(function () {
            i.disableTransition(e), t.call()
        }, i.options.speed))
    }, r.prototype.fadeSlideOut = function (e) {
        var t = this;
        !1 === t.cssTransitions ? t.$slides.eq(e).animate({
            opacity: 0,
            zIndex: t.options.zIndex - 2
        }, t.options.speed, t.options.easing) : (t.applyTransition(e), t.$slides.eq(e).css({
            opacity: 0,
            zIndex: t.options.zIndex - 2
        }))
    }, r.prototype.filterSlides = r.prototype.slickFilter = function (e) {
        var t = this;
        null !== e && (t.$slidesCache = t.$slides, t.unload(), t.$slideTrack.children(this.options.slide).detach(), t.$slidesCache.filter(e).appendTo(t.$slideTrack), t.reinit())
    }, r.prototype.focusHandler = function () {
        var i = this;
        i.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*", function (e) {
            e.stopImmediatePropagation();
            var t = c(this);
            setTimeout(function () {
                i.options.pauseOnFocus && (i.focussed = t.is(":focus"), i.autoPlay())
            }, 0)
        })
    }, r.prototype.getCurrent = r.prototype.slickCurrentSlide = function () {
        return this.currentSlide
    }, r.prototype.getDotCount = function () {
        var e = this, t = 0, i = 0, n = 0;
        if (!0 === e.options.infinite) if (e.slideCount <= e.options.slidesToShow) ++n; else for (; t < e.slideCount;) ++n, t = i + e.options.slidesToScroll, i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; else if (!0 === e.options.centerMode) n = e.slideCount; else if (e.options.asNavFor) for (; t < e.slideCount;) ++n, t = i + e.options.slidesToScroll, i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow; else n = 1 + Math.ceil((e.slideCount - e.options.slidesToShow) / e.options.slidesToScroll);
        return n - 1
    }, r.prototype.getLeft = function (e) {
        var t, i, n = this, o = 0;
        return n.slideOffset = 0, t = n.$slides.first().outerHeight(!0), !0 === n.options.infinite ? (n.slideCount > n.options.slidesToShow && (n.slideOffset = n.slideWidth * n.options.slidesToShow * -1, i = -1, !0 === n.options.vertical && !0 === n.options.centerMode && (2 === n.options.slidesToShow ? i = -1.5 : 1 === n.options.slidesToShow && (i = -2)), o = t * n.options.slidesToShow * i), n.slideCount % n.options.slidesToScroll != 0 && e + n.options.slidesToScroll > n.slideCount && n.slideCount > n.options.slidesToShow && (o = e > n.slideCount ? (n.slideOffset = (n.options.slidesToShow - (e - n.slideCount)) * n.slideWidth * -1, (n.options.slidesToShow - (e - n.slideCount)) * t * -1) : (n.slideOffset = n.slideCount % n.options.slidesToScroll * n.slideWidth * -1, n.slideCount % n.options.slidesToScroll * t * -1))) : e + n.options.slidesToShow > n.slideCount && (n.slideOffset = (e + n.options.slidesToShow - n.slideCount) * n.slideWidth, o = (e + n.options.slidesToShow - n.slideCount) * t), n.slideCount <= n.options.slidesToShow && (o = n.slideOffset = 0), !0 === n.options.centerMode && n.slideCount <= n.options.slidesToShow ? n.slideOffset = n.slideWidth * Math.floor(n.options.slidesToShow) / 2 - n.slideWidth * n.slideCount / 2 : !0 === n.options.centerMode && !0 === n.options.infinite ? n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2) - n.slideWidth : !0 === n.options.centerMode && (n.slideOffset = 0, n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2)), i = !1 === n.options.vertical ? e * n.slideWidth * -1 + n.slideOffset : e * t * -1 + o, !0 === n.options.variableWidth && (t = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(e) : n.$slideTrack.children(".slick-slide").eq(e + n.options.slidesToShow), i = !0 === n.options.rtl ? t[0] ? -1 * (n.$slideTrack.width() - t[0].offsetLeft - t.width()) : 0 : t[0] ? -1 * t[0].offsetLeft : 0, !0 === n.options.centerMode) && (t = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(e) : n.$slideTrack.children(".slick-slide").eq(e + n.options.slidesToShow + 1), i = !0 === n.options.rtl ? t[0] ? -1 * (n.$slideTrack.width() - t[0].offsetLeft - t.width()) : 0 : t[0] ? -1 * t[0].offsetLeft : 0, i += (n.$list.width() - t.outerWidth()) / 2), i
    }, r.prototype.getOption = r.prototype.slickGetOption = function (e) {
        return this.options[e]
    }, r.prototype.getNavigableIndexes = function () {
        for (var e = this, t = 0, i = 0, n = [], o = !1 === e.options.infinite ? e.slideCount : (t = -1 * e.options.slidesToScroll, i = -1 * e.options.slidesToScroll, 2 * e.slideCount); t < o;) n.push(t), t = i + e.options.slidesToScroll, i += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
        return n
    }, r.prototype.getSlick = function () {
        return this
    }, r.prototype.getSlideCount = function () {
        var i, n = this, o = !0 === n.options.centerMode ? n.slideWidth * Math.floor(n.options.slidesToShow / 2) : 0;
        return !0 === n.options.swipeToSlide ? (n.$slideTrack.find(".slick-slide").each(function (e, t) {
            if (t.offsetLeft - o + c(t).outerWidth() / 2 > -1 * n.swipeLeft) return i = t, !1
        }), Math.abs(c(i).attr("data-slick-index") - n.currentSlide) || 1) : n.options.slidesToScroll
    }, r.prototype.goTo = r.prototype.slickGoTo = function (e, t) {
        this.changeSlide({data: {message: "index", index: parseInt(e)}}, t)
    }, r.prototype.init = function (e) {
        var t = this;
        c(t.$slider).hasClass("slick-initialized") || (c(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots(), t.checkResponsive(!0), t.focusHandler()), e && t.$slider.trigger("init", [t]), !0 === t.options.accessibility && t.initADA(), t.options.autoplay && (t.paused = !1, t.autoPlay())
    }, r.prototype.initADA = function () {
        var i = this, n = Math.ceil(i.slideCount / i.options.slidesToShow),
            o = i.getNavigableIndexes().filter(function (e) {
                return 0 <= e && e < i.slideCount
            });
        i.$slides.add(i.$slideTrack.find(".slick-cloned")).attr({
            "aria-hidden": "true",
            tabindex: "-1"
        }).find("a, input, button, select").attr({tabindex: "-1"}), null !== i.$dots && (i.$slides.not(i.$slideTrack.find(".slick-cloned")).each(function (e) {
            var t = o.indexOf(e);
            c(this).attr({
                role: "tabpanel",
                id: "slick-slide" + i.instanceUid + e,
                tabindex: -1
            }), -1 !== t && c(this).attr({"aria-describedby": "slick-slide-control" + i.instanceUid + t})
        }), i.$dots.attr("role", "tablist").find("li").each(function (e) {
            var t = o[e];
            c(this).attr({role: "presentation"}), c(this).find("button").first().attr({
                role: "tab",
                id: "slick-slide-control" + i.instanceUid + e,
                "aria-controls": "slick-slide" + i.instanceUid + t,
                "aria-label": e + 1 + " of " + n,
                "aria-selected": null,
                tabindex: "-1"
            })
        }).eq(i.currentSlide).find("button").attr({"aria-selected": "true", tabindex: "0"}).end());
        for (var e = i.currentSlide, t = e + i.options.slidesToShow; e < t; e++) i.$slides.eq(e).attr("tabindex", 0);
        i.activateADA()
    }, r.prototype.initArrowEvents = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.off("click.slick").on("click.slick", {message: "previous"}, e.changeSlide), e.$nextArrow.off("click.slick").on("click.slick", {message: "next"}, e.changeSlide), !0 === e.options.accessibility) && (e.$prevArrow.on("keydown.slick", e.keyHandler), e.$nextArrow.on("keydown.slick", e.keyHandler))
    }, r.prototype.initDotEvents = function () {
        var e = this;
        !0 === e.options.dots && (c("li", e.$dots).on("click.slick", {message: "index"}, e.changeSlide), !0 === e.options.accessibility) && e.$dots.on("keydown.slick", e.keyHandler), !0 === e.options.dots && !0 === e.options.pauseOnDotsHover && c("li", e.$dots).on("mouseenter.slick", c.proxy(e.interrupt, e, !0)).on("mouseleave.slick", c.proxy(e.interrupt, e, !1))
    }, r.prototype.initSlideEvents = function () {
        var e = this;
        e.options.pauseOnHover && (e.$list.on("mouseenter.slick", c.proxy(e.interrupt, e, !0)), e.$list.on("mouseleave.slick", c.proxy(e.interrupt, e, !1)))
    }, r.prototype.initializeEvents = function () {
        var e = this;
        e.initArrowEvents(), e.initDotEvents(), e.initSlideEvents(), e.$list.on("touchstart.slick mousedown.slick", {action: "start"}, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", {action: "move"}, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", {action: "end"}, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", {action: "end"}, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), c(document).on(e.visibilityChange, c.proxy(e.visibility, e)), !0 === e.options.accessibility && e.$list.on("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && c(e.$slideTrack).children().on("click.slick", e.selectHandler), c(window).on("orientationchange.slick.slick-" + e.instanceUid, c.proxy(e.orientationChange, e)), c(window).on("resize.slick.slick-" + e.instanceUid, c.proxy(e.resize, e)), c("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), c(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), c(e.setPosition)
    }, r.prototype.initUI = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.show(), e.$nextArrow.show()), !0 === e.options.dots && e.slideCount > e.options.slidesToShow && e.$dots.show()
    }, r.prototype.keyHandler = function (e) {
        var t = this;
        e.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === e.keyCode && !0 === t.options.accessibility ? t.changeSlide({data: {message: !0 === t.options.rtl ? "next" : "previous"}}) : 39 === e.keyCode && !0 === t.options.accessibility && t.changeSlide({data: {message: !0 === t.options.rtl ? "previous" : "next"}}))
    }, r.prototype.lazyLoad = function () {
        function e(e) {
            c("img[data-lazy]", e).each(function () {
                var e = c(this), t = c(this).attr("data-lazy"), i = c(this).attr("data-srcset"),
                    n = c(this).attr("data-sizes") || s.$slider.attr("data-sizes"), o = document.createElement("img");
                o.onload = function () {
                    e.animate({opacity: 0}, 100, function () {
                        i && (e.attr("srcset", i), n) && e.attr("sizes", n), e.attr("src", t).animate({opacity: 1}, 200, function () {
                            e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading")
                        }), s.$slider.trigger("lazyLoaded", [s, e, t])
                    })
                }, o.onerror = function () {
                    e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), s.$slider.trigger("lazyLoadError", [s, e, t])
                }, o.src = t
            })
        }

        var t, i, n, s = this;
        if (!0 === s.options.centerMode ? n = !0 === s.options.infinite ? (i = s.currentSlide + (s.options.slidesToShow / 2 + 1)) + s.options.slidesToShow + 2 : (i = Math.max(0, s.currentSlide - (s.options.slidesToShow / 2 + 1)), s.options.slidesToShow / 2 + 1 + 2 + s.currentSlide) : (i = s.options.infinite ? s.options.slidesToShow + s.currentSlide : s.currentSlide, n = Math.ceil(i + s.options.slidesToShow), !0 === s.options.fade && (0 < i && i--, n <= s.slideCount) && n++), t = s.$slider.find(".slick-slide").slice(i, n), "anticipated" === s.options.lazyLoad) for (var o = i - 1, r = n, l = s.$slider.find(".slick-slide"), a = 0; a < s.options.slidesToScroll; a++) o < 0 && (o = s.slideCount - 1), t = (t = t.add(l.eq(o))).add(l.eq(r)), o--, r++;
        e(t), s.slideCount <= s.options.slidesToShow ? e(s.$slider.find(".slick-slide")) : s.currentSlide >= s.slideCount - s.options.slidesToShow ? e(s.$slider.find(".slick-cloned").slice(0, s.options.slidesToShow)) : 0 === s.currentSlide && e(s.$slider.find(".slick-cloned").slice(-1 * s.options.slidesToShow))
    }, r.prototype.loadSlider = function () {
        var e = this;
        e.setPosition(), e.$slideTrack.css({opacity: 1}), e.$slider.removeClass("slick-loading"), e.initUI(), "progressive" === e.options.lazyLoad && e.progressiveLazyLoad()
    }, r.prototype.next = r.prototype.slickNext = function () {
        this.changeSlide({data: {message: "next"}})
    }, r.prototype.orientationChange = function () {
        this.checkResponsive(), this.setPosition()
    }, r.prototype.pause = r.prototype.slickPause = function () {
        this.autoPlayClear(), this.paused = !0
    }, r.prototype.play = r.prototype.slickPlay = function () {
        var e = this;
        e.autoPlay(), e.options.autoplay = !0, e.paused = !1, e.focussed = !1, e.interrupted = !1
    }, r.prototype.postSlide = function (e) {
        var t = this;
        t.unslicked || (t.$slider.trigger("afterChange", [t, e]), t.animating = !1, t.slideCount > t.options.slidesToShow && t.setPosition(), t.swipeLeft = null, t.options.autoplay && t.autoPlay(), !0 === t.options.accessibility && (t.initADA(), t.options.focusOnChange) && c(t.$slides.get(t.currentSlide)).attr("tabindex", 0).focus())
    }, r.prototype.prev = r.prototype.slickPrev = function () {
        this.changeSlide({data: {message: "previous"}})
    }, r.prototype.preventDefault = function (e) {
        e.preventDefault()
    }, r.prototype.progressiveLazyLoad = function (e) {
        e = e || 1;
        var t, i, n, o, s = this, r = c("img[data-lazy]", s.$slider);
        r.length ? (t = r.first(), i = t.attr("data-lazy"), n = t.attr("data-srcset"), o = t.attr("data-sizes") || s.$slider.attr("data-sizes"), (r = document.createElement("img")).onload = function () {
            n && (t.attr("srcset", n), o) && t.attr("sizes", o), t.attr("src", i).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), !0 === s.options.adaptiveHeight && s.setPosition(), s.$slider.trigger("lazyLoaded", [s, t, i]), s.progressiveLazyLoad()
        }, r.onerror = function () {
            e < 3 ? setTimeout(function () {
                s.progressiveLazyLoad(e + 1)
            }, 500) : (t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), s.$slider.trigger("lazyLoadError", [s, t, i]), s.progressiveLazyLoad())
        }, r.src = i) : s.$slider.trigger("allImagesLoaded", [s])
    }, r.prototype.refresh = function (e) {
        var t = this, i = t.slideCount - t.options.slidesToShow;
        !t.options.infinite && t.currentSlide > i && (t.currentSlide = i), t.slideCount <= t.options.slidesToShow && (t.currentSlide = 0), i = t.currentSlide, t.destroy(!0), c.extend(t, t.initials, {currentSlide: i}), t.init(), e || t.changeSlide({
            data: {
                message: "index",
                index: i
            }
        }, !1)
    }, r.prototype.registerBreakpoints = function () {
        var e, t, i, n = this, o = n.options.responsive || null;
        if ("array" === c.type(o) && o.length) {
            for (e in n.respondTo = n.options.respondTo || "window", o) if (i = n.breakpoints.length - 1, o.hasOwnProperty(e)) {
                for (t = o[e].breakpoint; 0 <= i;) n.breakpoints[i] && n.breakpoints[i] === t && n.breakpoints.splice(i, 1), i--;
                n.breakpoints.push(t), n.breakpointSettings[t] = o[e].settings
            }
            n.breakpoints.sort(function (e, t) {
                return n.options.mobileFirst ? e - t : t - e
            })
        }
    }, r.prototype.reinit = function () {
        var e = this;
        e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.cleanUpSlideEvents(), e.initSlideEvents(), e.checkResponsive(!1, !0), !0 === e.options.focusOnSelect && c(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.setPosition(), e.focusHandler(), e.paused = !e.options.autoplay, e.autoPlay(), e.$slider.trigger("reInit", [e])
    }, r.prototype.resize = function () {
        var e = this;
        c(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function () {
            e.windowWidth = c(window).width(), e.checkResponsive(), e.unslicked || e.setPosition()
        }, 50))
    }, r.prototype.removeSlide = r.prototype.slickRemove = function (e, t, i) {
        var n = this;
        if (e = "boolean" == typeof e ? !0 === (t = e) ? 0 : n.slideCount - 1 : !0 === t ? --e : e, n.slideCount < 1 || e < 0 || e > n.slideCount - 1) return !1;
        n.unload(), (!0 === i ? n.$slideTrack.children() : n.$slideTrack.children(this.options.slide).eq(e)).remove(), n.$slides = n.$slideTrack.children(this.options.slide), n.$slideTrack.children(this.options.slide).detach(), n.$slideTrack.append(n.$slides), n.$slidesCache = n.$slides, n.reinit()
    }, r.prototype.setCSS = function (e) {
        var t, i, n = this, o = {};
        !0 === n.options.rtl && (e = -e), t = "left" == n.positionProp ? Math.ceil(e) + "px" : "0px", i = "top" == n.positionProp ? Math.ceil(e) + "px" : "0px", o[n.positionProp] = e, !1 !== n.transformsEnabled && (!(o = {}) === n.cssTransitions ? o[n.animType] = "translate(" + t + ", " + i + ")" : o[n.animType] = "translate3d(" + t + ", " + i + ", 0px)"), n.$slideTrack.css(o)
    }, r.prototype.setDimensions = function () {
        var e = this,
            t = (!1 === e.options.vertical ? !0 === e.options.centerMode && e.$list.css({padding: "0px " + e.options.centerPadding}) : (e.$list.height(e.$slides.first().outerHeight(!0) * e.options.slidesToShow), !0 === e.options.centerMode && e.$list.css({padding: e.options.centerPadding + " 0px"})), e.listWidth = e.$list.width(), e.listHeight = e.$list.height(), !1 === e.options.vertical && !1 === e.options.variableWidth ? (e.slideWidth = Math.ceil(e.listWidth / e.options.slidesToShow), e.$slideTrack.width(Math.ceil(e.slideWidth * e.$slideTrack.children(".slick-slide").length))) : !0 === e.options.variableWidth ? e.$slideTrack.width(5e3 * e.slideCount) : (e.slideWidth = Math.ceil(e.listWidth), e.$slideTrack.height(Math.ceil(e.$slides.first().outerHeight(!0) * e.$slideTrack.children(".slick-slide").length))), e.$slides.first().outerWidth(!0) - e.$slides.first().width());
        !1 === e.options.variableWidth && e.$slideTrack.children(".slick-slide").width(e.slideWidth - t)
    }, r.prototype.setFade = function () {
        var i, n = this;
        n.$slides.each(function (e, t) {
            i = n.slideWidth * e * -1, !0 === n.options.rtl ? c(t).css({
                position: "relative",
                right: i,
                top: 0,
                zIndex: n.options.zIndex - 2,
                opacity: 0
            }) : c(t).css({position: "relative", left: i, top: 0, zIndex: n.options.zIndex - 2, opacity: 0})
        }), n.$slides.eq(n.currentSlide).css({zIndex: n.options.zIndex - 1, opacity: 1})
    }, r.prototype.setHeight = function () {
        var e, t = this;
        1 === t.options.slidesToShow && !0 === t.options.adaptiveHeight && !1 === t.options.vertical && (e = t.$slides.eq(t.currentSlide).outerHeight(!0), t.$list.css("height", e))
    }, r.prototype.setOption = r.prototype.slickSetOption = function () {
        var e, t, i, n, o, s = this, r = !1;
        if ("object" === c.type(arguments[0]) ? (i = arguments[0], r = arguments[1], o = "multiple") : "string" === c.type(arguments[0]) && (i = arguments[0], n = arguments[1], r = arguments[2], "responsive" === arguments[0] && "array" === c.type(arguments[1]) ? o = "responsive" : void 0 !== arguments[1] && (o = "single")), "single" === o) s.options[i] = n; else if ("multiple" === o) c.each(i, function (e, t) {
            s.options[e] = t
        }); else if ("responsive" === o) for (t in n) if ("array" !== c.type(s.options.responsive)) s.options.responsive = [n[t]]; else {
            for (e = s.options.responsive.length - 1; 0 <= e;) s.options.responsive[e].breakpoint === n[t].breakpoint && s.options.responsive.splice(e, 1), e--;
            s.options.responsive.push(n[t])
        }
        r && (s.unload(), s.reinit())
    }, r.prototype.setPosition = function () {
        var e = this;
        e.setDimensions(), e.setHeight(), !1 === e.options.fade ? e.setCSS(e.getLeft(e.currentSlide)) : e.setFade(), e.$slider.trigger("setPosition", [e])
    }, r.prototype.setProps = function () {
        var e = this, t = document.body.style;
        e.positionProp = !0 === e.options.vertical ? "top" : "left", "top" === e.positionProp ? e.$slider.addClass("slick-vertical") : e.$slider.removeClass("slick-vertical"), void 0 === t.WebkitTransition && void 0 === t.MozTransition && void 0 === t.msTransition || !0 === e.options.useCSS && (e.cssTransitions = !0), e.options.fade && ("number" == typeof e.options.zIndex ? e.options.zIndex < 3 && (e.options.zIndex = 3) : e.options.zIndex = e.defaults.zIndex), void 0 !== t.OTransform && (e.animType = "OTransform", e.transformType = "-o-transform", e.transitionType = "OTransition", void 0 === t.perspectiveProperty) && void 0 === t.webkitPerspective && (e.animType = !1), void 0 !== t.MozTransform && (e.animType = "MozTransform", e.transformType = "-moz-transform", e.transitionType = "MozTransition", void 0 === t.perspectiveProperty) && void 0 === t.MozPerspective && (e.animType = !1), void 0 !== t.webkitTransform && (e.animType = "webkitTransform", e.transformType = "-webkit-transform", e.transitionType = "webkitTransition", void 0 === t.perspectiveProperty) && void 0 === t.webkitPerspective && (e.animType = !1), void 0 !== t.msTransform && (e.animType = "msTransform", e.transformType = "-ms-transform", e.transitionType = "msTransition", void 0 === t.msTransform) && (e.animType = !1), void 0 !== t.transform && !1 !== e.animType && (e.animType = "transform", e.transformType = "transform", e.transitionType = "transition"), e.transformsEnabled = e.options.useTransform && null !== e.animType && !1 !== e.animType
    }, r.prototype.setSlideClasses = function (e) {
        var t, i, n, o = this,
            s = o.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true");
        o.$slides.eq(e).addClass("slick-current"), !0 === o.options.centerMode ? (i = o.options.slidesToShow % 2 == 0 ? 1 : 0, n = Math.floor(o.options.slidesToShow / 2), !0 === o.options.infinite && ((n <= e && e <= o.slideCount - 1 - n ? o.$slides.slice(e - n + i, e + n + 1) : (t = o.options.slidesToShow + e, s.slice(t - n + 1 + i, t + n + 2))).addClass("slick-active").attr("aria-hidden", "false"), 0 === e ? s.eq(s.length - 1 - o.options.slidesToShow).addClass("slick-center") : e === o.slideCount - 1 && s.eq(o.options.slidesToShow).addClass("slick-center")), o.$slides.eq(e).addClass("slick-center")) : (0 <= e && e <= o.slideCount - o.options.slidesToShow ? o.$slides.slice(e, e + o.options.slidesToShow) : s.length <= o.options.slidesToShow ? s : (i = o.slideCount % o.options.slidesToShow, t = !0 === o.options.infinite ? o.options.slidesToShow + e : e, o.options.slidesToShow == o.options.slidesToScroll && o.slideCount - e < o.options.slidesToShow ? s.slice(t - (o.options.slidesToShow - i), t + i) : s.slice(t, t + o.options.slidesToShow))).addClass("slick-active").attr("aria-hidden", "false"), "ondemand" !== o.options.lazyLoad && "anticipated" !== o.options.lazyLoad || o.lazyLoad()
    }, r.prototype.setupInfinite = function () {
        var e, t, i, n = this;
        if (!0 === n.options.fade && (n.options.centerMode = !1), !0 === n.options.infinite && !1 === n.options.fade && (t = null, n.slideCount > n.options.slidesToShow)) {
            for (i = !0 === n.options.centerMode ? n.options.slidesToShow + 1 : n.options.slidesToShow, e = n.slideCount; e > n.slideCount - i; --e) c(n.$slides[t = e - 1]).clone(!0).attr("id", "").attr("data-slick-index", t - n.slideCount).prependTo(n.$slideTrack).addClass("slick-cloned");
            for (e = 0; e < i + n.slideCount; e += 1) t = e, c(n.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + n.slideCount).appendTo(n.$slideTrack).addClass("slick-cloned");
            n.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
                c(this).attr("id", "")
            })
        }
    }, r.prototype.interrupt = function (e) {
        e || this.autoPlay(), this.interrupted = e
    }, r.prototype.selectHandler = function (e) {
        e = c(e.target).is(".slick-slide") ? c(e.target) : c(e.target).parents(".slick-slide"), e = (e = parseInt(e.attr("data-slick-index"))) || 0;
        this.slideCount <= this.options.slidesToShow ? this.slideHandler(e, !1, !0) : this.slideHandler(e)
    }, r.prototype.slideHandler = function (e, t, i) {
        var n, o, s, r = this;
        t = t || !1, !0 === r.animating && !0 === r.options.waitForAnimate || !0 === r.options.fade && r.currentSlide === e || (!1 === t && r.asNavFor(e), n = e, t = r.getLeft(n), s = r.getLeft(r.currentSlide), r.currentLeft = null === r.swipeLeft ? s : r.swipeLeft, !1 === r.options.infinite && !1 === r.options.centerMode && (e < 0 || e > r.getDotCount() * r.options.slidesToScroll) || !1 === r.options.infinite && !0 === r.options.centerMode && (e < 0 || e > r.slideCount - r.options.slidesToScroll) ? !1 === r.options.fade && (n = r.currentSlide, !0 !== i ? r.animateSlide(s, function () {
            r.postSlide(n)
        }) : r.postSlide(n)) : (r.options.autoplay && clearInterval(r.autoPlayTimer), o = n < 0 ? r.slideCount % r.options.slidesToScroll != 0 ? r.slideCount - r.slideCount % r.options.slidesToScroll : r.slideCount + n : n >= r.slideCount ? r.slideCount % r.options.slidesToScroll != 0 ? 0 : n - r.slideCount : n, r.animating = !0, r.$slider.trigger("beforeChange", [r, r.currentSlide, o]), e = r.currentSlide, r.currentSlide = o, r.setSlideClasses(r.currentSlide), r.options.asNavFor && (s = (s = r.getNavTarget()).slick("getSlick")).slideCount <= s.options.slidesToShow && s.setSlideClasses(r.currentSlide), r.updateDots(), r.updateArrows(), !0 === r.options.fade ? (!0 !== i ? (r.fadeSlideOut(e), r.fadeSlide(o, function () {
            r.postSlide(o)
        })) : r.postSlide(o), r.animateHeight()) : !0 !== i ? r.animateSlide(t, function () {
            r.postSlide(o)
        }) : r.postSlide(o)))
    }, r.prototype.startLoad = function () {
        var e = this;
        !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow.hide(), e.$nextArrow.hide()), !0 === e.options.dots && e.slideCount > e.options.slidesToShow && e.$dots.hide(), e.$slider.addClass("slick-loading")
    }, r.prototype.swipeDirection = function () {
        var e = this, t = e.touchObject.startX - e.touchObject.curX, i = e.touchObject.startY - e.touchObject.curY,
            i = Math.atan2(i, t);
        return (t = (t = Math.round(180 * i / Math.PI)) < 0 ? 360 - Math.abs(t) : t) <= 45 && 0 <= t || t <= 360 && 315 <= t ? !1 === e.options.rtl ? "left" : "right" : 135 <= t && t <= 225 ? !1 === e.options.rtl ? "right" : "left" : !0 === e.options.verticalSwiping ? 35 <= t && t <= 135 ? "down" : "up" : "vertical"
    }, r.prototype.swipeEnd = function (e) {
        var t, i, n = this;
        if (n.dragging = !1, n.swiping = !1, n.scrolling) return n.scrolling = !1;
        if (n.interrupted = !1, n.shouldClick = !(10 < n.touchObject.swipeLength), void 0 === n.touchObject.curX) return !1;
        if (!0 === n.touchObject.edgeHit && n.$slider.trigger("edge", [n, n.swipeDirection()]), n.touchObject.swipeLength >= n.touchObject.minSwipe) {
            switch (i = n.swipeDirection()) {
                case"left":
                case"down":
                    t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide + n.getSlideCount()) : n.currentSlide + n.getSlideCount(), n.currentDirection = 0;
                    break;
                case"right":
                case"up":
                    t = n.options.swipeToSlide ? n.checkNavigable(n.currentSlide - n.getSlideCount()) : n.currentSlide - n.getSlideCount(), n.currentDirection = 1
            }
            "vertical" != i && (n.slideHandler(t), n.touchObject = {}, n.$slider.trigger("swipe", [n, i]))
        } else n.touchObject.startX !== n.touchObject.curX && (n.slideHandler(n.currentSlide), n.touchObject = {})
    }, r.prototype.swipeHandler = function (e) {
        var t = this;
        if (!(!1 === t.options.swipe || "ontouchend" in document && !1 === t.options.swipe || !1 === t.options.draggable && -1 !== e.type.indexOf("mouse"))) switch (t.touchObject.fingerCount = e.originalEvent && void 0 !== e.originalEvent.touches ? e.originalEvent.touches.length : 1, t.touchObject.minSwipe = t.listWidth / t.options.touchThreshold, !0 === t.options.verticalSwiping && (t.touchObject.minSwipe = t.listHeight / t.options.touchThreshold), e.data.action) {
            case"start":
                t.swipeStart(e);
                break;
            case"move":
                t.swipeMove(e);
                break;
            case"end":
                t.swipeEnd(e)
        }
    }, r.prototype.swipeMove = function (e) {
        var t, i, n = this, o = void 0 !== e.originalEvent ? e.originalEvent.touches : null;
        return !(!n.dragging || n.scrolling || o && 1 !== o.length) && (t = n.getLeft(n.currentSlide), n.touchObject.curX = void 0 !== o ? o[0].pageX : e.clientX, n.touchObject.curY = void 0 !== o ? o[0].pageY : e.clientY, n.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(n.touchObject.curX - n.touchObject.startX, 2))), o = Math.round(Math.sqrt(Math.pow(n.touchObject.curY - n.touchObject.startY, 2))), !n.options.verticalSwiping && !n.swiping && 4 < o ? !(n.scrolling = !0) : (!0 === n.options.verticalSwiping && (n.touchObject.swipeLength = o), o = n.swipeDirection(), void 0 !== e.originalEvent && 4 < n.touchObject.swipeLength && (n.swiping = !0, e.preventDefault()), e = (!1 === n.options.rtl ? 1 : -1) * (n.touchObject.curX > n.touchObject.startX ? 1 : -1), !0 === n.options.verticalSwiping && (e = n.touchObject.curY > n.touchObject.startY ? 1 : -1), i = n.touchObject.swipeLength, (n.touchObject.edgeHit = !1) === n.options.infinite && (0 === n.currentSlide && "right" === o || n.currentSlide >= n.getDotCount() && "left" === o) && (i = n.touchObject.swipeLength * n.options.edgeFriction, n.touchObject.edgeHit = !0), !1 === n.options.vertical ? n.swipeLeft = t + i * e : n.swipeLeft = t + i * (n.$list.height() / n.listWidth) * e, !0 === n.options.verticalSwiping && (n.swipeLeft = t + i * e), !0 !== n.options.fade && !1 !== n.options.touchMove && (!0 === n.animating ? (n.swipeLeft = null, !1) : void n.setCSS(n.swipeLeft))))
    }, r.prototype.swipeStart = function (e) {
        var t, i = this;
        if (i.interrupted = !0, 1 !== i.touchObject.fingerCount || i.slideCount <= i.options.slidesToShow) return !(i.touchObject = {});
        void 0 !== e.originalEvent && void 0 !== e.originalEvent.touches && (t = e.originalEvent.touches[0]), i.touchObject.startX = i.touchObject.curX = void 0 !== t ? t.pageX : e.clientX, i.touchObject.startY = i.touchObject.curY = void 0 !== t ? t.pageY : e.clientY, i.dragging = !0
    }, r.prototype.unfilterSlides = r.prototype.slickUnfilter = function () {
        var e = this;
        null !== e.$slidesCache && (e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.appendTo(e.$slideTrack), e.reinit())
    }, r.prototype.unload = function () {
        var e = this;
        c(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "")
    }, r.prototype.unslick = function (e) {
        this.$slider.trigger("unslick", [this, e]), this.destroy()
    }, r.prototype.updateArrows = function () {
        var e = this;
        Math.floor(e.options.slidesToShow / 2), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && !e.options.infinite && (e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === e.currentSlide ? (e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : (e.currentSlide >= e.slideCount - e.options.slidesToShow && !1 === e.options.centerMode || e.currentSlide >= e.slideCount - 1 && !0 === e.options.centerMode) && (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")))
    }, r.prototype.updateDots = function () {
        var e = this;
        null !== e.$dots && (e.$dots.find("li").removeClass("slick-active").end(), e.$dots.find("li").eq(Math.floor(e.currentSlide / e.options.slidesToScroll)).addClass("slick-active"))
    }, r.prototype.visibility = function () {
        this.options.autoplay && (document[this.hidden] ? this.interrupted = !0 : this.interrupted = !1)
    }, c.fn.slick = function () {
        for (var e, t = this, i = arguments[0], n = Array.prototype.slice.call(arguments, 1), o = t.length, s = 0; s < o; s++) if ("object" == typeof i || void 0 === i ? t[s].slick = new r(t[s], i) : e = t[s].slick[i].apply(t[s].slick, n), void 0 !== e) return e;
        return t
    }
});
var SimpleBar = function () {
    "use strict";
    var s = function (e, t) {
            return (s = Object.setPrototypeOf || ({__proto__: []} instanceof Array ? function (e, t) {
                e.__proto__ = t
            } : function (e, t) {
                for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && (e[i] = t[i])
            }))(e, t)
        }, e = !("undefined" == typeof window || !window.document || !window.document.createElement),
        t = "object" == typeof global && global && global.Object === Object && global,
        i = "object" == typeof self && self && self.Object === Object && self, n = t || i || Function("return this")(),
        t = n.Symbol, i = Object.prototype, r = i.hasOwnProperty, l = i.toString, a = t ? t.toStringTag : void 0,
        c = Object.prototype.toString, d = t ? t.toStringTag : void 0;
    var o = /\s/, u = /^\s+/;

    function y(e) {
        var t = typeof e;
        return null != e && ("object" == t || "function" == t)
    }

    var p = /^[-+]0x[0-9a-f]+$/i, H = /^0b[01]+$/i, W = /^0o[0-7]+$/i, P = parseInt;

    function b(e) {
        if ("number" == typeof e) return e;
        if ("symbol" == typeof (t = e) || null != t && "object" == typeof t && "[object Symbol]" == function (e) {
            if (null == e) return void 0 === e ? "[object Undefined]" : "[object Null]";
            if (d && d in Object(e)) {
                var t = e, i = r.call(t, a), n = t[a];
                try {
                    var o = !(t[a] = void 0)
                } catch (t) {
                }
                var s = l.call(t);
                return o && (i ? t[a] = n : delete t[a]), s
            }
            return c.call(e)
        }(t)) return NaN;
        if ("string" != typeof (e = y(e) ? y(t = "function" == typeof e.valueOf ? e.valueOf() : e) ? t + "" : t : e)) return 0 === e ? e : +e;
        e = (t = e) && t.slice(0, function (e) {
            for (var t = e.length; t-- && o.test(e.charAt(t));) ;
            return t
        }(t) + 1).replace(u, "");
        var t = H.test(e);
        return t || W.test(e) ? P(e.slice(2), t ? 2 : 8) : p.test(e) ? NaN : +e
    }

    var x = function () {
        return n.Date.now()
    }, z = Math.max, R = Math.min;

    function h(n, i, e) {
        var o, s, r, l, a, c, d = 0, u = !1, p = !1, t = !0;
        if ("function" != typeof n) throw new TypeError("Expected a function");

        function h(e) {
            var t = o, i = s;
            return o = s = void 0, d = e, l = n.apply(i, t)
        }

        function f(e) {
            var t = e - c;
            return void 0 === c || i <= t || t < 0 || p && r <= e - d
        }

        function v() {
            var e, t = x();
            if (f(t)) return g(t);
            a = setTimeout(v, (e = i - (t - c), p ? R(e, r - (t - d)) : e))
        }

        function g(e) {
            return a = void 0, t && o ? h(e) : (o = s = void 0, l)
        }

        function m() {
            var e = x(), t = f(e);
            if (o = arguments, s = this, c = e, t) {
                if (void 0 === a) return d = e = c, a = setTimeout(v, i), u ? h(e) : l;
                if (p) return clearTimeout(a), a = setTimeout(v, i), h(c)
            }
            return void 0 === a && (a = setTimeout(v, i)), l
        }

        return i = b(i) || 0, y(e) && (u = !!e.leading, r = (p = "maxWait" in e) ? z(b(e.maxWait) || 0, i) : r, t = "trailing" in e ? !!e.trailing : t), m.cancel = function () {
            void 0 !== a && clearTimeout(a), o = c = s = a = void (d = 0)
        }, m.flush = function () {
            return void 0 === a ? l : g(x())
        }, m
    }

    var f = function () {
        return (f = Object.assign || function (e) {
            for (var t, i = 1, n = arguments.length; i < n; i++) for (var o in t = arguments[i]) Object.prototype.hasOwnProperty.call(t, o) && (e[o] = t[o]);
            return e
        }).apply(this, arguments)
    }, v = null, g = null;

    function m() {
        if (null === v) {
            if ("undefined" == typeof document) return v = 0;
            var e = document.body, t = document.createElement("div"),
                i = (t.classList.add("simplebar-hide-scrollbar"), e.appendChild(t), t.getBoundingClientRect().right);
            e.removeChild(t), v = i
        }
        return v
    }

    function w(e) {
        return e && e.ownerDocument && e.ownerDocument.defaultView ? e.ownerDocument.defaultView : window
    }

    function k(e) {
        return e && e.ownerDocument ? e.ownerDocument : document
    }

    e && window.addEventListener("resize", function () {
        g !== window.devicePixelRatio && (g = window.devicePixelRatio, v = null)
    });

    function S(e) {
        return Array.prototype.reduce.call(e, function (e, t) {
            var i = t.name.match(/data-simplebar-(.+)/);
            if (i) {
                var n = i[1].replace(/\W+(.)/g, function (e, t) {
                    return t.toUpperCase()
                });
                switch (t.value) {
                    case"true":
                        e[n] = !0;
                        break;
                    case"false":
                        e[n] = !1;
                        break;
                    case void 0:
                        e[n] = !0;
                        break;
                    default:
                        e[n] = t.value
                }
            }
            return e
        }, {})
    }

    function T(e, t) {
        e && (e = e.classList).add.apply(e, t.split(" "))
    }

    function C(t, e) {
        t && e.split(" ").forEach(function (e) {
            t.classList.remove(e)
        })
    }

    function E(e) {
        return ".".concat(e.split(" ").join("."))
    }

    var i = Object.freeze({
        __proto__: null,
        getElementWindow: w,
        getElementDocument: k,
        getOptions: S,
        addClasses: T,
        removeClasses: C,
        classNamesToQuery: E
    }), A = w, $ = k, t = S, O = T, L = C, N = E, D = (j.getRtlHelpers = function () {
        if (!j.rtlHelpers) {
            var e = document.createElement("div"),
                e = (e.innerHTML = '<div class="simplebar-dummy-scrollbar-size"><div></div></div>', e.firstElementChild),
                t = null == e ? void 0 : e.firstElementChild;
            if (!t) return null;
            document.body.appendChild(e), e.scrollLeft = 0;
            var i = j.getOffset(e), n = j.getOffset(t), t = (e.scrollLeft = -999, j.getOffset(t));
            document.body.removeChild(e), j.rtlHelpers = {
                isScrollOriginAtZero: i.left !== n.left,
                isScrollingToNegative: n.left !== t.left
            }
        }
        return j.rtlHelpers
    }, j.prototype.getScrollbarWidth = function () {
        try {
            return this.contentWrapperEl && "none" === getComputedStyle(this.contentWrapperEl, "::-webkit-scrollbar").display || "scrollbarWidth" in document.documentElement.style || "-ms-overflow-style" in document.documentElement.style ? 0 : m()
        } catch (e) {
            return m()
        }
    }, j.getOffset = function (e) {
        var t = e.getBoundingClientRect(), i = $(e), e = A(e);
        return {
            top: t.top + (e.pageYOffset || i.documentElement.scrollTop),
            left: t.left + (e.pageXOffset || i.documentElement.scrollLeft)
        }
    }, j.prototype.init = function () {
        e && (this.initDOM(), this.rtlHelpers = j.getRtlHelpers(), this.scrollbarWidth = this.getScrollbarWidth(), this.recalculate(), this.initListeners())
    }, j.prototype.initDOM = function () {
        var e;
        this.wrapperEl = this.el.querySelector(N(this.classNames.wrapper)), this.contentWrapperEl = this.options.scrollableNode || this.el.querySelector(N(this.classNames.contentWrapper)), this.contentEl = this.options.contentNode || this.el.querySelector(N(this.classNames.contentEl)), this.offsetEl = this.el.querySelector(N(this.classNames.offset)), this.maskEl = this.el.querySelector(N(this.classNames.mask)), this.placeholderEl = this.findChild(this.wrapperEl, N(this.classNames.placeholder)), this.heightAutoObserverWrapperEl = this.el.querySelector(N(this.classNames.heightAutoObserverWrapperEl)), this.heightAutoObserverEl = this.el.querySelector(N(this.classNames.heightAutoObserverEl)), this.axis.x.track.el = this.findChild(this.el, "".concat(N(this.classNames.track)).concat(N(this.classNames.horizontal))), this.axis.y.track.el = this.findChild(this.el, "".concat(N(this.classNames.track)).concat(N(this.classNames.vertical))), this.axis.x.scrollbar.el = (null == (e = this.axis.x.track.el) ? void 0 : e.querySelector(N(this.classNames.scrollbar))) || null, this.axis.y.scrollbar.el = (null == (e = this.axis.y.track.el) ? void 0 : e.querySelector(N(this.classNames.scrollbar))) || null, this.options.autoHide || (O(this.axis.x.scrollbar.el, this.classNames.visible), O(this.axis.y.scrollbar.el, this.classNames.visible))
    }, j.prototype.initListeners = function () {
        var e, t, i = this, n = A(this.el);
        this.el.addEventListener("mouseenter", this.onMouseEnter), this.el.addEventListener("pointerdown", this.onPointerEvent, !0), this.el.addEventListener("mousemove", this.onMouseMove), this.el.addEventListener("mouseleave", this.onMouseLeave), null != (t = this.contentWrapperEl) && t.addEventListener("scroll", this.onScroll), n.addEventListener("resize", this.onWindowResize), this.contentEl && (window.ResizeObserver && (e = !1, t = n.ResizeObserver || ResizeObserver, this.resizeObserver = new t(function () {
            e && n.requestAnimationFrame(function () {
                i.recalculate()
            })
        }), this.resizeObserver.observe(this.el), this.resizeObserver.observe(this.contentEl), n.requestAnimationFrame(function () {
            e = !0
        })), this.mutationObserver = new n.MutationObserver(function () {
            n.requestAnimationFrame(function () {
                i.recalculate()
            })
        }), this.mutationObserver.observe(this.contentEl, {childList: !0, subtree: !0, characterData: !0}))
    }, j.prototype.recalculate = function () {
        var e, t, i, n, o, s, r, l;
        this.heightAutoObserverEl && this.contentEl && this.contentWrapperEl && this.wrapperEl && this.placeholderEl && (l = A(this.el), this.elStyles = l.getComputedStyle(this.el), this.isRtl = "rtl" === this.elStyles.direction, l = this.contentEl.offsetWidth, s = this.heightAutoObserverEl.offsetHeight <= 1, r = this.heightAutoObserverEl.offsetWidth <= 1 || 0 < l, e = this.contentWrapperEl.offsetWidth, t = this.elStyles.overflowX, i = this.elStyles.overflowY, this.contentEl.style.padding = "".concat(this.elStyles.paddingTop, " ").concat(this.elStyles.paddingRight, " ").concat(this.elStyles.paddingBottom, " ").concat(this.elStyles.paddingLeft), this.wrapperEl.style.margin = "-".concat(this.elStyles.paddingTop, " -").concat(this.elStyles.paddingRight, " -").concat(this.elStyles.paddingBottom, " -").concat(this.elStyles.paddingLeft), n = this.contentEl.scrollHeight, o = this.contentEl.scrollWidth, this.contentWrapperEl.style.height = s ? "auto" : "100%", this.placeholderEl.style.width = r ? "".concat(l || o, "px") : "auto", this.placeholderEl.style.height = "".concat(n, "px"), s = this.contentWrapperEl.offsetHeight, this.axis.x.isOverflowing = 0 !== l && l < o, this.axis.y.isOverflowing = s < n, this.axis.x.isOverflowing = "hidden" !== t && this.axis.x.isOverflowing, this.axis.y.isOverflowing = "hidden" !== i && this.axis.y.isOverflowing, this.axis.x.forceVisible = "x" === this.options.forceVisible || !0 === this.options.forceVisible, this.axis.y.forceVisible = "y" === this.options.forceVisible || !0 === this.options.forceVisible, this.hideNativeScrollbar(), r = this.axis.x.isOverflowing ? this.scrollbarWidth : 0, l = this.axis.y.isOverflowing ? this.scrollbarWidth : 0, this.axis.x.isOverflowing = this.axis.x.isOverflowing && e - l < o, this.axis.y.isOverflowing = this.axis.y.isOverflowing && s - r < n, this.axis.x.scrollbar.size = this.getScrollbarSize("x"), this.axis.y.scrollbar.size = this.getScrollbarSize("y"), this.axis.x.scrollbar.el && (this.axis.x.scrollbar.el.style.width = "".concat(this.axis.x.scrollbar.size, "px")), this.axis.y.scrollbar.el && (this.axis.y.scrollbar.el.style.height = "".concat(this.axis.y.scrollbar.size, "px")), this.positionScrollbar("x"), this.positionScrollbar("y"), this.toggleTrackVisibility("x"), this.toggleTrackVisibility("y"))
    }, j.prototype.getScrollbarSize = function (e) {
        var t, i;
        return this.axis[e = void 0 === e ? "y" : e].isOverflowing && this.contentEl ? (t = this.contentEl[this.axis[e].scrollSizeAttr], e = null != (i = null == (i = this.axis[e].track.el) ? void 0 : i[this.axis[e].offsetSizeAttr]) ? i : 0, i = Math.max(~~(e / t * e), this.options.scrollbarMinSize), this.options.scrollbarMaxSize ? Math.min(i, this.options.scrollbarMaxSize) : i) : 0
    }, j.prototype.positionScrollbar = function (e) {
        var t, i, n, o, s, r = this.axis[e = void 0 === e ? "y" : e].scrollbar;
        this.axis[e].isOverflowing && this.contentWrapperEl && r.el && this.elStyles && (t = this.contentWrapperEl[this.axis[e].scrollSizeAttr], i = (null == (i = this.axis[e].track.el) ? void 0 : i[this.axis[e].offsetSizeAttr]) || 0, n = parseInt(this.elStyles[this.axis[e].sizeAttr], 10), o = this.contentWrapperEl[this.axis[e].scrollOffsetAttr], o = "x" === e && this.isRtl && null != (s = j.getRtlHelpers()) && s.isScrollOriginAtZero ? -o : o, "x" === e && this.isRtl && (o = null != (s = j.getRtlHelpers()) && s.isScrollingToNegative ? o : -o), s = ~~((i - r.size) * (o / (t - n))), s = "x" === e && this.isRtl ? -s + (i - r.size) : s, r.el.style.transform = "x" === e ? "translate3d(".concat(s, "px, 0, 0)") : "translate3d(0, ".concat(s, "px, 0)"))
    }, j.prototype.toggleTrackVisibility = function (e) {
        var t = this.axis[e = void 0 === e ? "y" : e].track.el, i = this.axis[e].scrollbar.el;
        t && i && this.contentWrapperEl && (this.axis[e].isOverflowing || this.axis[e].forceVisible ? (t.style.visibility = "visible", this.contentWrapperEl.style[this.axis[e].overflowAttr] = "scroll", this.el.classList.add("".concat(this.classNames.scrollable, "-").concat(e))) : (t.style.visibility = "hidden", this.contentWrapperEl.style[this.axis[e].overflowAttr] = "hidden", this.el.classList.remove("".concat(this.classNames.scrollable, "-").concat(e))), this.axis[e].isOverflowing ? i.style.display = "block" : i.style.display = "none")
    }, j.prototype.showScrollbar = function (e) {
        this.axis[e = void 0 === e ? "y" : e].isOverflowing && !this.axis[e].scrollbar.isVisible && (O(this.axis[e].scrollbar.el, this.classNames.visible), this.axis[e].scrollbar.isVisible = !0)
    }, j.prototype.hideScrollbar = function (e) {
        this.axis[e = void 0 === e ? "y" : e].isOverflowing && this.axis[e].scrollbar.isVisible && (L(this.axis[e].scrollbar.el, this.classNames.visible), this.axis[e].scrollbar.isVisible = !1)
    }, j.prototype.hideNativeScrollbar = function () {
        this.offsetEl && (this.offsetEl.style[this.isRtl ? "left" : "right"] = this.axis.y.isOverflowing || this.axis.y.forceVisible ? "-".concat(this.scrollbarWidth, "px") : "0px", this.offsetEl.style.bottom = this.axis.x.isOverflowing || this.axis.x.forceVisible ? "-".concat(this.scrollbarWidth, "px") : "0px")
    }, j.prototype.onMouseMoveForAxis = function (e) {
        var t = this.axis[e = void 0 === e ? "y" : e];
        t.track.el && t.scrollbar.el && (t.track.rect = t.track.el.getBoundingClientRect(), t.scrollbar.rect = t.scrollbar.el.getBoundingClientRect(), this.isWithinBounds(t.track.rect) ? (this.showScrollbar(e), O(t.track.el, this.classNames.hover), (this.isWithinBounds(t.scrollbar.rect) ? O : L)(t.scrollbar.el, this.classNames.hover)) : (L(t.track.el, this.classNames.hover), this.options.autoHide && this.hideScrollbar(e)))
    }, j.prototype.onMouseLeaveForAxis = function (e) {
        L(this.axis[e = void 0 === e ? "y" : e].track.el, this.classNames.hover), L(this.axis[e].scrollbar.el, this.classNames.hover), this.options.autoHide && this.hideScrollbar(e)
    }, j.prototype.onDragStart = function (e, t) {
        void 0 === t && (t = "y");
        var i = $(this.el), n = A(this.el), o = this.axis[t].scrollbar, e = "y" === t ? e.pageY : e.pageX;
        this.axis[t].dragOffset = e - ((null == (e = o.rect) ? void 0 : e[this.axis[t].offsetAttr]) || 0), this.draggedAxis = t, O(this.el, this.classNames.dragging), i.addEventListener("mousemove", this.drag, !0), i.addEventListener("mouseup", this.onEndDrag, !0), null === this.removePreventClickId ? (i.addEventListener("click", this.preventClick, !0), i.addEventListener("dblclick", this.preventClick, !0)) : (n.clearTimeout(this.removePreventClickId), this.removePreventClickId = null)
    }, j.prototype.onTrackClick = function (e, t) {
        var i, n, o, s, r, l = this, a = (void 0 === t && (t = "y"), this.axis[t]);
        this.options.clickOnTrack && a.scrollbar.el && this.contentWrapperEl && (e.preventDefault(), i = A(this.el), this.axis[t].scrollbar.rect = a.scrollbar.el.getBoundingClientRect(), e = null != (a = null == (e = this.axis[t].scrollbar.rect) ? void 0 : e[this.axis[t].offsetAttr]) ? a : 0, a = parseInt(null != (a = null == (a = this.elStyles) ? void 0 : a[this.axis[t].sizeAttr]) ? a : "0px", 10), n = this.contentWrapperEl[this.axis[t].scrollOffsetAttr], o = ("y" === t ? this.mouseY - e : this.mouseX - e) < 0 ? -1 : 1, s = -1 === o ? n - a : n + a, (r = function () {
            l.contentWrapperEl && (-1 === o ? s < n && (n -= 40, l.contentWrapperEl[l.axis[t].scrollOffsetAttr] = n, i.requestAnimationFrame(r)) : n < s && (n += 40, l.contentWrapperEl[l.axis[t].scrollOffsetAttr] = n, i.requestAnimationFrame(r)))
        })())
    }, j.prototype.getContentElement = function () {
        return this.contentEl
    }, j.prototype.getScrollElement = function () {
        return this.contentWrapperEl
    }, j.prototype.removeListeners = function () {
        var e = A(this.el);
        this.el.removeEventListener("mouseenter", this.onMouseEnter), this.el.removeEventListener("pointerdown", this.onPointerEvent, !0), this.el.removeEventListener("mousemove", this.onMouseMove), this.el.removeEventListener("mouseleave", this.onMouseLeave), this.contentWrapperEl && this.contentWrapperEl.removeEventListener("scroll", this.onScroll), e.removeEventListener("resize", this.onWindowResize), this.mutationObserver && this.mutationObserver.disconnect(), this.resizeObserver && this.resizeObserver.disconnect(), this.onMouseMove.cancel(), this.onWindowResize.cancel(), this.onStopScrolling.cancel(), this.onMouseEntered.cancel()
    }, j.prototype.unMount = function () {
        this.removeListeners()
    }, j.prototype.isWithinBounds = function (e) {
        return this.mouseX >= e.left && this.mouseX <= e.left + e.width && this.mouseY >= e.top && this.mouseY <= e.top + e.height
    }, j.prototype.findChild = function (e, t) {
        var i = e.matches || e.webkitMatchesSelector || e.mozMatchesSelector || e.msMatchesSelector;
        return Array.prototype.filter.call(e.children, function (e) {
            return i.call(e, t)
        })[0]
    }, j.rtlHelpers = null, j.defaultOptions = {
        forceVisible: !1,
        clickOnTrack: !0,
        scrollbarMinSize: 25,
        scrollbarMaxSize: 0,
        ariaLabel: "scrollable content",
        classNames: {
            contentEl: "simplebar-content",
            contentWrapper: "simplebar-content-wrapper",
            offset: "simplebar-offset",
            mask: "simplebar-mask",
            wrapper: "simplebar-wrapper",
            placeholder: "simplebar-placeholder",
            scrollbar: "simplebar-scrollbar",
            track: "simplebar-track",
            heightAutoObserverWrapperEl: "simplebar-height-auto-observer-wrapper",
            heightAutoObserverEl: "simplebar-height-auto-observer",
            visible: "simplebar-visible",
            horizontal: "simplebar-horizontal",
            vertical: "simplebar-vertical",
            hover: "simplebar-hover",
            dragging: "simplebar-dragging",
            scrolling: "simplebar-scrolling",
            scrollable: "simplebar-scrollable",
            mouseEntered: "simplebar-mouse-entered"
        },
        scrollableNode: null,
        contentNode: null,
        autoHide: !0
    }, j.getOptions = t, j.helpers = i, j), t = D.helpers, M = t.getOptions, q = t.addClasses, i = function (n) {
        function o() {
            for (var e = [], t = 0; t < arguments.length; t++) e[t] = arguments[t];
            var i = n.apply(this, e) || this;
            return o.instances.set(e[0], i), i
        }

        var e = o, t = n;
        if ("function" != typeof t && null !== t) throw new TypeError("Class extends value " + String(t) + " is not a constructor or null");

        function i() {
            this.constructor = e
        }

        return s(e, t), e.prototype = null === t ? Object.create(t) : (i.prototype = t.prototype, new i), o.initDOMLoadedElements = function () {
            document.removeEventListener("DOMContentLoaded", this.initDOMLoadedElements), window.removeEventListener("load", this.initDOMLoadedElements), Array.prototype.forEach.call(document.querySelectorAll("[data-simplebar]"), function (e) {
                "init" === e.getAttribute("data-simplebar") || o.instances.has(e) || new o(e, M(e.attributes))
            })
        }, o.removeObserver = function () {
            var e;
            null != (e = o.globalObserver) && e.disconnect()
        }, o.prototype.initDOM = function () {
            var e, t, i = this;
            if (!Array.prototype.filter.call(this.el.children, function (e) {
                return e.classList.contains(i.classNames.wrapper)
            }).length) {
                for (this.wrapperEl = document.createElement("div"), this.contentWrapperEl = document.createElement("div"), this.offsetEl = document.createElement("div"), this.maskEl = document.createElement("div"), this.contentEl = document.createElement("div"), this.placeholderEl = document.createElement("div"), this.heightAutoObserverWrapperEl = document.createElement("div"), this.heightAutoObserverEl = document.createElement("div"), q(this.wrapperEl, this.classNames.wrapper), q(this.contentWrapperEl, this.classNames.contentWrapper), q(this.offsetEl, this.classNames.offset), q(this.maskEl, this.classNames.mask), q(this.contentEl, this.classNames.contentEl), q(this.placeholderEl, this.classNames.placeholder), q(this.heightAutoObserverWrapperEl, this.classNames.heightAutoObserverWrapperEl), q(this.heightAutoObserverEl, this.classNames.heightAutoObserverEl); this.el.firstChild;) this.contentEl.appendChild(this.el.firstChild);
                this.contentWrapperEl.appendChild(this.contentEl), this.offsetEl.appendChild(this.contentWrapperEl), this.maskEl.appendChild(this.offsetEl), this.heightAutoObserverWrapperEl.appendChild(this.heightAutoObserverEl), this.wrapperEl.appendChild(this.heightAutoObserverWrapperEl), this.wrapperEl.appendChild(this.maskEl), this.wrapperEl.appendChild(this.placeholderEl), this.el.appendChild(this.wrapperEl), null != (e = this.contentWrapperEl) && e.setAttribute("tabindex", "0"), null != (e = this.contentWrapperEl) && e.setAttribute("role", "region"), null != (e = this.contentWrapperEl) && e.setAttribute("aria-label", this.options.ariaLabel)
            }
            this.axis.x.track.el && this.axis.y.track.el || (e = document.createElement("div"), t = document.createElement("div"), q(e, this.classNames.track), q(t, this.classNames.scrollbar), e.appendChild(t), this.axis.x.track.el = e.cloneNode(!0), q(this.axis.x.track.el, this.classNames.horizontal), this.axis.y.track.el = e.cloneNode(!0), q(this.axis.y.track.el, this.classNames.vertical), this.el.appendChild(this.axis.x.track.el), this.el.appendChild(this.axis.y.track.el)), D.prototype.initDOM.call(this), this.el.setAttribute("data-simplebar", "init")
        }, o.prototype.unMount = function () {
            D.prototype.unMount.call(this), o.instances.delete(this.el)
        }, o.initHtmlApi = function () {
            this.initDOMLoadedElements = this.initDOMLoadedElements.bind(this), "undefined" != typeof MutationObserver && (this.globalObserver = new MutationObserver(o.handleMutations), this.globalObserver.observe(document, {
                childList: !0,
                subtree: !0
            })), "complete" === document.readyState || "loading" !== document.readyState && !document.documentElement.doScroll ? window.setTimeout(this.initDOMLoadedElements) : (document.addEventListener("DOMContentLoaded", this.initDOMLoadedElements), window.addEventListener("load", this.initDOMLoadedElements))
        }, o.handleMutations = function (e) {
            e.forEach(function (e) {
                e.addedNodes.forEach(function (e) {
                    1 === e.nodeType && (e.hasAttribute("data-simplebar") ? !o.instances.has(e) && document.documentElement.contains(e) && new o(e, M(e.attributes)) : e.querySelectorAll("[data-simplebar]").forEach(function (e) {
                        "init" !== e.getAttribute("data-simplebar") && !o.instances.has(e) && document.documentElement.contains(e) && new o(e, M(e.attributes))
                    }))
                }), e.removedNodes.forEach(function (e) {
                    1 === e.nodeType && ("init" === e.getAttribute("data-simplebar") ? o.instances.has(e) && !document.documentElement.contains(e) && o.instances.get(e).unMount() : Array.prototype.forEach.call(e.querySelectorAll('[data-simplebar="init"]'), function (e) {
                        o.instances.has(e) && !document.documentElement.contains(e) && o.instances.get(e).unMount()
                    }))
                })
            })
        }, o.instances = new WeakMap, o
    }(D);

    function j(e, t) {
        void 0 === t && (t = {});
        var r = this;
        if (this.removePreventClickId = null, this.minScrollbarWidth = 20, this.stopScrollDelay = 175, this.isScrolling = !1, this.isMouseEntering = !1, this.scrollXTicking = !1, this.scrollYTicking = !1, this.wrapperEl = null, this.contentWrapperEl = null, this.contentEl = null, this.offsetEl = null, this.maskEl = null, this.placeholderEl = null, this.heightAutoObserverWrapperEl = null, this.heightAutoObserverEl = null, this.rtlHelpers = null, this.scrollbarWidth = 0, this.resizeObserver = null, this.mutationObserver = null, this.elStyles = null, this.isRtl = null, this.mouseX = 0, this.mouseY = 0, this.onMouseMove = function () {
        }, this.onWindowResize = function () {
        }, this.onStopScrolling = function () {
        }, this.onMouseEntered = function () {
        }, this.onScroll = function () {
            var e = A(r.el);
            r.scrollXTicking || (e.requestAnimationFrame(r.scrollX), r.scrollXTicking = !0), r.scrollYTicking || (e.requestAnimationFrame(r.scrollY), r.scrollYTicking = !0), r.isScrolling || (r.isScrolling = !0, O(r.el, r.classNames.scrolling)), r.showScrollbar("x"), r.showScrollbar("y"), r.onStopScrolling()
        }, this.scrollX = function () {
            r.axis.x.isOverflowing && r.positionScrollbar("x"), r.scrollXTicking = !1
        }, this.scrollY = function () {
            r.axis.y.isOverflowing && r.positionScrollbar("y"), r.scrollYTicking = !1
        }, this._onStopScrolling = function () {
            L(r.el, r.classNames.scrolling), r.options.autoHide && (r.hideScrollbar("x"), r.hideScrollbar("y")), r.isScrolling = !1
        }, this.onMouseEnter = function () {
            r.isMouseEntering || (O(r.el, r.classNames.mouseEntered), r.showScrollbar("x"), r.showScrollbar("y"), r.isMouseEntering = !0), r.onMouseEntered()
        }, this._onMouseEntered = function () {
            L(r.el, r.classNames.mouseEntered), r.options.autoHide && (r.hideScrollbar("x"), r.hideScrollbar("y")), r.isMouseEntering = !1
        }, this._onMouseMove = function (e) {
            r.mouseX = e.clientX, r.mouseY = e.clientY, (r.axis.x.isOverflowing || r.axis.x.forceVisible) && r.onMouseMoveForAxis("x"), (r.axis.y.isOverflowing || r.axis.y.forceVisible) && r.onMouseMoveForAxis("y")
        }, this.onMouseLeave = function () {
            r.onMouseMove.cancel(), (r.axis.x.isOverflowing || r.axis.x.forceVisible) && r.onMouseLeaveForAxis("x"), (r.axis.y.isOverflowing || r.axis.y.forceVisible) && r.onMouseLeaveForAxis("y"), r.mouseX = -1, r.mouseY = -1
        }, this._onWindowResize = function () {
            r.scrollbarWidth = r.getScrollbarWidth(), r.hideNativeScrollbar()
        }, this.onPointerEvent = function (e) {
            var t, i;
            r.axis.x.track.el && r.axis.y.track.el && r.axis.x.scrollbar.el && r.axis.y.scrollbar.el && (r.axis.x.track.rect = r.axis.x.track.el.getBoundingClientRect(), r.axis.y.track.rect = r.axis.y.track.el.getBoundingClientRect(), (r.axis.x.isOverflowing || r.axis.x.forceVisible) && (t = r.isWithinBounds(r.axis.x.track.rect)), (r.axis.y.isOverflowing || r.axis.y.forceVisible) && (i = r.isWithinBounds(r.axis.y.track.rect)), t || i) && (e.stopPropagation(), "pointerdown" === e.type) && "touch" !== e.pointerType && (t && (r.axis.x.scrollbar.rect = r.axis.x.scrollbar.el.getBoundingClientRect(), r.isWithinBounds(r.axis.x.scrollbar.rect) ? r.onDragStart(e, "x") : r.onTrackClick(e, "x")), i) && (r.axis.y.scrollbar.rect = r.axis.y.scrollbar.el.getBoundingClientRect(), r.isWithinBounds(r.axis.y.scrollbar.rect) ? r.onDragStart(e, "y") : r.onTrackClick(e, "y"))
        }, this.drag = function (e) {
            var t, i, n, o, s;
            r.draggedAxis && r.contentWrapperEl && (t = null != (t = null == (t = (s = r.axis[r.draggedAxis].track).rect) ? void 0 : t[r.axis[r.draggedAxis].sizeAttr]) ? t : 0, i = r.axis[r.draggedAxis].scrollbar, n = null != (n = null == (n = r.contentWrapperEl) ? void 0 : n[r.axis[r.draggedAxis].scrollSizeAttr]) ? n : 0, o = parseInt(null != (o = null == (o = r.elStyles) ? void 0 : o[r.axis[r.draggedAxis].sizeAttr]) ? o : "0px", 10), e.preventDefault(), e.stopPropagation(), e = ("y" === r.draggedAxis ? e.pageY : e.pageX) - (null != (e = null == (e = s.rect) ? void 0 : e[r.axis[r.draggedAxis].offsetAttr]) ? e : 0) - r.axis[r.draggedAxis].dragOffset, s = (e = "x" === r.draggedAxis && r.isRtl ? (null != (s = null == (s = s.rect) ? void 0 : s[r.axis[r.draggedAxis].sizeAttr]) ? s : 0) - i.size - e : e) / (t - i.size) * (n - o), "x" === r.draggedAxis && r.isRtl && (s = null != (e = j.getRtlHelpers()) && e.isScrollingToNegative ? -s : s), r.contentWrapperEl[r.axis[r.draggedAxis].scrollOffsetAttr] = s)
        }, this.onEndDrag = function (e) {
            var t = $(r.el), i = A(r.el);
            e.preventDefault(), e.stopPropagation(), L(r.el, r.classNames.dragging), t.removeEventListener("mousemove", r.drag, !0), t.removeEventListener("mouseup", r.onEndDrag, !0), r.removePreventClickId = i.setTimeout(function () {
                t.removeEventListener("click", r.preventClick, !0), t.removeEventListener("dblclick", r.preventClick, !0), r.removePreventClickId = null
            })
        }, this.preventClick = function (e) {
            e.preventDefault(), e.stopPropagation()
        }, this.el = e, this.options = f(f({}, j.defaultOptions), t), this.classNames = f(f({}, j.defaultOptions.classNames), t.classNames), this.axis = {
            x: {
                scrollOffsetAttr: "scrollLeft",
                sizeAttr: "width",
                scrollSizeAttr: "scrollWidth",
                offsetSizeAttr: "offsetWidth",
                offsetAttr: "left",
                overflowAttr: "overflowX",
                dragOffset: 0,
                isOverflowing: !0,
                forceVisible: !1,
                track: {size: null, el: null, rect: null, isVisible: !1},
                scrollbar: {size: null, el: null, rect: null, isVisible: !1}
            },
            y: {
                scrollOffsetAttr: "scrollTop",
                sizeAttr: "height",
                scrollSizeAttr: "scrollHeight",
                offsetSizeAttr: "offsetHeight",
                offsetAttr: "top",
                overflowAttr: "overflowY",
                dragOffset: 0,
                isOverflowing: !0,
                forceVisible: !1,
                track: {size: null, el: null, rect: null, isVisible: !1},
                scrollbar: {size: null, el: null, rect: null, isVisible: !1}
            }
        }, "object" != typeof this.el || !this.el.nodeName) throw new Error("Argument passed to SimpleBar must be an HTML element instead of ".concat(this.el));
        this.onMouseMove = function (e, t) {
            var i = !0, n = !0;
            if ("function" != typeof e) throw new TypeError("Expected a function");
            return y(t) && (i = "leading" in t ? !!t.leading : i, n = "trailing" in t ? !!t.trailing : n), h(e, 64, {
                leading: i,
                maxWait: 64,
                trailing: n
            })
        }(this._onMouseMove), this.onWindowResize = h(this._onWindowResize, 64, {leading: !0}), this.onStopScrolling = h(this._onStopScrolling, this.stopScrollDelay), this.onMouseEntered = h(this._onMouseEntered, this.stopScrollDelay), this.init()
    }

    return e && i.initHtmlApi(), i
}();

class MinModalJS {
    modalOpen() {
        this.modal.classList.add("min-modal-js-active"), document.querySelector(".wrapper").classList.add("lock"), document.body.classList.add("lock"), this.whenModalOpen && this.whenModalOpen()
    }

    modalClose() {
        this.modal.classList.remove("min-modal-js-active"), document.querySelector(".wrapper").classList.remove("lock"), document.body.classList.remove("lock"), this.whenModalClose()
    }

    modalDestroy() {
        this.modal.remove()
    }

    constructor(e, t) {
        void 0 === t.keyOpen && (t.keyOpen = "Escape"), this.btns = document.querySelectorAll(t.buttonsActive), this.inner = document.querySelector(e), this.closeBtns = document.querySelectorAll(t.buttonsDisActive), this.keyOpen = t.keyOpen, this.modalOutsideClick = t.modalOutsideClick, this.modal = document.createElement("div"), this.modal.classList.add("modal-wrapper"), this.whenModalClose = t.whenModalClose, this.whenModalOpen = t.whenModalOpen, this.modal.append(this.inner), document.querySelector(".wrapper").append(this.modal), this.btns.forEach(e => {
            e.addEventListener("click", e => {
                e.preventDefault(), this.modalOpen()
            })
        }), this.closeBtns.forEach(e => {
            e.addEventListener("click", e => {
                e.preventDefault(), this.modalClose()
            })
        }), 0 != this.modalOutsideClick && this.modal.addEventListener("click", e => {
            e.target === this.modal && this.modalClose()
        }), 0 != this.key && document.addEventListener("keydown", e => {
            e.key === this.keyOpen && this.modalClose()
        })
    }
}

document.addEventListener("DOMContentLoaded", function () {
    var t = document.querySelectorAll("[data-custom-select]");
    for (let e = 0; e < t.length; e++) {
        const c = t[e], d = c.querySelectorAll("option"), u = document.createElement("div"),
            p = document.createElement("div"), h = document.createElement("div"), f = document.createElement("span");
        u.className = "custom-select " + c.classList, p.className = "custom-select__list custom-scrollbar", h.className = "custom-select__current", h.append(f), u.append(h, p), c.after(u);
        const v = () => {
            u.classList.toggle("custom-select--show")
        };
        {
            o = void 0;
            var i = () => f.textContent = p.children[0].textContent;
            var n = () => {
                for (var i = p.children, n = 0; n < i.length; n++) {
                    let e = i[n].getAttribute("data-value"), t = i[n].textContent;

                }
            };
            let e = "";
            for (var o = 0; o < d.length; o++) console.log(c.clientWidth), e += '<div class="custom-select__item" data-value="' + d[o].value + '">' + d[o].text + "</div>";
            p.innerHTML = e, i(), n()
        }
        document.addEventListener("mouseup", e => {
            u.contains(e.target) || u.classList.remove("custom-select--show")
        }), i = () => {
            h.addEventListener("click", v)
        }, n = () => {
            h.addEventListener("click", v)
        }, navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/Windows Phone/i) ? (i(), console.log("mobile")) : (n(), console.log("desktop"))
    }
    if (document.querySelector(".multi-range") && document.querySelectorAll(".multi-range").forEach(e => {
        const t = e.querySelector(".lower"), i = e.querySelector(".upper");
        let n = parseInt(t.value), o = parseInt(i.value), s = e.querySelector(".filter-form__range-value--1"),
            r = e.querySelector(".filter-form__range-value--2");
        i.oninput = function () {
            n = parseInt(t.value), (o = parseInt(i.value)) < n + 1 && (t.value = o - 1, n == t.min) && (i.value = 1), s.textContent = n, r.textContent = o, console.log(n)
        }, t.oninput = function () {
            n = parseInt(t.value), o = parseInt(i.value), n > o - 1 && (i.value = n + 1, o == i.max) && (t.value = parseInt(i.max) - 1), s.textContent = n, r.textContent = o, console.log(o), console.log(i.value), console.log(n)
        }
    }), document.querySelector(".header")) {
        var e = document.querySelectorAll("[data-params-btn]");
        const g = document.querySelector(".filter-search-params__drop");
        var s = document.querySelectorAll("[data-filter-btn]");
        const m = document.querySelector(".filter__top"), y = document.querySelector(".filter-search-params__drop"),
            b = document.querySelectorAll("[data-params-tab-title]"),
            x = document.querySelectorAll("[data-params-tab-content");
        b.forEach((e, t) => {
            e.addEventListener("click", () => {
                b.forEach((e, t) => {
                    e.classList.remove("active"), x[t].classList.remove("active")
                }), e.classList.add("active"), x[t].classList.add("active")
            })
        }), e.forEach(e => {
            e.addEventListener("click", () => {
                document.body.classList.toggle("lock"), m.classList.remove("active"), g.classList.toggle("active")
            })
        }), window.innerWidth <= 1040 && (s.forEach(e => {
            e.addEventListener("click", () => {
                console.log("ok"), y.classList.remove("active"), m.classList.toggle("active")
            })
        }), document.body.append(m), document.body.append(g))
    }
    if (document.querySelector(".catalog-item__phone")) {
        const w = document.querySelectorAll(".catalog-item-phone__text"),
            k = document.querySelectorAll(".catalog-item-phone__phone");
        document.querySelectorAll(".catalog-item__footer").forEach((e, t) => {
            e.addEventListener("click", () => {
                w[t].classList.toggle("active"), k[t].classList.toggle("active")
            })
        })
    }
    if (window.innerWidth <= 992) {
        e = document.querySelectorAll(".filter-search-params__item-title");
        const S = document.querySelectorAll(".filter-search-params__item-list");
        e.forEach((e, t) => {
            e.addEventListener("click", () => {
                e.classList.toggle("active"), S[t].classList.toggle("active")
            })
        })
    }
    if (document.querySelector("[data-video]")) {
        s = document.querySelectorAll("[data-video]");
        const T = document.querySelector("video");
        document.querySelector(".modal-video__body"), new MinModalJS(".modal-video", {
            buttonsActive: "[data-video]",
            buttonsDisActive: ".modal-video__close",
            keyOpen: !1,
            modalOutsideClick: !0,
            whenModalClose: function () {
                T.pause()
            }
        });
        s.forEach(t => {
            t.addEventListener("click", e => {
                e.preventDefault(), T.getAttribute("src") != t.getAttribute("href") && (T.src = t.getAttribute("href"))
            })
        })
    }
    if (document.querySelector(".profile__modal-form")) {
        e = document.querySelectorAll(".profile__modal-toggle");
        const C = document.querySelector(".profile__modal-bg");
        e.forEach(e => {
            e.addEventListener("click", () => {
                document.querySelector("html").classList.toggle("lock"),
                    document.querySelector(".wrapper").classList.toggle("lock"),
                    C.classList.toggle("active")
            })
        })
    }

    function r() {
        let t, i, n;
        for (let e = 0; e < ratings.length; e++) {
            var o = ratings[e],
                s = (n = ratings[e].offsetWidth / 5, console.log(void 0), s = void 0, o = o), [s = i.innerHTML] = (i = s.querySelector(".rating-stars__value"), t = s.querySelector(".rating-stars__progress"), s = void 0, []);
            s = Math.floor(n) * s, t.style.width = s + "%", o.classList.contains("rating-stars--set") && setRating(o)
        }
    }

    (ratings = document.querySelectorAll(".rating-stars")) && r();
    const l = document.querySelectorAll(".rating-stars-set label");
    let a = !1;
    if (l.forEach((e, i) => {
        e.addEventListener("mouseenter", () => {
            l.forEach(e => {
                e.classList.remove("active")
            }), l.forEach((e, t) => {
                console.log(t), t <= i && e.classList.add("active")
            })
        }), e.addEventListener("mouseleave", () => {
            a || l.forEach(e => {
                e.classList.remove("active")
            })
        }), e.addEventListener("click", () => {
            l.forEach(e => {
                e.classList.remove("activeClick")
            }), l.forEach((e, t) => {
                console.log(t), t <= i && e.classList.add("activeClick")
            }), a = !a
        })
    }), document.querySelector(".single-block-about__slider") && $(".single-block-about__slider").slick({
        dots: !1,
        arrows: !0,
        slidesToShow: 1,
        slidesToScroll: 1
    }), document.querySelector(".single") && window.innerWidth <= 768 && (document.querySelector(".adaptive").append(document.querySelector(".single-block-about__row-title")), document.querySelector(".single-block-about__row-title").append(document.querySelector(".single-block-about__status"))), document.querySelector(".profile__about-sim")) {
        const E = document.querySelectorAll(".profile__about-sim-tabs-item"),
            A = document.querySelectorAll(".profile__about-sim-items");
        E.forEach((e, t) => {
            e.addEventListener("click", () => {
                E.forEach((e, t) => {
                    e.classList.remove("active"), A[t].classList.remove("active")
                }), e.getAttribute("id") === A[t].getAttribute("id") && (e.classList.add("active"), A[t].classList.add("active"))
            })
        })
    }
});





