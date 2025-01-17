(() => {
    function e(t) {
        return e = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        }, e(t)
    }

    function t(t, n) {
        for (var r = 0; r < n.length; r++) {
            var o = n[r];
            o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(t, (a = o.key, i = void 0, i = function (t, n) {
                if ("object" !== e(t) || null === t) return t;
                var r = t[Symbol.toPrimitive];
                if (void 0 !== r) {
                    var o = r.call(t, n || "default");
                    if ("object" !== e(o)) return o;
                    throw new TypeError("@@toPrimitive must return a primitive value.")
                }
                return ("string" === n ? String : Number)(t)
            }(a, "string"), "symbol" === e(i) ? i : String(i)), o)
        }
        var a, i
    }
    var n = function () {
        function e() {
            ! function (e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }(this, e)
        }
        var n, r, o;
        return n = e, (r = [{
            key: "init",
            value: function () {
                $(document).on("click", ".answer-trigger-button", (function (e) {
                    e.preventDefault(), e.stopPropagation();
                    var t = $(".answer-wrapper");
                    t.is(":visible") ? t.fadeOut() : t.fadeIn(), (new EditorManagement).init()
                })), $(document).on("click", ".answer-send-button", (function (e) {
                    e.preventDefault(), e.stopPropagation(), $(e.currentTarget).addClass("button-loading");
                    var t = $("#message").val();
                    "undefined" != typeof tinymce && (t = tinymce.get("message").getContent()), $.ajax({
                        type: "POST",
                        cache: !1,
                        url: route("contacts.reply", $("#input_contact_id").val()),
                        data: {
                            message: t
                        },
                        success: function (t) {
                            if (!t.error) {
                                if ($(".answer-wrapper").fadeOut(), "undefined" != typeof tinymce) tinymce.get("message").setContent("");
                                else {
                                    $("#message").val("");
                                    var n = document.querySelector(".answer-wrapper .ck-editor__editable");
                                    if (n) {
                                        var r = n.ckeditorInstance;
                                        r && r.setData("")
                                    }
                                }
                                Botble.showSuccess(t.message), $("#reply-wrapper").load(window.location.href + " #reply-wrapper > *")
                            }
                            $(e.currentTarget).removeClass("button-loading")
                        },
                        error: function (t) {
                            $(e.currentTarget).removeClass("button-loading"), Botble.handleError(t)
                        }
                    })
                }))
            }
        }]) && t(n.prototype, r), o && t(n, o), Object.defineProperty(n, "prototype", {
            writable: !1
        }), e
    }();
    $(document).ready((function () {
        (new n).init();
    }))
})();
