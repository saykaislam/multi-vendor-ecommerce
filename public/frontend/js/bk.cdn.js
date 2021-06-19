!(function (window) {
    "use strict";
    let _scripts = document.getElementsByTagName("script"),
        _params = (function (query) {
            let _params = new Object();
            if (!query) return _params;
            let Pairs = query.split(/[;&]/);
            for (let i = 0; i < Pairs.length; i++) {
                let KeyVal = Pairs[i].split(":");
                if (!KeyVal || 2 != KeyVal.length) continue;
                let key = unescape(KeyVal[0]),
                    val = unescape(KeyVal[1]);
                (val = val.replace(/\+/g, " ")), (_params[key] = val);
            }
            return _params;
        })(_scripts[_scripts.length - 1].src.replace(/^[^\?]+\??/, ""));
    const _bkinput = document.querySelector(".bksearch2");
    _bkinput && ((_bkinput.style.margin = "0 0 10px 0"), (_bkinput.placeholder = "Search here.."));
    let _searchData = "";
    let _xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
    function _httpGetAsync(theUrl, callback) {
        return (
            (_xhr.onreadystatechange = function () {
                4 == _xhr.readyState && 200 == _xhr.status && callback(_xhr.responseText);
            }),
                _xhr.open("GET", theUrl, !0),
                _xhr.send(null),
                _xhr
        );
    }
    _bkinput &&
    _bkinput.addEventListener("input", function (e, cb) {
        let query = e.target.value;
        Bkoi.search(query, function (response) {
            !(function (inp, arr, cb) {
                let currentFocus;
                function addActive(x) {
                    if (!x) return !1;
                    !(function (x) {
                        for (let i = 0; i < x.length; i++) x[i].classList.remove("bk-autocomplete-active");
                    })(x),
                    currentFocus >= x.length && (currentFocus = 0),
                    currentFocus < 0 && (currentFocus = x.length - 1),
                        x[currentFocus].classList.add("bk-autocomplete-active");
                }
                function closeAllLists(elmnt) {
                    let x = document.getElementsByClassName("bk-autocomplete-items");
                    for (let i = 0; i < x.length; i++) elmnt != x[i] && elmnt != inp && x[i].parentNode.removeChild(x[i]);
                }
                inp.addEventListener("input", function (e) {
                    let searchResultItem,
                        val = this.value,
                        i = arr.length;
                    if ((closeAllLists(), !val)) return !1;
                    for (currentFocus = -1; Bkoi.container.element.hasChildNodes(); ) Bkoi.container.element.removeChild(Bkoi.container.element.lastChild);
                    for (
                        Bkoi.container.element.setAttribute("id", "bk-autocomplete-list"),
                            Bkoi.container.element.setAttribute("class", "bk-autocomplete-items"),
                            this.parentNode.appendChild(Bkoi.container.element),
                            Bkoi.container.selector = ".bk-autocomplete-items";
                        i--;

                    )
                        (searchResultItem = document.createElement("DIV")).setAttribute("class", Bkoi.container.name),
                            (searchResultItem.innerHTML = "<strong>" + arr[i].address.substr(0, val.length) + "</strong>"),
                            (searchResultItem.innerHTML += arr[i].address.substr(val.length)),
                            (searchResultItem.innerHTML += "<input type='hidden' value='" + JSON.stringify(arr[i]) + " '>"),
                            searchResultItem.addEventListener("click", function (e) {
                                (_searchData = JSON.parse(this.getElementsByTagName("input")[0].value)),
                                    (inp.value = JSON.parse(this.getElementsByTagName("input")[0].value).address),
                                    Bkoi.setSelectedData(_searchData),
                                    cb(JSON.parse(this.getElementsByTagName("input")[0].value)),
                                    closeAllLists();
                            }),
                            Bkoi.container.element.appendChild(searchResultItem);
                }),
                    inp.addEventListener("keydown", function (e) {
                        let x = document.querySelector("#bk-autocomplete-list");
                        x && (x = x.getElementsByTagName("div")),
                            40 == e.keyCode ? (currentFocus++, addActive(x)) : 38 == e.keyCode ? (currentFocus--, addActive(x)) : 13 == e.keyCode && (e.preventDefault(), currentFocus > -1 && x && x[currentFocus].click());
                    }),
                    document.addEventListener("click", function (e) {
                        closeAllLists(e.target);
                    });
            })(_bkinput, response, function (clickedItem) {
                Bkoi.geocode(clickedItem.id, function (res) {
                    (_searchData = res), Bkoi.setSelectedData(_searchData);
                });
            });
        });
    }),
    "undefined" == typeof Bkoi &&
    (window.Bkoi = new (function () {
        if (_params.key) {
            let Bkoi = {
                container: { name: "list-item", element: document.querySelector(".bklist2"), selector: ".bklist2" },
                getSelectedData: function () {
                    return JSON.parse(_searchData).place;
                },
                setSelectedData: function (selectedItem) {
                    _searchData = selectedItem;
                },
                on: function (event, elem, callback, capture) {
                    "function" == typeof elem && ((capture = callback), (callback = elem), (elem = window)),
                        (capture = !!capture),
                    (elem = "string" == typeof elem ? document.querySelector(elem) : elem) && elem.addEventListener(event, function () {}, capture);
                },
            };
            return (
                (Bkoi.onSelect = function (callback) {
                    Bkoi.container.element.addEventListener("click", callback);
                }),
                    (Bkoi.reverseGeo = function (longitude, latitude, cb) {
                        _httpGetAsync("https://barikoi.xyz/v1/api/search/reverse/geocode/" + _params.key + "/place?longitude=" + longitude + "&latitude=" + latitude, function (response) {
                            cb(response);
                        });
                    }),
                    (Bkoi.geocode = function (place_id, cb) {
                        let geoUrl = "https://barikoi.xyz/v1/api/search/geocode/" + _params.key + "/place/" + place_id;
                        var theUrl, callback;
                        (theUrl = geoUrl),
                            (callback = function (response) {
                                cb(response);
                            }),
                            (_xhr.onreadystatechange = function () {
                                4 == _xhr.readyState && 200 == _xhr.status && callback(_xhr.responseText);
                            }),
                            _xhr.open("GET", theUrl, !1),
                            _xhr.send(null);
                    }),
                    (Bkoi.search = function (query, cb) {
                        _httpGetAsync("https://barikoi.xyz/v1/api/search/autocomplete/" + _params.key + "/place?q=" + query, function (response) {
                            return Array.isArray(JSON.parse(response).places) ? cb(JSON.parse(response).places) : cb([]);
                        });
                    }),
                    (Bkoi.nearby = function (longitude, latitude, cb) {
                        _httpGetAsync("https://barikoi.xyz/v1/api/search/nearby/" + _params.key + "/0.5/10?longitude=" + longitude + "&latitude=" + latitude, function (response) {
                            return cb(response);
                        });
                    }),
                    Bkoi
            );
        }
        console.log(" INVALID API KEY ");
    })());
})(window);
