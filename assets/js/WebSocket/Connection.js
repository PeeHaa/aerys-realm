export default class Connection {
    constructor() {
        this.connected = false;
        this.socket    = null;

        this.onMessage = null;
    }

    connect(onMessage) {
        this.socket = new WebSocket(this.getUrl());

        this.socket.addEventListener('open', () => {
            this.connected = true;

            this.send('connect');
        });

        this.onMessage = onMessage;

        this.socket.addEventListener('message', this.onMessage);
    }

    send(message) {
        if (!this.connected) {
            return;
        }

        this.socket.send(message);
    }

    getUrl() {
        let protocol = 'ws://';

        if (location.protocol === 'https:') {
            protocol = 'wss://';
        }

        return protocol + location.host + '/ws';
    }

    reset() {
        this.socket.close();

        this.connected = false;

        this.connect(this.onMessage);
    }
}
