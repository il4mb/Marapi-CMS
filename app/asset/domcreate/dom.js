var DOM = (
    element = "div",
    data = {
        attr: {},
        inner: [],
        todo: null
    }
) => {

    let a = document.createElement(element),
        attr = data ? data.attr : {},
        inner = data ? data.inner : '',
        todo = data ? data.todo : null;

    if (attr) {
        Object.keys(attr).forEach((b) => {
            let normalize = b.replace(/[A-Z]/g, '-$&').toLowerCase();
            a.setAttribute(normalize, attr[b]);
        });
    }

    /**
     * 
     * @param {Mix} c = apapun yang akan di masukan ke element 
     */
    a.setInner = (c) => {
        switch (typeof c) {
            case 'function':
                a.innerHTML = null
                a.append(c(a))
                break;

            case 'boolean':
            case 'string':
                a.innerHTML = c;
                break;

            case 'object':
                if (Array.isArray(c)) {
                    c.forEach((d) => {
                        a.append(d);
                    });
                } else {
                    a.append(c);
                }
                break;

            default:
                console.error("（；￣ェ￣） ERROR: can't set inner because value type is unknown !");
                break;
        }
    };

    /**
     * 
     * @returns Mengembalikan isi atau inner dari element
     */
    a.getInner = () => {
        return a.innerHTML;
    };

    /**
     *  event ketika input dengan rule sebagai berikut
     * @param {int} minLength - Maximum karakter
     * @param {int} maxLength - Minimum karakter
     * @param {regex} exeption - Karakter ilegal
     */
    a.onInput = function (minLength, maxLength, exeption = "//g") {
        a.addEventListener("keypress", event => {
            if (event.keyCode != 8 && event.key.match(exeption)) {
                event.preventDefault();
                return false;
            }
        });
        a.addEventListener("keydown", event => {
            if (event.keyCode != 8 && event.key.match(exeption)) {
                event.preventDefault();
                return false;
            }
        });
        a.addEventListener("keyup", event => {
            if (event.keyCode != 8 && event.key.match(exeption)) {
                event.preventDefault();
                return false;
            }
        });
        a.addEventListener("input", () => {
            a.value = a.value.replace(exeption, "");
            a.setAttribute("maxlength", maxLength);
            a.setAttribute("minlength", minLength);
        });
    };

    if (inner) a.setInner(inner);
    if (todo) todo(a);

    return a;
}

export {DOM};