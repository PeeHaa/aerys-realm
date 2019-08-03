import './../scss/app.scss';
import Connection from "./WebSocket/Connection";
import MessageHandler from "./MessageHandler";
import CommandHistory from "./History";

const connection = new Connection();
const messageHandler = new MessageHandler(
    document.querySelector('[name="input"]'),
    document.querySelector('.log'),
    connection,
    new CommandHistory()
);

connection.connect(messageHandler.onIncomingMessage.bind(messageHandler));
