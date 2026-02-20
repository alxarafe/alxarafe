(function () {
    const csscls = PhpDebugBar.utils.makecsscls("phpdebugbar-widgets-");

    /**
     * Widget for the displaying translations data
     *
     * Options:
     *  - data
     */
    class TranslationsWidget extends PhpDebugBar.Widget {
        get className() {
            return csscls('translations');
        }

        render() {
            this.statusEl = document.createElement('div');
            this.statusEl.classList.add(csscls('status'));
            this.el.append(this.statusEl);

            this.listWidget = new PhpDebugBar.Widgets.ListWidget({
                itemRenderer: (li, translation) => {
                    const text = translation.key + ": " + translation.value;
                    const line = document.createElement('span');
                    line.classList.add(csscls('name'));
                    line.classList.add(translation.key === translation.value ? 'text-danger' : 'text-muted');
                    line.textContent = text;
                    li.append(line);
                }
            });
            this.el.append(this.listWidget.el);

            this.bindAttr('data', (data) => {
                this.listWidget.set('data', data.translations);
                if (data.translations) {
                    const sentence = data.sentence || "translations were missed for your language";
                    this.statusEl.innerHTML = '';
                    const span = document.createElement('span');
                    span.textContent = data.translations.length + " " + sentence;
                    this.statusEl.append(span);
                }
            });
        }
    }

    PhpDebugBar.Widgets.TranslationsWidget = TranslationsWidget;
})();