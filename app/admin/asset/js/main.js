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

function mLayer() {

    let layer = new Layer();
    layer.show();

}