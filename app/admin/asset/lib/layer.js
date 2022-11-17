import { DOM } from "../domcreate/dom.js"

export class Layer {

    constructor() {

        this.wrapper = DOM("div", {
            attr: { class: "layer" }
        })

        this.body = DOM("div", {
            attr: { class: "body" }
        })

        this.head = DOM("div", {
            attr: { class: "head" }
        })

        this.closeHandle = DOM("a", {
            attr: { class: "close btn cursor-pointer", title: "close" },
            inner: DOM("i", {
                attr: { class: "micon-x-fill" }
            })
        })
        this.title = DOM("h4", {
            attr: { class: "title" },
            inner: "Judul"
        })

        this.closeHandle.addEventListener("click", () => {

            this.hide();
        })

        this.head.append(this.title, this.closeHandle)
        this.wrapper.append(this.head, this.body)
        document.body.append(this.wrapper)
    }

    api(e) {
        
        e(this);

        return {
            setFooter: E => {

                this.footer = DOM('div', {
                    attr: { class: "footer" },
                    inner: E()
                })

                this.wrapper.append(this.footer)
            }
        }
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
        setTimeout(() => this.remove(), 200)
    }

    /**
     * trigger remove
     */
    remove() {

        this.wrapper.remove()
    }
}