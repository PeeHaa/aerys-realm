export default class MessageHandler {
    constructor(input, log, connection, history) {
        this.input      = input;
        this.log        = log;
        this.connection = connection;
        this.history    = history;

        this.prefix = '';

        this.input.addEventListener('keydown', this.sendMessageHandler.bind(this));
    }

    sendMessageHandler(e) {
        if (e.key === 'ArrowUp') {
            const previousCommand = this.history.getPrevious();

            if (previousCommand === null) {
                return;
            }

            this.input.value = previousCommand;

            return;
        }

        if (e.key === 'ArrowDown') {
            const nextCommand = this.history.getNext();

            if (nextCommand === null) {
                return;
            }

            this.input.value = nextCommand;

            return;
        }

        if (e.key !== 'Enter') {
            return;
        }

        if (this.input.value.trim() === '') {
            return;
        }

        this.history.push(this.input.value.trim());

        this.connection.send(this.prefix + this.input.value.trim());

        this.input.value = '';
    }

    onIncomingMessage(e) {
        const parsedMessage = JSON.parse(e.data);

        switch (parsedMessage.type) {
            case 'render':
                return this.handleRenderMessage(parsedMessage);

            case 'command':
                return this.handleCommandMessage(parsedMessage);
        }
    }

    handleRenderMessage(message) {
        this.log.insertAdjacentHTML('beforeend', message.html);

        this.prefix = message.prefix;

        this.log.scrollTop = this.log.scrollHeight;

        this.input.setAttribute('type', message.inputType);
    }

    handleCommandMessage(message) {
        if (message.command === 'clear' || message.command === 'reset') {
            while (this.log.firstChild) {
                this.log.removeChild(this.log.firstChild);
            }

            this.history.reset();
        }

        if (message.command === 'reset') {
            this.connection.reset();
            this.history.reset();

            this.handleRenderMessage({
                html: '<pre>This account logged in from another session. Logging you out here.</pre>',
                inputType: 'text',
                prefix: '',
                type: 'render'
            });
        }
    }
}
