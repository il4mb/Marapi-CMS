import { DOM } from "../domcreate/dom.js"

export class Layer {

    constructor() {
<<<<<<< HEAD
=======

>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
        this.wrapper = DOM("div", { 
            attr: {class: "layer"}
        })

        this.body = DOM("div", {
            attr: {class: "body"}
        })

        this.head = DOM("div", {
            attr: {class: "head"}
        })

        this.closeHandle = DOM("a", {
<<<<<<< HEAD
            attr: {class: "close"}
=======
            attr: {class: "close btn cursor-pointer", title: "close"},
            inner : DOM("i", {
                attr: {class: "micon-x-fill"}
            })
>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
        })
        this.title = DOM("h4", {
            attr: {class: "title"},
            inner: "Judul"
        })

<<<<<<< HEAD
=======
        this.closeHandle.addEventListener("click", () => {

            this.hide();
        })

>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
        this.head.append(this.title, this.closeHandle)
        this.wrapper.append(this.head, this.body)
        document.body.append(this.wrapper)
    }

<<<<<<< HEAD
=======
    api(e) {
        e(this);
    }

>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
    /**
     * trigger show
     */
    show() {

        setTimeout(() => this.wrapper.classList.add("show"), 200)
    }

    /**
     * trigger hide
     */
    hide() {

        this.wrapper.classList.remove("show")
<<<<<<< HEAD
=======
        setTimeout(() => this.remove(), 200)
>>>>>>> 4c582f2a152cf6f28e8622623bd15b48591fa31c
    }

    /**
     * trigger remove
     */
    remove() {

        this.wrapper.remove()
    }
}