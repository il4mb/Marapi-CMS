import { DOM } from "../domcreate/dom.js"

export class Layer {

    constructor() {
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
            attr: {class: "close"}
        })
        this.title = DOM("h4", {
            attr: {class: "title"},
            inner: "Judul"
        })

        this.head.append(this.title, this.closeHandle)
        this.wrapper.append(this.head, this.body)
        document.body.append(this.wrapper)
    }

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
    }

    /**
     * trigger remove
     */
    remove() {

        this.wrapper.remove()
    }
}