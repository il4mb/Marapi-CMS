/**
 * author :  @ilh4mb
 * Email  : <durianbohong@gmail.com>
 */
import { DOM } from "../../../asset/domcreate/dom.js"
import { Layer } from "../../../asset/lib/layer.js"

let TODO = {
    navbar: () => Navbar(),
    layer: (E) => mLayer(E)
},
    hookUrl = "/mrp/api/hook"

window.addEventListener("load", () => {

    let trigger = document.querySelectorAll("[trigger]")
    trigger.forEach(E => {
        E.addEventListener('click', () => {

            let action = E.getAttribute('trigger')
            if (TODO[action]) {

                TODO[action](E);
            }
        })
    })

    document.addEventListener('click', E => {

        if (E.target.classList.contains('mrp-navbar')) {
            E.target.classList.add('close')
            E.target.classList.remove('open')
        }

    })
})

function Navbar() {

    let navbar = document.querySelectorAll(".mrp-navbar")
    navbar.forEach(E => {
        if (E.classList.contains('close')) {

            E.classList.add('open')
            E.classList.remove('close')

        } else {

            E.classList.remove('open')
            E.classList.add('close')
        }
    })
}

function mLayer(element) {

    let rawdata = element.getAttribute("data")

    let layer = new Layer();

    if (rawdata) {

        let arr = rawdata.split("."), data = window.MARAPI;
        arr.forEach(E => {

            data = data[E]
        })

        if (data && arr) {

            if (arr && arr[0].toLowerCase() == "theme") {

                theme(data)
            }
        }
    }
    layer.show();


    /**
     * LAYER LAYOUT THEME
     * @param {JSON} data - theme data
     */
    function theme(data) {

        layer.api(E => {

            E.title.innerHTML = data["params"]['@name']
            E.body.setInner([
                DOM("div", {
                    attr: { class: "theme-thumbnail" },
                    inner: () => {

                        if (data['active'] === true) {
                            return DOM("a", {
                                attr: { class: 'text-success status' },
                                inner: [
                                    DOM("i", { attr: { class: "micon-check2-circle" } }),
                                    " active"
                                ]
                            })
                        } else return ""
                    }
                }),
                DOM("table", {
                    inner: [
                        DOM("tr", {
                            inner: [
                                DOM('td', {
                                    inner: "Name"
                                }),
                                DOM('td', {
                                    inner: ":"
                                }),
                                DOM('td', {
                                    inner: data["params"]["@name"]
                                })
                            ]
                        }),

                        DOM("tr", {
                            inner: [
                                DOM('td', {
                                    inner: "Author"
                                }),
                                DOM('td', {
                                    inner: ":"
                                }),
                                DOM('td', {
                                    inner: data["params"]["@author"]
                                })
                            ]
                        }),

                        DOM("tr", {
                            inner: [
                                DOM('td', {
                                    inner: "Description"
                                }),
                                DOM('td', {
                                    inner: ":"
                                }),
                                DOM('td', {
                                    inner: data["params"]["@description"]
                                })
                            ]
                        }),
                        DOM("tr", {
                            inner: [
                                DOM('td', {
                                    inner: "Installation Path"
                                }),
                                DOM('td', {
                                    inner: ":"
                                }),
                                DOM('td', {
                                    attr: { style: "font-style: italic; color: rgb(0 0 0 /.5)" },
                                    inner: () => {
                                        let txt = data["path"]
                                        if (txt.substr(txt.length - 1) !== '/') {
                                            return txt + '/'
                                        } else return txt
                                    }
                                })
                            ]
                        })
                    ]
                })
            ])
        }).setFooter(() => {
            return [
                DOM("button", {
                    attr: { class: 'text-danger bg-danger' },
                    inner: "delete",
                    todo: E => {
                        if (data['active'] === true) { E.disabled = true }

                        E.addEventListener('click', () => {

                            // SHOW CONFIRM BEFORE DELETE
                            actionConfirm({

                                title: E => {
                                    E.classList.add("text-danger")
                                    return "Deletion Confirmation"
                                },
                                body: DOM("div", {
                                    inner: [
                                        DOM("p", {
                                            inner: E => {
                                                return "Are you sure want to delete ?"
                                            }
                                        }),
                                        DOM("table", {
                                            attr: { class: "text-secondary" },
                                            inner: [
                                                DOM("tr", {
                                                    inner: [
                                                        DOM("td", {
                                                            inner: "name"
                                                        }),
                                                        DOM("td", {
                                                            inner: ":"
                                                        }),
                                                        DOM("td", {
                                                            inner: data['params']['@name']
                                                        })
                                                    ]
                                                }),

                                                DOM("tr", {
                                                    inner: [
                                                        DOM("td", {
                                                            inner: "author"
                                                        }),
                                                        DOM("td", {
                                                            inner: ":"
                                                        }),
                                                        DOM("td", {
                                                            inner: data['params']['@author']
                                                        })
                                                    ]
                                                }),

                                                DOM("tr", {
                                                    inner: [
                                                        DOM("td", {
                                                            inner: "path"
                                                        }),
                                                        DOM("td", {
                                                            inner: ":"
                                                        }),
                                                        DOM("td", {
                                                            inner: data['path']
                                                        })
                                                    ]
                                                })
                                            ]
                                        })
                                    ]
                                })
                            }).onConfirm(() => {

                                let hook = doHook(hookUrl)
                                hook.onLoaded(() => {
                                   window.location.reload()
                                })

                                hook.doPost({ "key": 'theme', 'kode': 0, "value": data['path'] })
                            })

                        })
                    }
                }),
                DOM("button", {
                    attr: { class: 'text-primary bg-primary' },
                    inner: "active",
                    todo: E => {
                        if (data['active'] === true) { E.disabled = true }

                        E.addEventListener('click', () => {
                            let hook = doHook(hookUrl)
                            hook.onLoaded(() => {
                                window.location.reload()
                            })

                            hook.doPost({ "key": 'theme', 'kode': 1, "value": data['path'] })

                        })
                    }
                })
            ]
        })
    }
}


