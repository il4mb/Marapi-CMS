/**
 * @author @ilh4mb <Durianbohong@gmail.com>
 */
import { DOM } from "../domcreate/dom.js"
import { Layer } from "./layer.js"

function actionSwitch(element) {
    let act = element.getAttribute('data-act'),
        key = element.getAttribute('act-key'),
        type = 'switch'

    if (!act) {
        throw new Error("actionSwitch() require data-act attribute with string but null givein")
    }
    if (!key) {
        throw new Error("actionSwitch() require act-key attribute with int value but null givein")
    }

    try {

        let hook = doHook();
        hook.onLoaded( E => {

            console.log(E)

            window.location.reload();
        })
        hook.doPost({ act: act, key: key, type: type })

    } catch (e) { throw new Error(e) }
}

function actionDelete(element) {

    let act = element.getAttribute('data-act'),
        key = element.getAttribute('act-key')

    if (!act) {
        console.error("actionDelete() require data-act attribute with string but null givein")
        return;
    }
    if (!key) {
        console.error("actionDelete() require act-key attribute with int value but null givein")
        return;
    }

    try {
        let hook = doHook();
        hook.onLoaded(xhr => {
            let response = JSON.parse(xhr.responseText)
            actionConfirm({
                title: "Delete plugin ?",
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
                                            inner: response['meta']['@name']
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
                                            inner: response['meta']['@author']
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
                                            inner: response['path']
                                        })
                                    ]
                                })
                            ]
                        })
                    ]
                })
            }).onConfirm(() => {

                let delhook = doHook();
                
                delhook.onLoaded(() => {
                    window.location.reload()
                })
                delhook.doPost({ act: act, key: key, type: "delete"})
            })
        })
        hook.doPost({ "act": act, "key": key })
    } catch (e) { throw new Error(e) }
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
 * @returns {onLoaded , doPost , doGet}
 */
function doHook(urlString = "/mrp/api/hook", method = "POST") {

    let xhr = new XMLHttpRequest(),
        callBack = {
            onLoaded: () => { },
            onProgress: () => { },
            onError: () => { }
        }
    let loadUI = loadingAnimation()

    xhr.onload = function () {

        loadUI.done(() => callBack.onLoaded(this))
    };

    /*
    xhr.onprogress = function (event) {
        if (event.lengthComputable) {
            alert(`Received ${event.loaded} of ${event.total} bytes`);
        } else {
            alert(`Received ${event.loaded} bytes`); // no Content-Length
        }

    };
    */

    xhr.onerror = function () {
        alert("Request failed");
    };

    return {
        /**
         * 
         * @param {Function} E callback while load successful
         */
        onLoaded: E => {
            callBack.onLoaded = E
        },

        /**
         * 
         * @param {Object} arrayData data post with key and value
         */
        doPost: arrayData => {

            let formData = new FormData();
            let keys = Object.keys(arrayData)
            keys.forEach(E => {
                if (typeof arrayData[E] == 'object' || typeof arrayData[E] == 'array') {
                    formData.append(E, JSON.stringify(arrayData[E]))
                } else formData.append(E, arrayData[E])

            })

            setTimeout(() => {

                xhr.open("POST", urlString, false)
                xhr.send(formData)
            }, 200)

        },

        /**
         * 
         * @param {Object} arrayData data post with key and value
         */
        doGet: arrayData => {

            urlString = urlConstructor(urlString, arrayData)

            setTimeout(() => {
                xhr.open("GET", urlString, false)
                xhr.send()
            }, 200)
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

            setTimeout(()=> wrapper.remove(),100)

            if (typeof E == "function") {
                E()
            }
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

function Dialog(ttl, txt) {

    let layer = new Layer();
    layer.api(E => {
        E.title.setInner(ttl)
        E.body.setInner([
            DOM("p", {
                inner: txt
            })
        ])
    })

    return layer;
}

export { actionConfirm, doHook, loadingAnimation, urlConstructor, actionDelete, Dialog, actionSwitch }