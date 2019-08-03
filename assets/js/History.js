export default class History {
    constructor() {
        this.reset();
    }

    reset() {
        this.entries = [];
        this.index   = 0;
    }

    push(entry) {
        this.entries.push(entry);

        this.index = 0;
    }

    getPrevious() {
        this.index++;

        if (this.entries.length - this.index < 0) {
            this.index--;

            return null;
        }

        return this.entries[this.entries.length - this.index];
    }

    getNext() {
        this.index--;

        if (this.index < 1) {
            return '';
        }

        if (this.index < 0) {
            this.index++;
            return null;
        }

        return this.entries[this.entries.length - this.index];
    }
}
