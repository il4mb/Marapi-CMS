import { DOM } from "../domcreate/dom.js"
import { Layer } from "../lib/layer.js"

let TODO = {
    navbar: () => Navbar(),
    layer : (E) => mLayer(E)
}
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

    if(rawdata) {

        let arr = rawdata.split("."), data = window.MARAPI;
        arr.forEach( E => {

            data = data[E]
        })

        if(data && arr) {

            if( arr && arr[0].toLowerCase() == "theme") {

                theme(data)
            } 
        }
    }
    layer.show();


    /*************************************************** */
    /*************************************************** */
    function theme(data) {

        console.log(data)

        layer.api( E =>{

            E.title.innerHTML = data["params"]['@name']
            E.body.setInner([
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
                                    inner: data["path"]
                                })
                            ]
                        })
                    ]
                })
            ])
        })
    }
}