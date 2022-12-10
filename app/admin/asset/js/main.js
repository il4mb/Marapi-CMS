/**
 * author :  @ilh4mb
 * Email  : <durianbohong@gmail.com>
 */
import { DOM } from "../../../asset/domcreate/dom.js"
import { Layer } from "../../../asset/lib/layer.js"
import { doHook, actionConfirm, actionDelete, Dialog, actionSwitch } from "../../../asset/lib/library.js"

let TODO = {
    navbar: () => Navbar(),
    layer: (E) => mLayer(E),
    confirm: (E) => actionConfirm(E),
    delete: (E) => actionDelete(E),
    switch: (E) => actionSwitch(E)
},
    hookUrl = "/app/admin/api/hook"

window.addEventListener("load", () => {


    
    try {

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

        window.onerror = (e) => {
            Dialog("Error", e).show()
        }
    } catch (e) {

        
    }
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
                    attr: { class: 'btn text-danger bg-danger' },
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

                                hook.doPost({ "act": 'theme', 'kode': 0, "value": data['path'] })
                            })

                        })
                    }
                }),
                DOM("button", {
                    attr: { class: 'btn text-primary bg-primary' },
                    inner: "active",
                    todo: E => {
                        if (data['active'] === true) { E.disabled = true }

                        E.addEventListener('click', () => {
                            let hook = doHook(hookUrl)
                            hook.onLoaded(() => {
                                window.location.reload()
                            })

                            hook.doPost({ "act": 'theme', 'kode': 1, "value": data['path'] })

                        })
                    }
                })
            ]
        })
    }
}