/**
 * ACTION CONFIRM LAYER LAYOUT
 * @param {*} data 
 * @returns 
 */
function actionConfirm(data) {

    let layer = new Layer(),
        callBack = {
            confirm: () => layer.hide(),
            cancel: () => layer.hide()
        }

    layer.api(E => {

        E.title.setInner(data['title'])

        E.body.setInner(DOM("div", {
            attr: { class: "white-s-prel" },
            inner: [
                DOM("div", {
                    inner: data['body']
                })
            ]
        }))

    }).setFooter(() => {

        return [
            DOM("button", {
                attr: { class: "text-secondary bg-secondary" },
                inner: "close",
                todo: E => {
                    E.addEventListener('click', () => callBack.cancel(layer))
                }
            }),
            DOM("button", {
                attr: { class: "text-danger bg-danger" },
                inner: "confirm",
                todo: E => {
                    E.addEventListener('click', () => callBack.confirm(layer))
                }
            })
        ]
    })

    layer.show()

    return {

        onConfirm: E => {
            callBack.confirm = E
        },
        onCancel: E => {
            callBack.cancel = E
        }
    }

}

/**
 * DO HTTP REQUEST TO BACK-END
 * @param {String} urlString 
 * @param {String} method 
 * @returns 
 */
function doHook(urlString, method = "POST") {

    let xhr = new XMLHttpRequest(),
        callBack = {
            onLoaded: () => { },
            onProgress: () => { },
            onError: () => { }
        }
    let loadUI = loadingAnimation()

    xhr.onload = function () {
        if (xhr.status != 200) { // analyze HTTP status of the response
            alert(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
        } else { // show the result
            // alert(`Done, got ${xhr.response.length} bytes`); // response is the server response

            loadUI.done(() => callBack.onLoaded(this))
        }
    };

    xhr.onprogress = function (event) {
        if (event.lengthComputable) {
            alert(`Received ${event.loaded} of ${event.total} bytes`);
        } else {
            alert(`Received ${event.loaded} bytes`); // no Content-Length
        }

    };

    xhr.onerror = function () {
        alert("Request failed");
    };

    return {
        onLoaded: E => {
            callBack.onLoaded = E
        },

        doPost: arrayData => {

            let formData = new FormData();
            let keys = Object.keys(arrayData)
            keys.forEach(E => {
                if (typeof arrayData[E] == 'object' || typeof arrayData[E] == 'array') {
                    formData.append(E, JSON.stringify(arrayData[E]))
                } else formData.append(E, arrayData[E])

            })

            xhr.open("POST", urlString, false)
            xhr.send(formData)
        },

        doGet: arrayData => {

            urlString = urlConstructor(urlString, arrayData)

            xhr.open("GET", urlString, false)
            xhr.send()
        }
    }
}

function loadingAnimation() {
    let wrapper = DOM("div", {
        attr: { class: "loading-animation" },
    })
    document.body.querySelectorAll(".loading-animation").forEach(E => {
        E.remove()
    })

    document.body.append(wrapper);

    return {
        done: E => {
            setTimeout(() => {
                if (typeof E == "function") {
                    E()
                }
                wrapper.remove()
            }, 1000)
        }
    }
}

/**
 * URL String Constructor 
 * - create url with param from array
 * @param {String} url 
 * @param {Array} array 
 * @returns {String} URL
 */
function urlConstructor(url, array = []) {
    let position = url.search(/(?<=\?).*/gi),
        params = []

    // Extract current url string param
    if (position >= 0) {
        let urlParam = url.substr(position),
            urlParams = urlParam.split("&")

        url = url.replace(/(?=\?).*/gi, '')
        urlParams.forEach(E => {
            let val = E.split("=")
            if (val[0] && val[1]) {
                params[val[0]] = val[1]
            }
        })
    }

    // add or change value of current param
    if (array) {

        let keys = Object.keys(array)
        keys.forEach(E => {
            params[E] = array[E]
        })
    }

    if (Object.keys(params).length > 0) {
        let keys = Object.keys(params)
        url += "?"

        if (keys) {
            let ctr = 0
            keys.forEach(E => {
                if (ctr > 0) {
                    url += '&'
                }
                url += `${E}=${encodeURIComponent(params[E])}`
                ctr++
            })
        }
    }
    return url
}